<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4
 * Time: 19:40
 */

namespace App\Http\Services;


use App\Http\Model\Goods;
use App\Http\Model\User;

class LimitPayService
{
    public function index($num,$goods_id,$user_id)//限购
    {
        $user=User::where(['id'=>$user_id])->first(['rob_point_num_a','rob_point_num_b','rob_point_num_c']);
        $type=Goods::where(['id'=>$goods_id])->value('type');
        if($type==4){//A盘
            if($user->rob_point_num_a<config('home.ROWA_NUM')){
                if($user->rob_point_num_a+$num>config('home.ROWA_NUM')){
                    return false;
                }
                return true;
            }
            return false;
        }
        if($type==5){//B盘
            if($user->rob_point_num_b<config('home.ROWB_NUM')){
                if($user->rob_point_num_b+$num>config('home.ROWB_NUM')){
                    return false;
                }
                return true;
            }
            return false;
        }
        if($type==6){//C盘
            if($user->rob_point_num_c<config('home.ROWC_NUM')){
                if($user->rob_point_num_c+$num>config('home.ROWC_NUM')){
                    return false;
                }
                return true;
            }
            return false;
        }
        return true;
    }
}