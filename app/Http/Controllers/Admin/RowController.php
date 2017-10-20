<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Incomerecode;
use App\Http\Model\Promoteinfo;
use App\Http\Model\Promoterecode;
use App\Http\Model\Rowa;
use App\Http\Model\Rowb;
use App\Http\Model\Rowc;
use App\Http\Model\Roworder;
use App\Http\Model\User;
use App\Http\Model\Pointsrecode;
use Illuminate\Http\Request;

use App\Http\Controllers\PublicController as Controller;

class RowController extends Controller
{
    protected $promoteRecode;
    protected $incomeRecode;
    protected $rowOrder;
    protected $pointsrecode;
    protected $promoteInfo;

    public function __construct(Promoterecode $promoteRecode,Incomerecode $incomeRecode,Roworder $rowOrder,Pointsrecode $pointsrecode,Promoteinfo $promoteInfo)
    {
        $this->promoteRecode=$promoteRecode;
        $this->incomeRecode=$incomeRecode;
        $this->rowOrder=$rowOrder;
        $this->pointsrecode=$pointsrecode;
        $this->promoteInfo=$promoteInfo;
    }

    public function index(Request $request)//点位升级列表
    {
        $query=$this->promoteRecode->newQuery();
        if($request->has('disc'))
            $query->where(['flag'=>$request->input('disc')]);
        if($request->has('row'))
            $query->where(['row_id'=>$request->input('row')]);
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
        $date=$query->paginate(config('admin.pages'));
        foreach($date->items() as $k=>$v){
            $user=$this->getUserInfo($v['user_id']);
            $date->items()[$k]['login_name']=$user->login_name;
            $date->items()[$k]['nickname']=$user->name;
            $date->items()[$k]['phone']=$user->phone;
            $date->items()[$k]['sex']=$user->sex;
            $date->items()[$k]['pic']=$user->pic;
        }
        $res=$this->paging($date);
        return view('admin.row.index',compact('date','res'));
    }

    public function point(Request $request)//见点奖列表
    {
        $arr=$this->commonRow($request,3,1);
        $date=$arr['date'];
        $res=$arr['res'];
        return view('admin.row.point',compact('date','res'));
    }

    public function recommend(Request $request)//推荐奖列表
    {
        $arr=$this->commonRow($request,4,1);
        $date=$arr['date'];
        $res=$arr['res'];
        return view('admin.row.recommend',compact('date','res'));
    }

    public function promote(Request $request)//升级奖列表
    {
        $arr=$this->commonRow($request,5,1);
        $date=$arr['date'];
        $res=$arr['res'];
        return view('admin.row.promote',compact('date','res'));
    }

    public function rowOrder(Request $request)//排位订单记录表
    {
        $date=array();
        $query=$this->rowOrder->newQuery();
        if($request->has('disc'))
            $query->where(['type'=>$request->input('disc')]);
        if($request->has('row'))
            $query->where(['row_id'=>$request->input('row')]);
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
        $date=$query->paginate(config('admin.pages'));
        if($date){
            foreach($date->items() as $k=>$v){
                $user=$this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name']=$user->login_name;
                $date->items()[$k]['nickname']=$user->name;
                $date->items()[$k]['phone']=$user->phone;
                $date->items()[$k]['sex']=$user->sex;
                $date->items()[$k]['pic']=$user->pic;
            }
        }
        $res=$this->paging($date);;
        return view('admin.row.rowOrder',compact('date','res'));
    }

     public function integral(Request $request)//积分记录表
    {
        $date=array();
        $query=$this->pointsrecode->newQuery();
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
           
       
        $date=$query->paginate(config('admin.pages'));
        if($date){
            foreach($date->items() as $k=>$v){
                $user=$this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name']=$user->login_name;
                $date->items()[$k]['nickname']=$user->name;
                $date->items()[$k]['phone']=$user->phone;
                $date->items()[$k]['sex']=$user->sex;
                $date->items()[$k]['pic']=$user->pic;
            }
        }
        $res=$this->paging($date);;
        return view('admin.row.integral',compact('date','res'));
    }
    public function commonRow($request,$type,$flag)
    {
        $date=array();
        $date=$this->incomeRecode->select(['id','user_id','recode_info','money','create_at','from_id'])
            ->where(['flag'=>$flag,'type'=>$type])->where(function($query) use ($request){
                if($request->has('to_phone')){
                    $to_id=$this->conditionInfo($request->input('to_phone'));
                    $query->where(['user_id'=>$to_id]);
                }
                if($request->has('money')){
                    $query->where(['money'=>$request->input('money')]);
                }
                if($request->has('from_phone')){
                    $to_id=$this->conditionInfo($request->input('from_phone'));
                    $query->where(['from_id'=>$to_id]);
                }
            })->paginate(config('admin.pages'));
        if($date){
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
        }
        $arr['res']=$this->paging($date);
        $arr['date']=$date;
        return $arr;
    }

    public function promoteInfo(Request $request)//升级信息记录列表
    {
        $date=array();
        $query=$this->promoteInfo->newQuery();
        if($request->has('disc'))
            $query->where(['flag'=>$request->input('disc')]);
        if($request->has('current_level'))
            $query->where(['current_level'=>$request->input('current_level')]);
        if($request->has('row'))
            $query->where(['to_row_id'=>$request->input('row')]);
        if($request->has('phone')){
            $user_info=$this->conditionInfo($request->input('phone'));
            $query->where(['user_id'=>$user_info['user_id']]);
        }
        $date=$query->orderBy('create_at','desc')->paginate(config('admin.pages'));
        if($date){
            foreach($date as $k=>$v){
                $user=$this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name']=$user->login_name;
                $date->items()[$k]['nickname']=$user->name;
                $date->items()[$k]['sex']=$user->sex;
                $date->items()[$k]['phone']=$user->phone;
                $date->items()[$k]['pic']=$user->pic;
            }
        }
        $res=$this->paging($date);
        return view('admin.row.promoteInfo',compact('date','res'));
    }

    public function rowa()//A盘排位列表
    {

    }

    public function rowb()//B盘排位列表
    {

    }

    public function rowc()//C盘排位列表
    {

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
