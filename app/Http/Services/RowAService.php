<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 15:41
 */

namespace App\Http\Services;

use App\Http\Model\Incomerecode;
use App\Http\Model\Looppoint;
use App\Http\Model\Promoterecode;
use App\Http\Model\Rowa;
use App\Http\Model\Roworder;
use App\Http\Model\User;
use DB;
use Exception;

class RowAService
{
    protected $createOrder;
    protected $rowService;

    public function __construct(CreateOrderService $createOrder,RowService $rowService)
    {
        $this->createOrder=$createOrder;
        $this->rowService=$rowService;
    }

    //$row_id:上级盘位id  $now_row_id:当前盘位id  $flag:当前是那个盘  $user_id:当前用户id  $current_level:当前点位的等级
    public function index($date)
    {
//        \Log::info($date);
        $row_id=$date['prev_id'];
        $now_row_id=$date['row_id'];
        $flag=$date['type'];
        $user_id=$date['user_id'];
        $current_level=$date['current_level'];
        $order_id=$date['order_id'];
        $res=$this->setPromoteRecode($now_row_id,$flag,$user_id,$current_level);
        if($res){
            if($row_id){
                return $this->getSelfPrevInfo($now_row_id,$row_id,$order_id);
            }
            return true;
        }
        return false;
    }

    public function getRowId($rowId,$aim_level,$num=1)//得到对应要向上面第几代缴费的排位点id
    {
        if($num<=$aim_level){
            $rowA=Rowb::where(['id'=>$rowId])->value('prev_id');
            if($rowA){
                $num++;
                return $this->getRowId($rowA->prev_id,$aim_level,$num);
            }
            return false;
        }
        return $rowId;
    }

    public function getSelfPrevInfo($now_row_id,$aim_row_id,$order_id)
    {
        $from_row=Rowa::where(['id'=>$now_row_id])->first(['id','user_id','current_level']);
        $to_row=Rowa::where(['id'=>$aim_row_id])->first(['id','user_id','current_level','current_generate']);
        return $this->updateDynasty($from_row,$to_row,$order_id);
    }

    public function updateDynasty($from_row,$to_row,$order_id)//升级循环判断
    {
        $feeConfig=$this->feeConfig($to_row->current_generate,$to_row->current_level);
        $where=array('row_id'=>$to_row->id,'current_level'=>$to_row->current_level,'user_id'=>$to_row->user_id,'flag'=>1);
        if($to_row->current_generate<=3){
            $main=$this->commonDynasty($to_row,$from_row,$feeConfig,$where);
            if($main){
                $res2=Promoterecode::where($where)->first(['promote_fee','aim_level']);
                if($res2->promote_fee>=$feeConfig['promoteFee']){
                    $up_row_id=$this->getRowId($to_row->id,$res2->aim_level,$num=1);
                    if($up_row_id){
                        $main1=$this->mainFunc2($up_row_id,$to_row->user_id,$feeConfig['promoteFee'],$res2->aim_level);
                        if($main1){
                            $res3=$this->startPromote($to_row->id,$res2->aim_level,$to_row->current_generate+1,$where);
                            if($res3){
                                return $this->getSelfPrevInfo($to_row->id,$up_row_id,$order_id);
                            }
                        }
                        return false;
                    }else{
                        return $this->startPromote($to_row->id,$res2->aim_level,$to_row->current_generate+1,$where);
                    }
                }
                return true;
            }
            return false;
        }
        if($to_row->current_generate==4){
            $main=$this->commonDynasty($to_row,$from_row,$feeConfig,$where);
            if($main){
                $res2=Promoterecode::where($where)->first(['promote_fee','aim_level']);
                if($res2->promote_fee>=$feeConfig['promoteFee']){
                    $date['promote_fee']=$res2->promote_fee-$feeConfig['promoteFee'];
                    $res3=$this->setPromoteRecode($to_row->id,1,$to_row->user_id,$to_row->current_level+1,$date);
                    if($res3){
                        $data['promote_fee']=$feeConfig['promoteFee'];
//                        $data['status']=2;
                        $data['update_at']=time();
                        $res4=Promoterecode::where($where)->where('status',1)->update($data);
                        if(!$res4){
                            return false;
                        }
                        $up_row_id=$this->getRowId($to_row->id,$res2->aim_level,$num=1);
                        if($res2->aim_level==12){
                            $current_generate=$to_row->current_generate+1;
                        }else{
                            $current_generate=$to_row->current_generate;
                        }
                        if($up_row_id){
                            $main1=$this->mainFunc2($up_row_id,$to_row->user_id,$feeConfig['promoteFee'],$res2->aim_level);
                            if($main1){
                                $res3=$this->startPromote($to_row->id,$res2->aim_level,$current_generate,$where);
                                if($res3){
                                    return $this->getSelfPrevInfo($to_row->id,$up_row_id,$order_id);
                                }
                            }
                            return false;
                        }else{
                            return $this->startPromote($to_row->id,$res2->aim_level,$current_generate,$where);
                        }
                    }
                    return false;
                }
                return true;
            }
            return false;
        }
        if($to_row->current_generate>=5){
            $where=array('row_id'=>$to_row->id,'current_generate'=>$to_row->current_generate,'type'=>1,'user_id'=>$to_row->user_id);
            $point=Looppoint::where($where)->first(['money']);
            if(!$point){
                $res=$this->writeLoopPoint($to_row->id,$to_row->user_id,$to_row->current_generate,$feeConfig['deductFee']);
            }else{
                $res1=Looppoint::where($where)->increment('money',$feeConfig['deductFee']);
                if(!$res1){
                    return false;
                }
                $res=Looppoint::where($where)->increment('point_money',$feeConfig['deductFee']);
            }
            if($res){
                $res2=$this->mainFunc($to_row->user_id,$from_row->user_id,$from_row->current_level,$feeConfig['redFee']);
                if($res2){
                    if($point->money==2400){
                        $res3=Looppoint::where($where)->decrement('money',$point->money);
                        if(!$res3){
                            return false;
                        }
                        $point_money=Looppoint::where($where)->value('point_money');
                        if($to_row->current_generate==12){
                            if($point_money==$feeConfig['pointFee']){//说明该出局了
                                return $this->outDisc($to_row->id,$to_row->user_id);
                            }
                        }else{
                            if($point_money==$feeConfig['pointFee']){//说明该生代了
                                $res4=Rowa::where(['id'=>$to_row->id])->increment('current_generate',1);
                                if(!$res4){
                                    return false;
                                }
                            }
                        }
                        return $this->loopPoint($order_id);//公排大循环
                    }
                    return true;
                }
            }
            return false;
        }
    }

