<?php

namespace App\Http\Controllers\Home2;

use App\Http\Controllers\Controller;
use App\Http\Model\BalanceRecord2;
use App\Http\Model\Orderinfo2 as Orderinfo;
use App\Http\Model\User;
use App\Http\Services\LimitPayService;
use App\Services\AccountRecordService;
use App\Services\InvestmentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Services\AuthService;
use App\Http\Services\RowCommonService;


class ShopController extends Controller
{
    const USER_ID = 'home_user_id';      //用户session名
    const LUNBO = 'advertisement';  //轮播图
    const GOODS = 'goods2';          //商品表
    const CART = 'goodscart2';       //购物车表
    const ADDRESS = 'address';      //用户地址表
    const ORDER = 'order2';          //订单表
    const ORDER_INFO = 'order_info2';    //订单详情表
    const USER = 'user';                //用户表
    const GOODSCLASS = 'goodsclass';    //商品分类表

    protected $rowCommonService;
    protected $limitPayService;
    protected $investmentService;
    protected $accountService;

    public function __construct(RowCommonService $rowCommonService, LimitPayService $limitPayService, InvestmentService $investmentService, AccountRecordService $recordService)
    {
        $this->rowCommonService = $rowCommonService;
        $this->limitPayService = $limitPayService;
        $this->investmentService = $investmentService;
        $this->accountService = $recordService;
    }

    //首页
    public function index()
    {
//        dd('系统正在维护');
        #查询用户信息
        $lunbo = DB::table(self::LUNBO)->where(['type' => 1, 'status' => 0])->get();    //轮播图
        $goods = DB::table(self::GOODS)->orWhereIn('type', ['4', '5', '6'])->where(['status' => 1])->get();
        $zcgoods = DB::table(self::GOODS)->orWhereIn('type', ['4', '5', '6'])->where(['status' => 1])->get();
        $return = [
            'lunbo' => $lunbo,
            'goods' => $goods
        ];


        return view('home2.shop.index', $return);
    }


    //商品详情
    public function goodsDetail()
    {
        $id = $_REQUEST['id'];
        $goods = DB::table(self::GOODS)->where(['id' => $id])->first();
        $goods->small_pic = trim($goods->small_pic, ']"');
        $goods->small_pic = trim($goods->small_pic, '"[');
        $goods->small_pic = explode('","', $goods->small_pic);
//        var_dump($goods);
        $return = [
            'goods' => $goods
        ];
        return view('home2.shop.goodsDetail', $return);
    }


    //购物车
    public function cart()
    {
        $auth = new AuthService();
        $user_id = $auth->rememberDecrypt(\Session::get('home_user_id'));
        $cart = DB::table(self::CART)->where(['user_id' => $user_id])->get()->toArray();
        foreach ($cart as $k => $v) {
            $cart[$k]->goods = DB::table(self::GOODS)->where(['id' => $v->goods_id])->first();
        }
        $return = [
            'cart' => $cart
        ];
        return view('home2.shop.cart', $return);
    }

    //加入购物车
    public function addCart()
    {
        $auth = new AuthService();
        $user_id = $auth->rememberDecrypt(\Session::get('home_user_id'));
        //--------------------------------------------------------每天的限购---------------------------------------------------------------------------
//        $limitPay=$this->limitPayService->index($_REQUEST['num'],$_REQUEST['goods_id'],$user_id);//用于判断每天限购10次对于每个网盘
//        if(!$limitPay){
//            return 501;
//        }

        $insert['num'] = $_REQUEST['num'];
        $insert['goods_id'] = $_REQUEST['goods_id'];
        $insert['user_id'] = $user_id;
        $insert['create_at'] = time();
        $goods = DB::table(self::GOODS)->where(['id' => $insert['goods_id']])->first();
        $insert['price'] = round($insert['num'] * $goods->price, 2);
        $res = DB::table(self::CART)->where(['user_id' => $insert['user_id'], 'goods_id' => $insert['goods_id']])->first();
        if ($res) {
            $update['num'] = $res->num + $insert['num'];
            if ($update['num'] > 5) {
                $update['num'] = 5;
            }
            $update['price'] = $res->price + $insert['price'];
            $yn = DB::table(self::CART)->where(['id' => $res->id])->update($update);
        } else {
            $yn = DB::table(self::CART)->insert($insert);
        }

        if ($yn) {
            echo 1;
        } else {
            echo 2;
        }
    }

