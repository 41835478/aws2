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
        $orders = DB::table('investments2')->count();
        // 众筹领导奖
        $lingdao = DB::table('balance_records2')->where('type',2)->where('is_add',1)->sum('num');
        //众筹静态分红奖
        $static = DB::table('balance_records2')->where('type',4)->where('is_add',1)->sum('num');

        $orderMoney = DB::table('investments2')->sum('money');
        // 众筹股东分红
        // 众筹累计收入
        // 众筹累计分红金额
        return view('admin.data2.index',compact('orders','lingdao','fenxiao','static','orderMoney'));
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
    protected static function orderStatusMoney()
    {
        
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
            $return = DB::table('investments2')->where('id',$v->id)->update($edit);
            // if (!$return) {
            //     file_put_contents("jingtai.txt",$v->id.":".$money."元---".date('Y-m-d H:i:s'),FILE_APPEND );
            // }
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

    #组装添加领导奖详情数据
    public static function addDatas($userId,$level,$mm)
    {
        return [
            'user_id'=>$userId,
            'level'  =>$level,
            'num'    =>$mm,
            'type'   =>2,
            'info'   =>'领导激励奖',
            'created_at'=> date('Y-m-d H:i:s',time())
        ];
    }


    #领导团队奖
    public static function LeaderTeamPrize()
    {
        #求出有上级的用户集合
        $users = DB::table('user')->select('id','pid')->get(); 
        $users = json_decode(json_encode($users),true);
        foreach ($users as $k => $v) {
            $return = self::CalculatedAmount($v['id'],$users);
            // if ($return == "false") {
            //     file_put_contents("lingdao.txt","$v['id']"."------".date('Y-m-d H:i:s'),FILE_APPEND );
            // }
        }
    }

    #计算领导奖金额
    public static function CalculatedAmount($userId,$users)
    {
        #查出用户的直推人数
        $zhitui = DB::table('user')->where(['pid'=>$userId])->count();

        if (!$zhitui) {
            return 'false';
        } 
        #系统设置的直推级别
        $zhitui1 = Config2::getConfig(14);
        $truezhitui = 0;
        #判断使用哪个查询级别限制
        $zhitui < $zhitui1 ? $truezhitui = $zhitui : $truezhitui = $zhitui1;

        #等级代id集合
        $generation = [];
        #发几代奖
        for ($i=1; $i <= $truezhitui ; $i++) { 
            #查出指定用户的指定级别下的用户id集合
            $generation[$i] = self::getChilden([$userId],$i) ? self::getChilden([$userId],$i) : [] ;   
        }

        #每代发奖金比例
        $limitMoney = Config2::getConfig([15,16,17,18,19,20,21,22,23,24]);

        #直推多少人发钱限制
        $limitGrade =  Config2::getConfig([25,26,27,28]);

        $newM = 0;
        $insertD = [];

        foreach ($generation as $k => $v) {
            #判断应该每层发多少钱,判断限额
            $money = self::GradeGetMoney($v,$zhitui,$limitGrade,$newM);
            if ($money) {
                $insertD[] = self::addDatas($userId,$k,$money);
            }
            $newM +=$money;

        }
        DB::table('balance_records2')->insert($insertD);
    }

    #等级发领导奖
    public static function LevelJudge($level,$zhitui,$money,$newM)
    {       


        $insertD[] = self::addDatas($userId,$k,$todayMoney);
        
    }

    #根据等级和已发金额求出此等级应发金额
    public static function GradeGetMoney($id,$zhitui,$limitGrade,$putAllMoney)
    {   
        $todayMoney = DB::table('investments2')->whereIn('user_id',$id)->sum('give_todaymoney');
        $money = $todayMoney + $putAllMoney;

        if ( 0< $zhitui &&  $zhitui<= $limitGrade[0] ) {
            if( $money > 1000){
                return 1000 - $putAllMoney;
            }else{
                return $todayMoney;
            }
        }else if ( $limitGrade[0]< $zhitui &&  $zhitui <= $limitGrade[1] ) {
            if( $money > 2000){
                return 2000 - $putAllMoney;
            }else{
                return $todayMoney;
            }
        }else if ( $limitGrade[1]< $zhitui &&  $zhitui <= $limitGrade[2] ) {
            if( $money > 4000){
                return 4000 - $putAllMoney;
            }else{
                return $todayMoney;
            }
        }else if ( $limitGrade[2]< $zhitui &&  $zhitui <= $limitGrade[3] ) {
            if( $money > 8000){
                return 8000 - $putAllMoney;
            }else{
                return $todayMoney;
            }
        }else{
            if( $money > 8000){
                return 8000 - $putAllMoney;
            }else{
                return $todayMoney;
            }
        }

    } 


    /**
    *查询要查询用户指定级别内的所有下级id
    *$uid:要查询用户集合
    *$class:要查询的级别
    *$userall:静态变量占位
    *$users:用户集合
    *return----查询指定用户的指定级别内的所有下级id集合(包括自己)
    */
    public static function getChildenAll_class($uid,$users,$userall = '',$class=''){
        if(empty($userall)){
            static $userall = [];
        }else{
            static $userall = [];
            $userall = [];
        }
        if(!in_array($uid, $userall)) {
            if(is_array($uid)){
                foreach($uid as $v){
                    $userall[] = $v;
                }
            }else{
                array_push($userall, $uid);
            }
        }
        $userChildren = [];
        foreach($users as $k=>$v){
            if(is_array($uid)){
                if(in_array($v['pid'],$uid)){
                    array_push($userChildren,$v['id']);
                } 
            }else{
                if($v['pid'] == $uid){
                    array_push($userChildren,$v['id']);
                } 
            }
        }
        $userall = array_unique(array_merge($userall, $userChildren));
        if(!empty($userChildren)){
            if($class){
                $class--;
                if($class > 0){
                    self::getChildenAll_class($userChildren,$users,'',$class);
                }       
            }else{
                self::getChildenAll_class($userChildren,$users);
            }
        }
        sort($userall);

        // dump($userall);
        return $userall;
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


    // public static function add()
    // {
    //     $id = db::table('user')->where('pid','>',0)->pluck('id');

    //     for ($i=0; $i < 10000 ; $i++) { 
    //         $data = [];
    //         $data['user_id'] = $id[rand(1,6000)];
    //         $data['money'] = [100,200,500,30000][rand(0,3)] ;
    //         $data['give_money'] = 0;
    //         $data['give_allmoney'] = $data['money'] * (1 + ( ( Config2::getConfig(1) ) / 100 )  );
    //         $data['order_id'] = $i+1;
    //         $data['created_at'] = date('Y-m-d H:i:s',time());
    //         $data['updated_at'] = date('Y-m-d H:i:s',time());

    //         DB::table('investments2')->insert($data);
    //     }
    // }
}
