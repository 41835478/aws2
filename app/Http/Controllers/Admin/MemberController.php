<?php

namespace App\Http\Controllers\Admin;

use App\Events\ActiveLogEvent;
use App\Http\Model\Balance;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;
use App\Http\Model\User;
use App\Http\Model\Order;
use App\Http\Model\Address;
use App\Http\Model\Orderinfo;
use Exception;

use App\Http\Services\AuthService;
use App\Http\Services\RowCommonService;


class MemberController extends Controller
{
    protected $memberclass;
    protected $rowCommonService;
    protected $balance;

    public function __construct(RowCommonService $rowCommonService, User $memberclass, Balance $balance)
    {
        $this->memberclass = $memberclass;
        $this->rowCommonService = $rowCommonService;
        $this->balance = $balance;
    }


    #会员列表
    public function index(Request $request)
    {


        $input = $request->only(['name', 'phone', 'start', 'end', 'level', 'pphone', 'status']);
        if ($mem = User::where('phone', $input['pphone'])->first()) {
            $mem = $mem->toArray();
        }

        $query = $this->memberclass->newQuery();

        if ($request->has('name')) {
            $query->where('name', $input['name']);
        }


        if ($request->has('phone')) {

            $query->where('phone', $input['phone']);

        }

        if ($request->has('pphone')) {
            $query->where('pid', $mem['id']);
        }


        if ($request->has('start')) {
            $start = strtotime($input['start']);
            $query->where('create_at', '>=', $start);
        }
        if ($request->has('start')) {
            $start = strtotime($input['start']);
            $query->where('create_at', '>=', $start);
        }

        if ($request->has('end')) {
            $end = strtotime($input['end']);
            $query->where('create_at', '<=', $end);
        }
        if ($request->has('level')) {
            $query->where('level', $input['level']);
        }
        if ($request->has('status')) {
            $query->where('status', $input['status']);
        }
        $menber = $this->memberclass->get();
        $memberclass = $query->select(['id', 'pid', 'status','locking', 'phone', 'account', 'level', 'login_name', 'name', 'create_at', 'rob_point_num_a', 'rob_point_num_b', 'rob_point_num_c', 'login_at', 'pic'])->orderby('id', 'desc')->paginate(config('admin.pages'));
        foreach ($memberclass as $key => $value) {
            foreach ($menber as $k => $v) {
                if ($v['id'] == $value['pid']) {
                    $memberclass[$key]['pphone'] = $v['phone'];
                }
            }

        }

        $total = $memberclass->total();//总条数

        $page = ceil($total / config('admin.pages'));//共几页

        $currentPage = $memberclass->currentPage();//当前页

        return view('admin.member.index', compact('memberclass', 'total', 'page', 'currentPage'));
    }


    public function edit(Request $request, $id)
    {
        $res = $this->memberclass->where('id', $id)->first();
        if ($res['pid'] != '') {
            $ress = $this->memberclass->where('id', $res['pid'])->select('phone')->first();
        } else {
            $ress = 0;
        }


        return view('admin.member.edit', compact('res', 'ress'));
    }

    #修改
    public function editinfo(Request $request)
    {
        $post = $request->input();
        $user = User::where('id', $post['id'])->first();
        //var_dump($post);die;
        $data = [];
        $daaa = [];
        if ($post['pphone']) {
            $puser = DB::table('user')->where('phone', $post['pphone'])->first();
            $data['pid'] = $puser->id;
            if ($puser == null) {
                return back()->withErrors('该用户不存在');
            }
        }

        if ($post['chongaccount'] == 0) {

            return back()->withErrors('充值金额不能为0');

        }


        if ($post['chongaccount'] != '') {

            if ($post['chongaccount'] > 0) {
                $data['account'] = $post['account'] + $post['chongaccount'];
                $daaa['status'] = 1;
            } elseif ($post['chongaccount'] < 0) {

                $data['account'] = $post['chongaccount'] + $user['account'];
                if ($data['account'] < 0) {
                    return back()->withErrors('用户金额不能为负');
                }
                $daaa['status'] = 2;
            }

            $daaa['account']=$user['account'];
            $daaa['user_id'] = $user['id'];
            $daaa['money'] = abs($post['chongaccount']);
            $daaa['create_at'] = time();

            //dd($daaa);
            DB::table('balance')->insert($daaa);
        }

        $data['phone'] = $post['phone'];
//        $data['locking'] = $post['locking'];
        $data['update_at'] = time();
        //dd($data);
        $banner = DB::table('user')->where('id', $post['id'])->update($data);


        if ($banner) {
            event(new ActiveLogEvent('修改用户列表中的用户信息'));
            return back()->with('success', '请求成功');
        } else {
            return back()->withErrors('请求失败');
        }

    }