    //修改购物车数量
    public function cartEdit()
    {
        $update['num'] = $_REQUEST['num'];
        if ($update['num'] > 5) {
            $update['num'] = 5;
        }
        $id = $_REQUEST['id'];//
        //-----------------------------------------------------每天限购10次--------------------------------------------------------------------------
//        $cart=DB::table(self::CART)->where(['id'=>$id])->first(['user_id','goods_id']);
//        $limitPay=$this->limitPayService->index($_REQUEST['num'],$cart->goods_id,$cart->user_id);//用于判断每天限购10次对于每个网盘
//        if(!$limitPay){
//            return 501;
//        }

        DB::table(self::CART)->where(['id' => $id])->update($update);
        echo 1;
    }

    //删除购物车
    public function cartDel()
    {
        $all_id = explode(',', trim($_REQUEST['xz_arr'], ','));
        $res = DB::table(self::CART)->whereIn('id', $all_id)->delete();
        echo $res;
    }

//-----------------------------------------------------每天限购10次--------------------------------------------------------------------------
    public function judgeLimitPay(Request $request)//限购每天只能买10次每个盘
    {
        $auth = new AuthService();
        $user_id = $auth->rememberDecrypt(\Session::get('home_user_id'));
        if ($request->has('cart_id')) {
            $cart_id = explode(',', $request->input('cart_id'));
            $cart = DB::table(self::CART)->whereIn('id', $cart_id)->get()->toArray();
            if (empty($cart)) {
                echo "<script>location.href='/shop/cart'</script>";
                exit;
            }
            foreach ($cart as $k => $v) {
                $type = DB::table(self::GOODS)->where(['id' => $v->goods_id])->value('type');
                if (in_array($type, [4, 5, 6])) {
                    $limitPay = $this->limitPayService->index($v->num, $v->goods_id, $user_id);//用于判断每天限购10次对于每个网盘
                    if (!$limitPay) {
                        return 501;
                    }
                }
            }
        } else {
            $goods_id = $request->input('goods_id');
            $num = $request->input('num');
            $limitPay = $this->limitPayService->index($num, $goods_id, $user_id);//用于判断每天限购10次对于每个网盘
            if (!$limitPay) {
                return 501;
            }
        }
        return 500;
    }

    //购物车确认
    public function submitOrders(Request $request)
    {
        $auth = new AuthService();
        $user_id = $auth->rememberDecrypt(\Session::get('home_user_id'));
        $all_money = 0;
        $goods = '';
        $cart = '';
        if (!empty($_REQUEST['goods_id'])) {
            $goods = DB::table(self::GOODS)->where(['id' => $_REQUEST['goods_id']])->first();
            $goods->paynum = abs($_REQUEST['num']);
            $all_money = round($goods->price * abs($_REQUEST['num']), 2);
        } else {
            $cart_id = explode(',', $_REQUEST['cart_id']);
            $cart = DB::table(self::CART)->whereIn('id', $cart_id)->get()->toArray();
            if (empty($cart)) {
                echo "<script>location.href='/home2/shop/cart'</script>";
                exit;
            }
            foreach ($cart as $k => $v) {
                $cart[$k]->goods = DB::table(self::GOODS)->where(['id' => $v->goods_id])->first();
                $all_money += ($v->price * $v->num);
            }
        }
        if (session('default_address')) {
            $address = DB::table(self::ADDRESS)->where(['id' => session('default_address')])->first();
        } else {
            $address = DB::table(self::ADDRESS)->where(['user_id' => $user_id])->where(['default' => 1])->first();
            if (!$address) {
                $address = DB::table(self::ADDRESS)->where(['user_id' => $user_id])->first();
            }
        }

        // dd($address);
        if (!$address) {
            echo "<script>location.href='/users/shippingaddress?gh=1'</script>";
        }
        if ($all_money <= 0) {
            return view('home2.shop.index');
        }
        // dd(2);
        $return = [
            'address' => $address,
            'cart' => $cart,
            'goods' => $goods,
            'all_money' => $all_money
        ];
        $request->session()->forget(['cart_id', 'goods_id', 'goods_num', 'default_address', 'all_money']);
        if (!empty($cart_id)) {
            session(['cart_id' => $cart_id]);
        }
        if (!empty($goods)) {
            session(['goods_id' => $goods->id]);
            session(['goods_num' => $goods->paynum]);
        }
        session(['default_address' => $address->id]);
        session(['all_money' => $all_money]);

        return view('home2.shop.submitOrders', $return);
    }

