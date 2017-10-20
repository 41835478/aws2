<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\User;
use App\Http\Services\RowService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class CrontabController extends Controller
{
    protected $rowService;

    public function __construct(RowService $rowService)
    {
        $this->rowService=$rowService;
    }

    public function index()//定时任务定时清除用户表中的数据
    {
        User::chunk(100,function($users){
            foreach($users as $user){
                $date['rob_point_num_a']=0;
                $date['rob_point_num_b']=0;
                $date['rob_point_num_c']=0;
                $date['update_at']=time();
                $user->update($date);
            }
        });
    }

    public function wheelLuck()//幸运转盘定时清理
    {
        User::chunk(100,function($users){
            foreach($users as $user){
                $date['lucky']=0;
                $date['update_at']=time();
                $user->update($date);
            }
        });
    }

    public function dealRedis()
    {
        if(Redis::exists('rowa')){
            if(Redis::llen('rowa')>0){
                for($i=0;$i<=80;$i++){
                    $order_id=Redis::lpop('rowa');
                    $this->rowService->index($order_id,4);
                }
            }
        }
        if(Redis::exists('rowb')){
            if(Redis::llen('rowb')>0){
                for($i=0;$i<=80;$i++){
                    $order_id=Redis::lpop('rowb');
                    $this->rowService->index($order_id,5);
                }
            }
        }
        if(Redis::exists('rowc')){
            if(Redis::llen('rowc')>0){
                for($i=0;$i<=80;$i++){
                    $order_id=Redis::lpop('rowc');
                    $this->rowService->index($order_id,6);
                }
            }
        }
    }
}
