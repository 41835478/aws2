<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 11:28
 */

namespace App\Http\Services;


use App\Events\RowEvent;
use App\Http\Model\Config;
use App\Http\Model\Incomerecode;
use App\Http\Model\Order;
use App\Http\Model\Orderinfo;
use App\Http\Model\Pointsrecode;
use App\Http\Model\User;
use DB;
use Exception;

class DirectService
{
    public function main($order_id)//分佣主函数
    {
        $order=Order::find($order_id);
        $find=User::where(['id'=>$order->user_id])->first(['pid']);
        $orderInfo=Orderinfo::where(['order_id'=>$order_id])->get(['price','num']);
        $config=$this->configData();
        foreach($orderInfo as $v){
            $res=$this->goSale($order->user_id,$find->pid,$v['price']*$v['num'],$config->yijifenxiao/100,$config->erjifenxiao/100);
            if($res){
                $res2=$this->repeatPoints($order->user_id,$v['price']*$v['num']);
                if($res2){
                    continue;
                }
            }
            return false;
        }
    }

    public function goSale($user_id,$pid,$money,$rate1,$rate2,$num=1)//递归去分佣
    {
        $find=User::where(['id'=>$pid])->first(['pid']);
        if($find){
            if($num<=2){
                $bonus=0;
                if($num==1){
                    $bonus=$rate1*$money;
                }
                if($num==2){
                    $bonus=$rate2*$money;
                }
                $res=$this->mainIncome($user_id,$pid,$bonus);
                if($res){
                    $num++;
                    return $this->goSale($user_id,$find->pid,$money,$rate1,$rate2,$num);
                }
                return false;
            }
        }
        return true;
    }

    public function mainIncome($current_id,$prev_id,$bonus)//分佣记录主函数
    {
        DB::beginTransaction();
        try{
            $res1=User::where(['id'=>$prev_id])->increment('account',$bonus);
            if($res1){
                $res2=User::where(['id'=>$prev_id])->increment('bonus',$bonus);
                if($res2){
                    $from_login_name=User::where(['id'=>$current_id])->value('login_name');
                    $to_login_name=User::where(['id'=>$prev_id])->value('login_name');
                    $info=$from_login_name.'向上级'.$to_login_name.'返分销额'.$bonus.'元';
                    $res3=$this->recodeInfo($prev_id,$info,$bonus,1,1,$current_id);
                    if($res3){
                        DB::commit();
                        return true;
                    }else{
                        throw new Exception();
                    }
                }else{
                    throw new Exception();
                }
            }else{
                throw new Exception();
            }
        }catch(Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function repeatPoints($user_id,$money)//购买正常商品得到复投积分
    {
        $login_name=User::where(['id'=>$user_id])->value('login_name');
        $res=User::where(['id'=>$user_id])->increment('repeat_points',$money);
        if($res){
            $date['user_id']=$user_id;
            $date['flag']=1;
            $date['sign']=1;
            $date['points']=$money;
            $date['points_info']=$login_name.'购买了'.$money.'元钱商品奖励复投积分'.$money;
            $date['create_at']=time();
            $res=Pointsrecode::insert($date);
            if($res){
                return true;
            }
        }
        return false;
    }

    public function recodeInfo($to_user_id,$info,$money,$flag,$type,$from_user_id)//记录信息
    {
        $date['user_id']=$to_user_id;
        $date['recode_info']=$info;
        $date['flag']=$flag;
        $date['money']=$money;
        $date['status']=1;
        $date['type']=$type;
        $date['from_id']=$from_user_id;
        $date['create_at']=time();
        $res=Incomerecode::insert($date);
        if($res){
            return true;
        }
        return false;
    }

    public function configData()
    {
        $config=Config::find(1);
        return $config;
    }
}