    //跳转支付页
    public function payment(Request $request)
    {
        $auth = new AuthService();
        $user_id = $auth->rememberDecrypt(\Session::get('home_user_id'));

        $user = User::find($user_id);
        $result = $this->investmentService->money($user);
        if ($result == 1) { //用户投资超额 300000
            return back()->withErrors('账号投资超额');
        } elseif ($result == 2) {//今日投资超额30000
            return back()->withErrors('今日投资超额');
        }
        if (empty($user_id)) {
            return redirect(url('alipay/index', ['order_id' => $_REQUEST['order_id']]));
//            "{{url('alipay/index',['order_id'=>$_REQUEST[\'order_id\']])}}"
        }
        if (empty(session('default_address')) || empty(session('all_money')) || !empty($_REQUEST['order_id'])) {
            $user = DB::table(self::USER)->where(['id' => $user_id])->first();
            $order = DB::table(self::ORDER)->where(['id' => $_REQUEST['order_id']])->first();
            $order_info = DB::table(self::ORDER_INFO)->where(['order_id' => $order->id])->get()->toArray();
            $order->fx = 1;
            foreach ($order_info as $k => $v) {
                if ($v->type < 4) {
                    $order->fx = 2;
                    break;
                }
            }
            $return = [
                'order' => $order,
                'user' => $user,
                'is_weixin' => $this->isWeiXin()
            ];
            return view('home2.shop.payment', $return);
        }

        $address = DB::table(self::ADDRESS)->where(['id' => session('default_address')])->orderByDesc('default')->first();


        $add_order['user_id'] = $user_id;
        $add_order['order_code'] = orderNum();
        $add_order['order_num'] = 1;
        $add_order['total_money'] = session('all_money');
        $add_order['status'] = 1;
        $add_order['name'] = $address->name;
        $add_order['phone'] = $address->phone;
        $add_order['province'] = $address->province;
        $add_order['city'] = $address->city;
        $add_order['area'] = $address->area;
        $add_order['address'] = $address->address;
        $add_order['create_at'] = time();
        $order_id = DB::table(self::ORDER)->insertGetId($add_order);
        if ($order_id) {
            $add_info['order_id'] = $order_id;
            if (!empty(session('cart_id'))) {
                $goods_num = 0;
                $carts = DB::table(self::CART)->whereIn('id', session('cart_id'))->get()->toArray();
                foreach ($carts as $k => $v) {
                    $goods = DB::table(self::GOODS)->where(['id' => $v->goods_id])->first();
                    $add_info['goods_id'] = $goods->id;
                    $add_info['name'] = $goods->name;
                    $add_info['price'] = $goods->price;
                    $add_info['num'] = abs($v->num);
                    $add_info['create_at'] = time();
                    $add_info['update_at'] = time();
                    DB::table(self::ORDER_INFO)->insert($add_info);
                    //商品销量增加
                    DB::table(self::GOODS)->where(['id' => $v->goods_id])->increment('sale', abs($v->num));
                    $goods_num += abs($v->num);
                }
                DB::table(self::ORDER)->where(['id' => $order_id])->update(['order_num' => $goods_num]);
                DB::table(self::CART)->whereIn('id', session('cart_id'))->delete();
            } else {
                $goods = DB::table(self::GOODS)->where(['id' => session('goods_id')])->first();
                $add_info['goods_id'] = $goods->id;
                $add_info['name'] = $goods->name;
                $add_info['price'] = $goods->price;
                $add_info['num'] = abs(session('goods_num'));
                $add_info['create_at'] = time();
                $add_info['update_at'] = time();
                DB::table(self::ORDER_INFO)->insert($add_info);
                DB::table(self::ORDER)->where(['id' => $order_id])->update(['order_num' => $add_info['num']]);
            }
        }
        $new_order = DB::table(self::ORDER)->where(['id' => $order_id])->first();
        if ($new_order->order_num < 1) {
            DB::table(self::ORDER)->where(['id' => $order_id])->delete();
        }
        $request->session()->forget(['cart_id', 'goods_id', 'goods_num', 'default_address', 'all_money']);
        echo "<script>location.href='/home2/shop/payment?order_id={$order_id}'</script>";
        exit;
    }

