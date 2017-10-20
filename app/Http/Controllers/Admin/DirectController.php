<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Incomerecode;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;

class DirectController extends Controller
{
    protected $incomeRecode;

    public function __construct(Incomerecode $incomeRecode)
    {
        $this->incomeRecode=$incomeRecode;
    }

    public function index(Request $request)//分销列表
    {
        $date=$this->incomeRecode->select(['id','user_id','recode_info','money','create_at','from_id'])
            ->where(['flag'=>1,'type'=>1])->where(function($query) use ($request){
                if($request->has('to_phone')){
                    $to_id=$this->conditionJudge($request->input('to_phone'));
                    $query->orWhere(['user_id'=>$to_id]);
                }
                if($request->has('from_phone')){
                    $to_id=$this->conditionJudge($request->input('from_phone'));
                    $query->orWhere(['from_id'=>$to_id]);
                }
            })->paginate(config('admin.pages'));
        foreach($date->items() as $k=>$v){
            $user=$this->getUserInfo($v['user_id']);
            $date->items()[$k]['to_login_name']=$user->login_name;
            $date->items()[$k]['to_nickname']=$user->name;
            $date->items()[$k]['to_sex']=$user->sex;
            $date->items()[$k]['to_phone']=$user->phone;
            $date->items()[$k]['to_pic']=$user->pic;

            $from_user=$this->getUserInfo($v['from_id']);
            $date->items()[$k]['from_login_name']=$from_user->login_name;
            $date->items()[$k]['from_nickname']=$from_user->name;
            $date->items()[$k]['from_sex']=$from_user->sex;
            $date->items()[$k]['from_phone']=$from_user->phone;
            $date->items()[$k]['from_pic']=$from_user->pic;
        }

        $res=$this->paging($date);
        return view('admin.direct.index',compact('date','res'));
    }

    public function account(Request $request)//用户账户记录列表
    {
        $date=$this->incomeRecode->select(['id','user_id','recode_info','money','create_at','from_id'])
            ->where(['type'=>2])->where(function($query) use ($request){
                if($request->has('to_phone')){
                    $to_id=$this->conditionJudge($request->input('to_phone'));
                    $query->orWhere(['user_id'=>$to_id]);
                }
                if($request->has('from_phone')){
                    $to_id=$this->conditionJudge($request->input('from_phone'));
                    $query->orWhere(['from_id'=>$to_id]);
                }
            })->paginate(config('admin.pages'));
        foreach($date->items() as $k=>$v){
            $user=$this->getUserInfo($v['user_id']);
            $date->items()[$k]['to_login_name']=$user->login_name;
            $date->items()[$k]['to_nickname']=$user->name;
            $date->items()[$k]['to_sex']=$user->sex;
            $date->items()[$k]['to_phone']=$user->phone;
            $date->items()[$k]['to_pic']=$user->pic;

            if($v['from_id']){
                $from_user=$this->getUserInfo($v['from_id']);
                $date->items()[$k]['from_login_name']=$from_user->login_name;
                $date->items()[$k]['from_nickname']=$from_user->name;
                $date->items()[$k]['from_sex']=$from_user->sex;
                $date->items()[$k]['from_phone']=$from_user->phone;
                $date->items()[$k]['from_pic']=$from_user->pic;
            }else{
                $date->items()[$k]['from_login_name']='';
                $date->items()[$k]['from_nickname']='';
                $date->items()[$k]['from_sex']=1;
                $date->items()[$k]['from_phone']='';
                $date->items()[$k]['from_pic']='';
            }
        }

        $res=$this->paging($date);
        return view('admin.direct.account',compact('date','res'));
    }

    public function getUserInfo($id)//获取用户信息
    {
        $user=User::find($id);
        return $user;
    }

    public function conditionJudge($condition)//条件判断的到用户信息
    {
        return User::where(['phone'=>$condition])->value('id');
    }
}
