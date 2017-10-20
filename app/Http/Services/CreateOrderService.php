<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 19:27
 */

namespace App\Http\Services;

use App\Http\Model\Address;
use App\Http\Model\Order;
use App\Http\Model\Orderinfo;
use DB;
use Exception;

class CreateOrderService
{

    public function createOrder($order_id,$type)//$type代表的是那个盘
    {
        if($type==4){
            $total_money=100;
        }
        if($type==5){
            $total_money=300;
        }
        if($type==6){
            $total_money=2000;
        }
        $order=Order::find($order_id);
        $date['user_id']=$order->user_id;
        $date['order_num']=1;
        $date['order_code']=$this->order_num();
        $date['total_money']=$total_money;
        $date['status']=2;
        $date['name']=$order->name;
        $date['phone']=$order->phone;
        $date['province']=$order->province;
        $date['city']=$order->city;
        $date['area']=$order->area;
        $date['address']=$order->address;
        $date['create_at']=time();
        $date['type']=6;
        $date['class']=2;
        DB::beginTransaction();
        try{
            $orderId=Order::insertGetId($date);
            if($orderId){
                $res=$this->getGoodsInfo($order_id,$type,$orderId);
                if($res){
                    DB::commit();
                    return $orderId;
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

    public function getGoodsInfo($order_id,$type,$orderId)//获取商品信息
    {
        $find=Orderinfo::where(['order_id'=>$order_id,'type'=>$type])->first();
        if(!$find){
            $orderInfo=Orderinfo::where(['order_id'=>$order_id])->where('type','>','3')->first();
        }else{
            $orderInfo=$find;
        }
        $data['name']=$orderInfo->name;
        $data['goods_id']=$orderInfo->goods_id;
        if($type==4){
            $data['price']=100;
        }
        if($type==5){
            $data['price']=300;
        }
        if($type==6){
            $data['price']=2000;
        }
        $data['num']=1;
        $data['type']=$type;
        $data['create_at']=time();
        $data['order_id']=$orderId;
        $res=Orderinfo::insert($data);
        if($res){
            return true;
        }
        return false;
    }

    public function order_num()//生成随机订单号
    {
        $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderCode = $code[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderCode;
    }
}