<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Rowa;
use App\Http\Model\Rowb;
use App\Http\Model\Rowc;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;

class DiscRowController extends Controller
{
    protected $rowa;
    protected $rowb;
    protected $rowc;

    public function __construct(Rowa $rowa,Rowb $rowb,Rowc $rowc)
    {
        $this->rowa=$rowa;
        $this->rowb=$rowb;
        $this->rowc=$rowc;
    }

    public function index(Request $request)//A盘点位列表
    {
        $date=array();
        $query=$this->rowa->newQuery();
        if($request->has('status'))
            $query->where(['status'=>$request->input('status')]);
        if($request->has('level'))
            $query->where(['current_level'=>$request->input('level')]);
        if($request->has('generate'))
            $query->where(['current_generate'=>$request->input('generate')]);
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
        if($request->has('row'))
            $query->where(['id'=>$request->input('row')])->orWhere(['prev_id'=>$request->input('row')]);
        $date=$query->paginate(config('admin.pages'));
        if($date){
            foreach($date->items() as $k=>$v){
                $user=$this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name']=$user->login_name?$user->login_name:'';
                $date->items()[$k]['sex']=$user->sex;
                $date->items()[$k]['phone']=$user->phone;
                $date->items()[$k]['pic']=$user->pic;
            }
        }
        $res=$this->paging($date);
        return view('admin.discRow.index',compact('date','res'));
    }

    public function rowb(Request $request)//B盘点位列表
    {
        $date=array();
        $query=$this->rowb->newQuery();
        if($request->has('status'))
            $query->where(['status'=>$request->input('status')]);
        if($request->has('level'))
            $query->where(['current_level'=>$request->input('level')]);
        if($request->has('generate'))
            $query->where(['current_generate'=>$request->input('generate')]);
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
        if($request->has('row'))
            $query->where(['id'=>$request->input('row')])->orWhere(['prev_id'=>$request->input('row')]);
        $date=$query->paginate(config('admin.pages'));
        if($date){
            foreach($date->items() as $k=>$v){
                $user=$this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name']=$user->login_name;
                $date->items()[$k]['sex']=$user->sex;
                $date->items()[$k]['phone']=$user->phone;
                $date->items()[$k]['pic']=$user->pic;
            }
        }
        $res=$this->paging($date);
        return view('admin.discRow.rowb',compact('date','res'));
    }

    public function rowc(Request $request)//C盘点位列表
    {
        $date=array();
        $query=$this->rowc->newQuery();
        if($request->has('status'))
            $query->where(['status'=>$request->input('status')]);
        if($request->has('level'))
            $query->where(['current_level'=>$request->input('level')]);
        if($request->has('generate'))
            $query->where(['current_generate'=>$request->input('generate')]);
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
        if($request->has('row'))
            $query->where(['id'=>$request->input('row')])->orWhere(['prev_id'=>$request->input('row')]);
        $date=$query->paginate(config('admin.pages'));
        if($date){
            foreach($date->items() as $k=>$v){
                $user=$this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name']=$user->login_name;
                $date->items()[$k]['sex']=$user->sex;
                $date->items()[$k]['phone']=$user->phone;
                $date->items()[$k]['pic']=$user->pic;
            }
        }
        $res=$this->paging($date);
        return view('admin.discRow.rowc',compact('date','res'));
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
}