    //商品分类
    public function BaihuoMall()
    {
        $type = $_REQUEST['type'];
        $class = DB::table(self::GOODSCLASS)->where(['type' => $type, 'pid' => 0])->get()->toArray();
        foreach ($class as $k => $v) {
            $class[$k]->children = DB::table(self::GOODSCLASS)->where(['type' => $type, 'pid' => $v->id])->get()->toArray();
        }
//        dd($class);
        $return = [
            'class' => $class,
        ];
        return view('home2.shop.BaihuoMall', $return);
    }

    //商品列表
    public function goodsList()
    {
//        $users = DB::table(self::USER)->get()->toArray();
//        getChildenAll(1,$users,1);exit;
        $goods = DB::table(self::GOODS)->where(['status' => 1])->get()->toArray();
        $title = '众筹商品列表';
        $return = [
            'goods' => $goods,
            'title' => $title
        ];
        return view('home2.shop.goodsList', $return);
    }

    // 余额支付
    public function order_pay()
    {

        $order_id = $_REQUEST['order_id'];
        $password = $_REQUEST['password'];
        $auth = new AuthService();
        $user_id = $auth->rememberDecrypt(\Session::get('home_user_id'));
        $user = User::find($user_id);
        $result = $this->investmentService->money($user);
        if ($result) { //用户投资超额或者今日投资超额
            echo 3;
            exit;
        }
        if (md5($password) != $user->paypwd) {
            echo 2;
            exit;
        }
        $order = DB::table('order2')->where(['id' => $order_id])->first();

        if ($order->total_money > $user->account) {
            echo 3;
            exit;
        }
        if ($order->total_money <= 0) {
            echo 3;
            exit;
        }
        //更改订单状态
        $update['status'] = 2;
        $update['type'] = 3;
        DB::table('order2')->where(['id' => $order_id])->update($update);
        //用户余额扣除
        DB::table('user')->where(['id' => $user->id])->decrement('account', $order->total_money);

//        $accountRecord = $this->accountService->setAccountRecord($user_id, $order->total_money, BalanceRecord2::TYPE_INVESTMENT, '参加众筹', 2);

//        if ($accountRecord) {
        $account['user_id'] = $user_id;
        $account['recode_info'] = '购买众筹商品';
        $account['flag'] = 2;
        $account['money'] = $order->total_money;
        $account['status'] = 1;
        $account['create_at'] = time();
        $account['type'] = 2;
        DB::table('incomerecode')->insert($account);
        $res = $this->investmentService->investment($user->id, $order->id);

        if ($res) {
            \Log::info('余额支付分销成功');
            echo 1;
            exit;
        } else {
            \Log::info('余额支付分销失败');
            echo 3;
            exit;
        }
//        }

        echo 3;
    }

    public function recash_point(Request $request)//复投积分支付
    {
        $orderId = $request->only('order_id')['order_id'];
        $payPwd = $request->only('password')['password'];
        $auth = new AuthService();
        $user_id = $auth->rememberDecrypt(\Session::get('home_user_id'));
        $user = DB::table('user')->where(['id' => $user_id])->first();
        if (md5($payPwd) != $user->paypwd) {
            return 2;//支付密码错误
        } else {
            $arr1 = [1, 2, 3];
            $arr2 = Orderinfo::where(['order_id' => 1])->pluck('type')->toArray();
            $arr = array_intersect($arr1, $arr2);
            if (!empty($arr)) {
                return 3;//说明该订单中有不是专区的商品
            } else {
                $order = DB::table('order')->where(['id' => $orderId])->first();
                if ($order->total_money > $user->repeat_points) {
                    echo 4;//复投积分不足
                } else {
                    //更改订单状态
                    $update['status'] = 2;
                    $update['type'] = 4;
                    DB::table('order')->where(['id' => $orderId])->update($update);
                    //用户复投积分扣除
                    DB::table('user')->where(['id' => $user->id])->decrement('repeat_points', $order->total_money);
                    $account['user_id'] = $user_id;
                    $account['recode_info'] = '购买商品';
                    $account['flag'] = 2;
                    $account['money'] = $order->total_money;
                    $account['status'] = 1;
                    $account['create_at'] = time();
                    $account['type'] = 2;
                    DB::table('incomerecode')->insert($account);
                    $userDb = DB::table('user')->where(['id' => $user_id])->first();
                    if ($userDb->level != 1) {
                        DB::table('user')->where(['id' => $user_id])->update(['level' => 1]);
                    }
                    $this->rowCommonService->index($order->id);
                    echo 1;
                }
            }
        }
    }

