<?php

namespace App\Http\Controllers\Admin;

use App\Events\ActiveLogEvent;
use App\Http\Model\User;
use App\Http\Model\Wheel;
use App\Http\Model\Wheellist;
use App\Http\Requests\Admin\WheelRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;

class WheelController extends Controller
{
    protected $wheel;
    protected $wheelList;

    public function __construct(Wheel $wheel,Wheellist $wheelList)
    {
        $this->wheel=$wheel;
        $this->wheelList=$wheelList;
    }

    public function index()//加载添加幸运转盘配置视图
    {
        $total=0;
        $find=$this->wheel->find(1);
        if($find){
            $total=$find->angel_1+$find->angel_2+$find->angel_3+$find->angel_4+$find->angel_5+$find->angel_6;
        }
        return view('admin.wheel.index',compact('find','total'));
    }

    public function editWheel(WheelRequest $request)//执行修改转盘配置操作
    {
        $date=$request->except('_token');
        $total=$date['angel_1']+$date['angel_2']+$date['angel_3']+$date['angel_4']+$date['angel_5']+$date['angel_6'];
        if($total<100||$total>100){
            return back()->withErrors('六块比率总和只能是100%，请重新设置');
        }else{
            $db=$this->wheel->find(1);
            if($db){
                $res=$this->wheel->where(['id'=>1])->update($date);
            }else{
                $res=$this->wheel->insert($date);
            }
            if($res){
                event(new ActiveLogEvent('修改幸运转盘配置'));
                return back()->with('success','修改幸运转盘配置成功');
            }
            return back()->withErrors('修改失败');
        }
    }

    public function wheelList(Request $request)//转盘列表
    {
        $date=array();
        $query=$this->wheelList->newQuery();
        if($request->has('prize'))
            $query->where('prize','like',$request->input('prize').'%');
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
        $date=$query->paginate(config('admin.pages'));
        if($date){
            foreach($date->items() as $k=>$v){
                $user=$this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name']=$user->login_name;
                $date->items()[$k]['phone']=$user->phone;
                $date->items()[$k]['sex']=$user->sex;
                $date->items()[$k]['pic']=$user->pic;
                $date->items()[$k]['lucky']=$user->lucky;

            }
        }
        $wheel=$this->wheel->find(1);
        $res=$this->paging($date);;
        return view('admin.wheel.wheelList',compact('date','res','wheel'));
    }

    public function getUserInfo($user_id)//获取用户信息
    {
        $user=User::find($user_id);
        return $user;
    }

    public function conditionInfo($phone)
    {
        $user['user_id']=User::where('phone',$phone)->value('id');
        return $user;
    }

    public function judgeTotal(Request $request)//判断六块中和不能超过100
    {
        $date=$request->except('_token');
        $total=0;
        $status=true;
        $message='获取数据成功';
        $data=array();
        foreach($date as $k=>$v){
            if(is_int($v)){
                $total+=$v;
            }else{
                $status=false;
                $message='第'.($k+1).'块比率配置不是整数';
                break;
            }
        }
        $data['data']=$total;
        return $this->ajaxMessage($status,$message,$data);
    }
}
