<?php

namespace App\Http\Controllers\Admin2;


use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;
use App\Http\Model\Order2 as Order;
use App\Http\Model\User;
use App\Http\Model\Config2;

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

    #把众筹订单写入investments2表中
    public function insertInvestments2($orderId)
    {
        $order = db::table('order2')->where('id',$orderId)->first(); 

        #判断订单存在不存在
        if (!count($order)) {
            return 'false';
        }

        if ($order->status <= 1) {
            return 'false';
        }

        $data = [];
        $data['user_id'] = $order->user_id;
        $data['money'] = $order->total_money ;
        $data['give_money'] = 0;
        $data['give_allmoney'] = $order->total_money * (1 + ( ( Config2::getConfig(1) ) / 100 )  ) ;
        $data['order_id'] = $orderId;
        $data['created_at'] = date('Y-m-d H:i:s',$order->create_at);
        $data['updated_at'] = date('Y-m-d H:i:s',$order->create_at);

        db::table('investments2')->insert($data);

        return 'true';

    }

    #领导团队奖
    public function LeaderTeamPrize()
    {

    }

    /**
     * 获取指定级别下级
     * @param $uid char 要查询下级的用户集合id；如[1,2,3]
     * @param $num int   要查询的级别
     * @return 查询级别的用户下级
     */
    public static function getChilden($uid,$num = 1){
        $user1 = DB::table('user')->whereIn('pid',$uid)->select('id','pid')->get();
        $user1 = json_decode(json_encode($user1),true);

        $users_id = [];
        foreach($user1 as $k=>$v){
            $users_id[] = $v['id'];
        }

        for($i = 1;$i < $num;$i++){
            if(!$users_id){
                return $users_id;
            }
            $users_id = self::getChilden($users_id,$num-1);
            return $users_id;
        }
        return $users_id;
    }

    #查询无限下级用户id
    #$id []
    public static function child($id,$data = [])
    {   
        $user1 = DB::table('user')->whereIn('pid',$id)->pluck('id');
        $user1 = json_decode(json_encode($user1),true);
        if ($user1) {
            $allUser = [];
            foreach ($user1 as $k => $v) {
                $data[] = $v;
                $allUser[] = $v;
            }
            $data = self::child($allUser,$data);
        }else{
            $data = array_merge($user1,$data);
        }
            return $data;
    }

}