    public function paySuccess()
    {
        return view('home2.shop.paySuccess');
    }

    public function rankingList()
    {
        dd('敬请期待');
        $team = team();
        $num = 0;
        $yj = array();
        $rs = array();
        foreach ($team['yj'] as $k => $v) {
            if ($num < 20) {
                $yj[$num] = DB::table('user')->where(['id' => $k])->first();
                $yj[$num]->all_money = $v;
            }
            $num++;
        }
        $num = 0;
        foreach ($team['rs'] as $k => $v) {
            if ($num < 20) {
                $rs[$num] = DB::table('user')->where(['id' => $k])->first();
                $rs[$num]->all_user = $v;
            }
            $num++;
        }
        $return = [
            'yj' => $yj,
            'rs' => $rs
        ];

        return view('home2.shop.rankingList', $return);
    }

    //判断是否是微信
    public function isWeiXin()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'))//说明当前环境是微信
        {
            return true;
        }
        return false;
    }

}

/**
 * 随机生成订单号
 */
function orderNum()
{
    $num = date('Y') . date('m') . time() . rand(1, 100);
    $res = DB::table('order')->where(['order_code' => $num])->first();
    if ($res) {
        orderNum();
    } else {
        return $num;
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
function getChildenAll($uid, $users, $userall = '', $class = '')
{
    if (empty($userall)) {
        static $userall = [];
    } else {
        static $userall = [];
        $userall = [];
    }
    if (!in_array($uid, $userall)) {
        if (is_array($uid)) {
            foreach ($uid as $v) {
                $userall[] = $v;
            }
        } else {
            array_push($userall, $uid);
        }
    }

    $userChildren = [];
    foreach ($users as $k => $v) {
        if (is_array($uid)) {
            if (in_array($v->pid, $uid)) {
                array_push($userChildren, $v->id);
            }
        } else {
            if ($v->pid == $uid) {
                array_push($userChildren, $v->id);
            }
        }
    }
    $userall = array_unique(array_merge($userall, $userChildren));
    if (!empty($userChildren)) {
        if ($class) {
            $class--;
            if ($class > 0) {
                getChildenAll($userChildren, $users, '', $class);
            }
        } else {
            getChildenAll($userChildren, $users);
        }
    }
    sort($userall);
    // array_shift($userall);   //删除自己
    return $userall;
}

//计算团队排行
function team()
{
    $time = getMonth();
    $order_all = DB::table('order')->whereBetween('update_at', $time)->whereNotIn('status', ['1'])->get()->toArray();
    $order_detail = DB::table('order_info')->whereIn('type', ['4', '5', '6'])->get()->toArray();
    foreach ($order_all as $k => $v) {
        $order_all[$k]->all_money = 0;
        foreach ($order_detail as $k1 => $v1) {
            if ($v1->order_id == $v->id) {
                $order_all[$k]->all_money += ($v1->num * $v1->price);
            }
        }
    }
    foreach ($order_all as $k => $v) {
        if (empty($v->all_money)) {
            unset($order_all[$k]);
        }
    }
    $users = DB::table('user')->select('id', 'pid')->get()->toArray();
    $yj = array();
    $rs = array();
    foreach ($users as $k => $v) {
        $yj[$v->id] = 0;
        $children = getChildenAll($v->id, $users, 1, 20);
        $rs[$v->id] = count($children);
        foreach ($order_all as $k1 => $v1) {
            if (in_array($v1->user_id, $children)) {
                $yj[$v->id] += $v1->all_money;
            }
        }
    }
    arsort($yj);
    arsort($rs);
    $return['yj'] = $yj;
    $return['rs'] = $rs;
    return $return;
}

function getMonth()
{
    $return[0] = strtotime(date('Y-m', time()) . '-1 00:00:00');
    $return[1] = strtotime(date('Y-m') . '-' . date('t') . ' 23:59:59');
    return $return;
}

