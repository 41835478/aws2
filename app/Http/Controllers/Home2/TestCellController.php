<?php

namespace App\Http\Controllers\Home2;

use App\Http\Controllers\Home\BaseController;
use App\Http\Model\Address;
use App\Http\Model\Order;
use App\Http\Model\Orderinfo;
use App\Http\Model\Rowa;
use App\Http\Model\Rowc;
use App\Http\Model\User;
use App\Http\Services\CreateOrderService;
use App\Http\Services\DirectService;
//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Shou;

use App\Http\Services\RowCommonService;
use App\Http\Services\RowService;
use App\Http\Services\SendCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use DB;
use Cache;
//use Hash;
set_time_limit(66666);
class TestCellController extends BaseController //BaseController
{
    protected $rowCommonService;
    protected $rowService;
    protected $orderRow;
    protected $msg;
    public function __construct(RowCommonService $rowCommonService,RowService $rowService,CreateOrderService $orderRow,SendCodeService $msg)
    {
        $this->rowCommonService = $rowCommonService;
        $this->rowService=$rowService;
        $this->orderRow=$orderRow;
        $this->msg=$msg;
    }

    public function index()
    {

    }

    public function getRowId($rowId,$aim_level,$num=1)//得到对应要向上面第几代缴费的排位点id
    {
        if($num<=$aim_level){
            $prev_id=Rowc::where(['id'=>$rowId])->value('prev_id');
            if($prev_id){
                $num++;
                return $this->getRowId($prev_id,$aim_level,$num);
            }
            return false;
        }
        return $rowId;
    }

    public function getIpAddress($ip)
    {
//        $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip;
//        $res=@file_get_contents($url);
//        if(empty($res)){ return false; }
//        $jsonMatches = array();
//        preg_match('#\{.+?\}#', $res, $jsonMatches);
//        if(!isset($jsonMatches[0])){ return false; }
//        $json = json_decode($jsonMatches[0], true);
//        if(isset($json['ret']) && $json['ret'] == 1){
//            $json['ip'] = $ip;
//            unset($json['ret']);
//        }else{
//            return false;
//        }
//        return $json;

    }

    public function orderInfo()
    {
        $order=Order::where(['status'=>2])->get(['id']);
        foreach($order as $v){
            $orderInfo=Orderinfo::where(['order_id'=>$v['id']])->get(['num','type','order_id']);
            foreach($orderInfo as $val){
                if($v['id']==$val['order_id'])
                {
                    if($val['type']==4){
                        for($i=0;$i<$val['num'];$i++){
                            Redis::rpush('rowa',$v['id']);
                        }
                    }
                    if($val['type']==5){
                        for($i=0;$i<$val['num'];$i++){
                            Redis::rpush('rowb',$v['id']);
                        }
                    }
                    if($val['type']==6){
                        for($i=0;$i<$val['num'];$i++){
                            Redis::rpush('rowc',$v['id']);
                        }
                    }
                }
            }
        }
    }

    public function clearLevel()//清理消费会员
    {
//        $user=User::get(['id','level','locking']);
//        foreach($user as $v){
////            $date['level']=0;
////            $date['locking']=2;
//            User::where(['id'=>$v['id']])->update($date);
//        }
    }

    public function dealRedis()
    {
        if(Redis::exists('rowd')){
            if(Redis::llen('rowd')>0){
                for($i=0;$i<=50;$i++){
                    $order_id=Redis::lpop('rowd');
                        $this->rowService->index($order_id,4);
                }
            }
        }
        if(Redis::exists('rowb')){
            if(Redis::llen('rowb')>0){
                for($i=0;$i<=50;$i++){
                    $order_id=Redis::lpop('rowb');
                    $this->rowService->index($order_id,5);
                }
            }
        }
        if(Redis::exists('rowc')){
            if(Redis::llen('rowc')>0){
                for($i=0;$i<=50;$i++){
                    $order_id=Redis::lpop('rowc');
                    $this->rowService->index($order_id,6);
                }
            }
        }
    }

    public function clearUserAccount($order_id)
    {
        $order=Order::find($order_id);
        return User::where(['id'=>$order->user_id])->increment('account',100);
    }

    public function clearAccount()
    {
        $user=User::get(['id','account','bonus']);
        foreach($user as $v){
            $date['account']=0;
            $date['bonus']=0;
            User::where(['id'=>$v['id']])->update($date);
        }
    }