    public function outDisc($row_id,$user_id)//12代要出局了
    {
        $date['status']=2;
        $date['update_at']=time();
        $rowOrder=Roworder::where(['row_id'=>$row_id,'user_id'=>$user_id,'type'=>1])->update($date);
        if($rowOrder){
            $data['status']=2;
            $data['update_at']=time();
            $row=Rowa::where(['row_id'=>$row_id,'user_id'=>$user_id])->update($data);
            if($row){
                return true;
            }
        }
        return false;
    }

    public function loopPoint($order_id)//开始三个盘进行循环
    {
        $order_id=$this->createOrder->createOrder($order_id,4);
        return $this->rowService->index($order_id,1);//这里是不是需要三个进程
    }

    public function writeLoopPoint($row_id,$user_id,$current_generate,$money)//在A盘5-8代内向表中写入数据
    {
        $date['user_id']=$user_id;
        $date['row_id']=$row_id;
        $date['current_generate']=$current_generate;
        $date['money']=$money;
        $date['point_money']=$money;
        $date['type']=1;
        $date['create_at']=time();
        return Looppoint::inster($date);
    }

    public function commonDynasty($to_row,$from_row,$feeConfig,$where)//公共的升级函数
    {
        $find=Promoterecode::where($where)->first();
        if(!$find){
            $rowA=Rowa::find($to_row->id);
            $res=$this->setPromoteRecode($to_row->id,1,$rowA->user_id,$rowA->current_level);
            if(!$res){
                return false;
            }
        }
        $res1=Promoterecode::where($where)->increment('promote_fee',$feeConfig['deductFee']);
        if($res1) {
            if($feeConfig['redFee']){
                return $this->mainFunc($to_row->user_id, $from_row->user_id, $from_row->current_level, $feeConfig['redFee']);
            }
            return true;
        }
        return false;
    }

