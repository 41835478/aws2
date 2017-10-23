<?php

namespace App\Http\Controllers\Admin2;


use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;
use App\Http\Model\Order2 as Order;
use App\Http\Model\User;

use Exception;

class DataController extends Controller
{

     public function __construct(Order $orderclass,User $user)
    {
        $this->orderclass = $orderclass;
        $this->user = $user;

    }

    public function index()
    {
        #今日开始时间
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        #今日结束时间
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        // 众筹分销奖金统计
        $fenxiao = DB::table('balance_records2')->where('type',1)->where('is_add',1)->sum('num');

        // 众筹订单统计
        $orders = Order::where('status','>',1)->count();
        // 众筹领导奖
        $lingdao = DB::table('balance_records2')->where('type',2)->where('is_add',1)->sum('num');
        // 众筹股东分红
        // 众筹累计收入
        // 众筹累计分红金额

        // var_dump($memberz);die;
        return view('admin.data2.index',compact('orders','lingdao','fenxiao'));
    }

    public function configindex()
    {
        $data=DB::table('config2')->get()->toArray();
        return view('admin.data2.configindex',compact('data'));
    }

    public function configinfo(Request $request){

        
        $post=$request->input();
        if (!empty($post)) {
            $res = DB::table('config2')->where(['id'=>$post['id']])->update(['value'=>$post[$post['id']]]); 
        }
        // $res = DB::table('config2')->where()->update();
        if($res){
            return redirect('admin2/data/configindex')->with('success','操作成功');
        }else{
            return redirect('admin2/data/configindex')->with('success','无需操作');
        }   

       
    }

}