    public function editUserPwd()//修改用户密码
    {
        $user=User::get(['id','pwd','paypwd']);
        foreach($user as $v){
            $date['pwd']=md5('123456');
            $date['paypwd']=md5('123456');
            User::where(['id'=>$v['id']])->update($date);
        }
    }

//    public function row()//公排测试
//    {
//        for($i=0;$i<4095;$i++){
//            $this->rowService->index(1,4);
//        }
//
//    }

    public function info()
    {
        $i = 1;
        $a = 2;
        while ($i) {
            $a = $a * 2;
            $i++;
        if ($a == 60000000000)
            break;
        }
        echo $i;
    }

    public function loop($phone)
    {
        $ids = Shou::whereIn('phone', $phone)->get(['id', 'phone']);
        $data = [];
        if ($ids) {
            $date = Shou::whereIn('t_phone', $phone)->where('id', '<>', 1)->get(['id', 'pid', 'phone', 't_phone']);
            if ($date) {
                foreach ($ids as $v) {
                    foreach ($date as $k => $val) {
                        if ($v['phone'] == $val['t_phone']) {
                            $data[$k] = $val['phone'];
                            $date1['pid'] = $v['id'];
                            $res = Shou::where(['phone' => $val['phone']])->first();
                            $res2 = $res->save($date1);
                            if (!$res2) {
                                return 1;
                            }
                        }
                    }
                }
                if ($data) {
                    return $this->loop($data);
                }
                return true;
            }
        }
        return 2;
    }

    public function importUser()
    {
        $date = Shou::all(['pid', 'name', 'phone', 'password']);
        foreach ($date as $v) {
            $data['pid'] = $v['pid'];
            $data['login_name'] = $v['name'];
            $data['phone'] = $v['phone'];
            $data['pwd'] = $v['password'];
            $res = User::insert($data);
            if (!$res) {
                return false;
            }
        }
    }

    public function editUser()//修改用户表中的支付密码
    {
        $date = Shou::all(['id']);
        foreach ($date as $v) {
            $data['paypwd'] = md5('123456');
            $res = User::where(['id' => $v['id']])->update($data);
            if (!$res) {
                return false;
            }
        }
    }

//    public function indexx()//index的注释内容
//    {
//        //        dd(DB::table('user')->groupBy('phone')->having('count(phone)','>',1)->get());
////        dd(session()->forget('registerCode'));
////        Cache::forget('yzmCode');
////        Cache::pull('registerCode');
////         $this->msg->yzmsendMsg('18695869572');
////        dd(round(15543.369999999999+56.67589,2));
////        dd(round(510/9,2));
////        dd($this->getRowId(11,4,$num=1));
////        $arr=$this->getIpAddress($_SERVER["REMOTE_ADDR"]);
////        var_dump($arr['country']);
////        var_dump($arr['ip']);
////        $this->clearLevel();
////        $this->dealRedis();
////        dd(Redis::llen('rowc'));
////        $this->orderInfo();
////        $this->clearAccount();
////        $this->startRow();
////        dd(Redis::llen('rowa'));
////        for($i=0;$i<4062;$i++){
////            Redis::rpush('rowd',2);
////        };
////        dd(Redis::lpop('rowa'));
////        die;
////        $this->editUserPwd();
////        Redis::del('rowa');
////        Redis::del('rowb');
////        Redis::del('rowc');
////        dd($this->rowService->getTwentyScore(5,5,100,2.5));
////        die;
////        for($i=0;$i<3;$i++){
////            Redis::rpush('mylist',$i);
////        };
////        die;
////        dd(Redis::exists('mylist'));
////        dd(Redis::lpop('mylist'));
////        dd(phpinfo());
////        $a=rand(1,9);
////        dd(str_repeat($a.',',5));
////        dd(pow(2,0)+pow(2,1)+pow(2,2)+pow(2,3)+pow(2,4)+pow(2,5)+pow(2,6)+pow(2,7)+pow(2,8)+pow(2,9)+pow(2,10)+pow(2,11));
////        $this->row();
////        die;
////        dd(bcpow(2, 16)*8);
////        dd($this->getRowId(4,2,$num=1));
////        dd($this->rowCommonService->index(3));
////        $arr[]='18602695051';
////        dd($this->loop($arr));
////        dd($this->importUser());
////        $this->editUser();
////        die;
//    }
}
