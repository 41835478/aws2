<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;


class CrontabController extends Controller
{
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
        return $this->ajaxMessage(true,'操作成功');
    }
}