    public function startPromote($rowId,$aim_level,$generate,$where)//升级改变升级表和排单表
    {
        DB::beginTransaction();
        try{
            $rowA=Rowa::find($rowId);
            $rowA->current_level=$aim_level;
            $rowA->current_generate=$generate;
            $res=$rowA->save();
            if($res){
                $date['status']=2;
                $date['update_at']=time();
                $promote=Promoterecode::where($where)->where('status',1)->update($date);
                if($promote){
                    DB::commit();
                    return true;
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

    public function setPromoteRecode($now_row_id,$flag,$user_id,$current_level,$date=array())//向点位升级表中插入当前点位的升级信息
    {
        $date['row_id']=$now_row_id;
        $date['current_level']=$current_level;
        $date['aim_level']=$current_level+1;
        $date['flag']=$flag;
        $date['status']=1;
        $date['user_id']=$user_id;
        $date['create_at']=time();
        $res=Promoterecode::insert($date);
        if($res){
            return true;
        }
        return false;
    }

    public function mainFunc($user_id,$from_id,$current_level,$redPacket)//向上级返红包
    {
        $to_login_name=User::where(['id'=>$user_id])->value('login_name');
        $from_login_name=User::where(['id'=>$from_id])->value('login_name');
        DB::beginTransaction();
        try{
            $info=$from_login_name.'向上'.$current_level.'级'.$to_login_name.'返红包'.$redPacket;
            $res2=$this->writeIncomeRecode($user_id,$info,1,$redPacket,$from_id,3);
            if($res2){
                if($redPacket){
                    $res=$this->writeUser($from_id,$redPacket);
                    if(!$res){
                        throw new Exception();
                    }
                }
                DB::commit();
                return true;
            }else{
                throw new Exception();
            }
        }catch(Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function mainFunc2($to_row_id,$from_id,$money,$current_level)//向上级交升级费
    {
        $rowA=Rowa::find($to_row_id);
        $to_login_name=User::where(['id'=>$rowA->user_id])->value('login_name');
        $from_login_name=User::where(['id'=>$from_id])->value('login_name');
        $info=$from_login_name.'向上'.$current_level.'级'.$to_login_name.'交升级费'.$money;
        DB::beginTransaction();
        try{
            $res1=$this->writeIncomeRecode($rowA->user_id,$info,1,$money,$from_id,5);
            if($res1){
                $res=$this->writeUser($rowA->user_id,$money);
                if(!$res){
                    throw new Exception();
                }
                DB::commit();
                return true;
            }else{
                throw new Exception();
            }
        }catch(Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function writeUser($user_id,$redNum)//$redNum存入余额的红包的钱
    {
        $res=User::where(['id'=>$user_id])->increment('account',$redNum);
        if($res){
            return User::where(['id'=>$user_id])->increment('bonus',$redNum);
        }
        return false;
    }

    public function writeIncomeRecode($user_id,$recode_info,$flag,$money,$from_id,$type)//写入账户收支记录表
    {
        $date['user_id']=$user_id;
        $date['recode_info']=$recode_info;
        $date['flag']=$flag;
        $date['money']=$money;
        $date['status']=1;
        $date['from_id']=$from_id;
        $date['type']=$type;
        $date['create_at']=time();
        return Incomerecode::inster($date);
    }

    /**
     * @param $dynasty
     * @return array
     */
    public function feeConfig($dynasty,$level)//$dynasty 第几代 通过当前代数得到要向上级交的升级费，上级的到的见点奖，上级的每个点的见点扣的费用
    {
        $date=array();
        if($dynasty==1){
            $date['promoteFee']=100;
            $date['deductFee']=50;
            $date['redFee']=0;
        }
        if($dynasty==2){
            $date['promoteFee']=300;
            $date['deductFee']=75;
            $date['redFee']=25;
        }
        if($dynasty==3){
            $date['promoteFee']=2000;
            $date['deductFee']=250;
            $date['redFee']=50;
        }
        if($dynasty==4){
            if(in_array($level,[4,5,6,7])){
                $date['promoteFee']=3000;
            }
            if(in_array($level,[8,9,10,11])){
                $date['promoteFee']=4000;
            }
            $date['deductFee']=1750;
            $date['redFee']=500;
        }
        if($dynasty==5){
            $date['deductFee']=600;
            $date['redFee']=2400;
            $date['pointFee']=19200;
        }
        if($dynasty==6){
            $date['deductFee']=600;
            $date['redFee']=2400;
            $date['pointFee']=38400;
        }
        if($dynasty==7){
            $date['deductFee']=600;
            $date['redFee']=2400;
            $date['pointFee']=76800;
        }
        if($dynasty==8){
            $date['deductFee']=600;
            $date['redFee']=2400;
            $date['pointFee']=153600;
        }
        if($dynasty==9){
            $date['deductFee']=2400;
            $date['redFee']=2400;
            $date['pointFee']=1228800;
        }
        if($dynasty==10){
            $date['deductFee']=2400;
            $date['redFee']=2400;
            $date['pointFee']=2457600;
        }
        if($dynasty==11){
            $date['deductFee']=2400;
            $date['redFee']=2400;
            $date['pointFee']=4915200;
        }
        if($dynasty==12){
            $date['deductFee']=2400;
            $date['redFee']=2400;
            $date['pointFee']=9830400;
        }
        return $date;
    }
}