    #删除
    public function del(Request $request)
    {

        $id = $request->only('id')['id'];
        $banner = DB::table('user')->where('id', $id)->delete();
        if ($banner) {
            return $this->ajaxMessage(true, '删除成功');
        } else {
            return $this->ajaxMessage(false, '删除失败');
        }

    }

    public function loopNextUser(Request $request)
    {
        $pid = $request->only('id')['id'];
        $date = User::where(['pid' => $pid])->get(['id', 'login_name', 'name', 'sex', 'phone', 'level', 'account', 'create_at'])->toArray();
        if (count($date) > 0) {
            return $this->ajaxMessage(true, '获取数据成功', $date);
        }
        return $this->ajaxMessage(false, '该用户没有下级');
    }

    public function sheng(Request $request, $id)
    {
        $res = User::where('id', $id)->first();


        return view('admin.member.sheng', compact('res'));
    }

    public function shenginfo(Request $request)
    {
        $post = $request->input();
        $uid = $post['id'];
        if ($uid == '') {
            return $this->ajaxMessage(false, '参数错误');
        }
        if ($post['type'] == 1) {
            $money = 100;
            $name = '100元区';
            $type = 4;

        } elseif ($post['type'] == 2) {
            $money = 300;
            $name = '300元区';
            $type = 5;

        } elseif ($post['type'] == 3) {
            $money = 2000;
            $name = '2000元区';
            $type = 6;

        }
         $post['number']=1;
        // if (intval($post['number']) == 0) {
        //     return $this->ajaxMessage(false, '数量不能为0');

        // }

        $goodsids = DB::table('goods')->where('type', $type)->limit(1)->pluck('id');
        if ($goodsids) {
            $goodsids = $goodsids->toArray();
        }
        $goodsids = implode($goodsids);

        $users = User::where('id', $uid)->first();
        $nummoney = $money * intval($post['number']);
        if ($nummoney > $users['account']) {
            return $this->ajaxMessage(false, '余额不足');
        }
        $nmmm = 0;

        $user=User::find($uid);
        #查询地址
        $address=Address::where(['user_id'=>$uid,'default'=>1])->first();
         if (!$address) {
            return $this->ajaxMessage(false, '该用户没有收获地址');
        }
        $account=$user->account-$nummoney;
//        \Log::info('购买用户的余额减操作',['account'=>$account]);
        $user->account=$account;
        $res = $user->save();
        if($res){
//            \Log::info('减成功');
            for ($i = 0; $i < intval($post['number']); $i++) {
                #插入订单
                $add_order = [];
                $add_order['user_id'] = $uid;
                $add_order['order_code'] = date('Y') . date('m') . time() . rand(10000000, 99999999);;
                $add_order['total_money'] = $money;
                $add_order['status'] = 2;
                $add_order['name'] = $users['name'];
                $add_order['type'] = 6;
                $add_order['order_num'] = 1;
                $add_order['phone'] = $users['phone'];
                $add_order['name'] = $address['name'];
                $add_order['province']=$address['province'];
                $add_order['city']=$address['city'];
                $add_order['area']=$address['area'];
                $add_order['address']=$address['address'];

                $add_order['create_at'] = time();
                $add_order['update_at'] = time();
                $add_order['class'] = 2;
                $order_id = Order::insertGetId($add_order);
                if($order_id){
                    $orderinfo = [];
                    $orderinfo['order_id'] = $order_id;
                    $orderinfo['name'] = $name;
                    $orderinfo['price'] = $money;
                    $orderinfo['type'] = $type;
                    $orderinfo['goods_id'] = $goodsids;
                    $orderinfo['num'] = 1;
                    $orderinfo['create_at'] = time();
                    $orderinfo['update_at'] = time();
                    $orders = Orderinfo::insert($orderinfo);
                    if($orders){
                        $promote = $this->rowCommonService->index($order_id);
                        if ($promote) {
                            continue;
                        } else {
                            break;
                        }
                    }else{
                        break;
                    }
                }else{
                    break;
                }
            }
            #改变用户等级
            if ($users['level'] == 0) {
                User::where('id', $uid)->update(['level' => 1]);
            }
            $nmmm = 1;
            if ($nmmm == 1) {
                event(new ActiveLogEvent('执行了用户列表中的购买操作'));
                return $this->ajaxMessage(true, '提交成功', ['flag' => 1]);
            } else {
                return $this->ajaxMessage(false, '提交失败');
            }
        }else{
            return $this->ajaxMessage(false, '扣除余额失败');
        }
    }

