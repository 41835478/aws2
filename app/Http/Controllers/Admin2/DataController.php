<?php

namespace App\Http\Controllers\Admin2;


use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;
use App\Http\Model\Order2 as Order;
use App\Http\Model\User;
use App\Http\Model\Config2;
use App\Http\Model\Investment2;


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

        $order = DB::table('order2')->where('id',$orderId)->first(); 
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

        DB::table('investments2')->insert($data);

        return 'true';
    }


    #众筹订单分红
    public function orderStatusMoney()
    {
        #求出购买订单的用户
        // $orderUser = Investment2::where(['status'=>1])->pluck('user_id');
        // $orderId = Investment2::where(['status'=>1])->pluck('id');
        // if (!count($orderUser)) {
        //     return 'true';
        // }
        #要插入详情表的数组
        #合并相同的用户id
        // $orderUser = array_unique($orderUser);
        
        $orderInfo = DB::table('investments2')->where(['status'=>1])->select('id','user_id','give_allmoney','give_money')->get();

        if (!count($orderInfo)) {
            return 'false';
        }        
        $data = [];
        #组合详情数组
        foreach ($orderInfo as $k => $v) {
            #修改发送金额
            $edit = [];
            $mm = 0;
            $money = $v->give_allmoney * ( Config2::getConfig(3) / 100 );
            if ( ($money + $v->give_money) >= $v->give_allmoney ) {
                $edit['status'] = 2;
                $edit['give_money'] = $v->give_allmoney;
                $edit['give_todaymoney'] = $v->give_allmoney - $v->give_money;
                $mm = $v->give_allmoney - $v->give_money;
            
            }else{
                $edit['give_money'] = $v->give_money + $money;
                $edit['give_todaymoney'] = $money;
                $mm = $money;
            }
            #修改订单分红金额
            DB::table('investments2')->where('id',$v->id)->update($edit);

            $data[] = self::addData($v,$mm);
        }

        DB::table('balance_records2')->insert($data);
        return 'true';

    }

    #组装添加静态分红详情数据
    public static function addData($orderInfo,$mm)
    {
        return [
            'user_id'=>$orderInfo->user_id,
            'num'=>$mm,
            'type'=>4,
            'info'=>'众筹静态分红',
            'created_at'=> date('Y-m-d H:i:s',time())
        ];
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


    // public function add()
    // {
    //     $id = db::table('user')->pluck('id');

    //     for ($i=0; $i < 10000 ; $i++) { 
    //         $data = [];
    //         $data['user_id'] = $id[$i];
    //         $data['money'] = ($i +1) * 100 ;
    //         $data['give_money'] = 0;
    //         $data['give_allmoney'] = (($i +1) * 100) * (1 + ( ( Config2::getConfig(1) ) / 100 )  ) ;
    //         $data['order_id'] = $i+1;
    //         $data['created_at'] = date('Y-m-d H:i:s',time());
    //         $data['updated_at'] = date('Y-m-d H:i:s',time());

    //         DB::table('investments2')->insert($data);
    //     }
    // }
}
