<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;
use App\Http\Model\Order;
use App\Http\Model\User;

use Exception;

class DataController extends Controller
{

     public function __construct(Order $orderclass,User $user)
    {
        $this->orderclass = $orderclass;
        $this->user = $user;

    }

    public function index(){

        #今日开始时间
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        #今日结束时间
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

        #累计会员总量
        $memberz=DB::table('user')->where('level','>=','1')->count();
        #历史收入累计
        $lsorder=DB::table('order')->where('status','>',1)->sum('total_money');
        #历史排位收入累计
        $pworder=DB::table('roworder')->sum('money');
        #今日会员总计
        $memberj=DB::table('user')->where('level','>=','1')->whereBetween('create_at',[$beginToday,$endToday])->count();
        

        #已发放体现金额
        $withdrawz=DB::table('withdraw')->where('status',1)->sum('money');
        #今日提现总额
        $withdraw=DB::table('withdraw')->where('status',1)->whereBetween('update_at',[$beginToday,$endToday])->sum('money');


        #未消费会员统计
        $wmember=DB::table('user')->where('level',0)->count();
        #今日订单统计
        $jorder=DB::table('order')->where('status','>',1)->whereBetween('update_at',[$beginToday,$endToday])->count();
        #用户总余额
        $useraccount=DB::table('user')->sum('account');
        // var_dump($memberz);die;
        return view('admin.data.index',compact('memberz','memberj','withdrawz','withdraw','wmember','jorder','lsorder','pworder','useraccount'));
    }
    #系统参数
    public function configindex(){
        $res=DB::table('config')->where('id',1)->first();


        return view('admin.data.configindex',compact('res')); 
    }

    public function configinfo(Request $request){

        
        $post=$request->input();
        $id=$post['id'];
        $data=[];
        $data['tixanshu']=$post['tixanshu'];
        $data['zpoint_a']=$post['zpoint_a'];
        $data['zpoint_b']=$post['zpoint_b'];
        $data['zpoint_c']=$post['zpoint_c'];
        $data['xjifen']=$post['xjifen'];
        $data['fjifen']=$post['fjifen'];
        $data['tixian']=$post['tixian'];
        $data['zhuanzhang']=$post['zhuanzhang'];
        $data['erjifenxiao']=$post['erjifenxiao'];
        $data['yijifenxiao']=$post['yijifenxiao'];
        $data['fanxian']=$post['fanxian'];


        $res=DB::table('config')->where('id',1)->update($data);
        if($res){

         
            return redirect('data/configindex')->with('success','操作成功');
        }else{
            return redirect('data/configindex')->with('success','无需操作');
        }   

       
    }
    #统计前二十名订单总量
    public function oneorder(){

       
        $this->team();


        
       
        return back()->withErrors('操作成功');
       
    

    }




    //计算团队排行
    public function team(){
     #每周开始时间
        $beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
        #每周结束时间
        $endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7,date('Y'));
        #查询订单    
        $users =$this->user->get();
        $yj = array();
       
        $all_money = 0;
        $arr = array();
        
        foreach($users as $k=>$v){
             $order_all = $this->orderclass->where(['user_id'=>$v['id']])->where('status','>=',2)->whereBetween('create_at',[$beginLastweek,$endLastweek])->get();
             if($order_all){
                foreach ($order_all as $key => $value) {
                 $all_money += $value['total_money'];           
                }

                $arr[$k]['user_id']   = $v['id'];
                $arr[$k]['total_money'] = $all_money;
             }   
        }
        arsort($arr);
        #加载配置
        $res=DB::table('config')->where('id',1)->first();
        $res=$res->fanxian;


            $num=0;
            foreach ($arr as $k => $v) {
                //var_dump($arr);die;
                if($num < 20){
                    #插入用户余额
                    $nmoney=$v['total_money'] * $res * 0.01 ;

                    $ress=$this->user->where('id',$v['user_id'])->increment('account',$nmoney);

                    $data=[];
                    $data['user_id']=$v['user_id'];
                    $data['money']=$nmoney;
                    $data['status']=1;
                    $data['create_at']=time();
                    $rres=DB::table('balance')->insert($data);
                    $num=$num+1;
                }
             
            }
       
        return true;
}





}