    public function addUser()//加载添加会员视图列表
    {
        return view('admin.member.addUser');
    }

    public function actUser(Request $request)//执行添加会员操作
    {
        $this->validate($request, [
            'phone' => array('regex:/^1[34578]\d{9}$/', 'required'),
            'login_name' => 'required',
        ], [
            'phone.regex' => '会员手机号格式错误',
            'phone.required' => '会员手机号不能为空',
            'login_name.required' => '会员真实姓名不能为空',
        ]);
        $date = $request->except('_token');
        if ($date['prev_phone']) {//有推荐人手机号
            $result = $this->checkPhone($date['prev_phone']);
            if ($result) {
                $result2 = $this->checkPhone($date['phone']);
                if (!$result2) {
                    if ($date['prev_phone'] == $date['phone']) {
                        $pid = 0;
                    } else {
                        $pid = $result;
                    }
                    $res = $this->addUserInfo($date['phone'], $date['login_name'], $pid);
                    if ($res) {
                        event(new ActiveLogEvent('执行了添加会员'));
                        return back()->with('success', '添加成功');
                    }
                    return back()->withErrors('添加失败');
                } else {
                    return back()->withErrors('会员手机号已经存在');
                }
            } else {
                return back()->withErrors('推荐人手机号不存在');
            }
        } else {
            $res = $this->addUserInfo($date['phone'], $date['login_name']);
            if ($res) {
                event(new ActiveLogEvent('执行了添加会员'));
                return back()->with('success', '添加成功');
            }
            return back()->withErrors('添加失败');
        }
    }

    public function addUserInfo($phone, $login_name, $pid = 0)//添加会员信息
    {
        $date['pid'] = $pid;
        $date['phone'] = $phone;
        $date['login_name'] = $login_name;
        $date['pwd'] = md5(123456);
        $date['paypwd'] = md5(123456);
        $date['create_at'] = time();
        $date['update_at'] = time();
        return User::insert($date);
    }

    public function checkPhone($phone)//验证手机号是否存在
    {
        $id = User::where(['phone' => $phone])->value('id');
        if ($id) {
            return $id;
        }
        return false;
    }

    public function rechargeList(Request $request)//充值记录列表
    {
        $query = $this->balance->query();
        if ($request->has('disc'))
            $query->where(['type' => $request->input('disc')]);
        if ($request->has('phone')) {
            $user_info = $this->conditionInfo($request->input('phone'));
            $query->where(['user_id' => $user_info['user_id']]);
        }
        $date = $query->orderby('id', 'desc')->paginate(config('admin.pages'));
        if ($date) {
            foreach ($date->items() as $k => $v) {
                $user = $this->getUserInfo($v['user_id']);
                $date->items()[$k]['login_name'] = $user->login_name;
                $date->items()[$k]['phone'] = $user->phone;
                $date->items()[$k]['pic'] = $user->pic;
            }
        }
        $res = $this->paging($date);
        
        return view('admin.member.recharge', compact('date', 'res'));
    }

    public function getUserInfo($user_id)//获取用户信息
    {
        $user = User::find($user_id);
        return $user;
    }

    public function conditionInfo($phone)
    {
        $user['user_id'] = User::where('phone', $phone)->value('id');
        return $user;
    }

    public function locking(Request $request)//会员列表中的锁定解锁功能
    {
        $date=$request->except('_token');
        $user=User::find($date['id']);
        $user->locking=$date['flag'];
        if($user->save()){
            return $this->ajaxMessage(true,'设置成功');
        }
        return $this->ajaxMessage(false,'设置失败');
    }
    
    public function loginPwd(Request $request)//修改会员的登录密码
    {
        $date=$request->except('_token');
        if(!empty($date['pwd'])){
            $pwd=md5($date['pwd']);
            $user=User::find($date['id']);
            $user->pwd=$pwd;
            if($user->save()){
                return $this->ajaxMessage(true,'设置成功');
            }
        }
        return $this->ajaxMessage(false,'设置失败');
    }
}
