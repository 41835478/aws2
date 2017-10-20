<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 16:07
 */

namespace App\Http\Services;


use App\Events\RowEvent;
use App\Http\Model\Order;
use App\Http\Model\Orderinfo;
use App\Http\Model\User;
use Illuminate\Support\Facades\Redis;

class RowCommonService
{
    protected $directService;
    protected $row;
    public function __construct(DirectService $directService,RowService $row)
    {
        $this->directService=$directService;
        $this->row=$row;
    }

    //$order_id 订单id   $type 1、爱无尚商城 2、合作平台 3、100元专区 4、300元专区 5、2000元专区
    public function index($order_id)
    {
        $user_id=Order::where(['id'=>$order_id])->value('user_id');
        $orderInfo=Orderinfo::where(['order_id'=>$order_id])->get(['type','num']);

        foreach($orderInfo as $v){
            if($v['type']==1||$v['type']==3){//要进行分佣
                $this->directService->main($order_id);
            }elseif($v['type']==4||$v['type']==5||$v['type']==6){//要进行排位
                $this->addUserRowPoint($user_id,$v['num'],$v['type']);
                if($v['type']==4){
                    for($i=0;$i<$v['num'];$i++){
                        Redis::rpush('rowa',$order_id);
                    }
                }
                if($v['type']==5){
                    for($i=0;$i<$v['num'];$i++){
                        Redis::rpush('rowb',$order_id);
                    }
                }
                if($v['type']==6){
                    for($i=0;$i<$v['num'];$i++){
                        Redis::rpush('rowc',$order_id);
                    }
                }
            }
        }
        return true;
    }

    public function addUserRowPoint($user_id,$num,$type)//添加用户三网盘点位数量（因为每天有限购每个网只能买10次）
    {
        $user=User::where(['id'=>$user_id])->first(['id','rob_point_num_a','rob_point_num_b','rob_point_num_c']);
        if($type==4){
            $user->rob_point_num_a+=$num;
        }
        if($type==5){
            $user->rob_point_num_b+=$num;
        }
        if($type==6){
            $user->rob_point_num_c+=$num;
        }
        return $user->save();
    }
}