<?php

namespace App\Http\Controllers\Admin2;

use App\Http\Model\Admin\Admin;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\AdminService;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use App\Http\Model\User;

use Hash;
use Config;
use DB;
class UsersController extends Controller
{
    protected $admin;
    protected $adminService;
    protected $memberclass;

    public function __construct(Admin $admin,AdminService $adminService,User $memberclass)
    {
        $this->memberclass = $memberclass;
        $this->admin=$admin;
        $this->adminService=$adminService;
    }

    public function index(Request $request)
    {
        $input = $request->only(['name', 'phone']);
        $query = $this->memberclass->newQuery();

        if ($request->has('phone')) {

            $query->where('phone', $input['phone']);

        }
        $menber = $this->memberclass->get();

        $memberclass = $query->select(['id','pid','phone', 'account', 'login_name', 'name'])->orderby('id', 'desc')->paginate(config('admin.pages'));
        $memberclass1 = DB::table('user')->select('id','pid')->get()->toArray();

        foreach ($memberclass as $key => $value) {
            // 众筹分销奖金统计
            $memberclass[$key]['a1'] = DB::table('balance_records2')->where(['type'=>1,'is_add'=>1,'user_id'=>$value->id])->where('is_add',1)->sum('num');

            // 众筹订单统计
            $memberclass[$key]['a2'] = DB::table('investments2')->where(['user_id'=>$value->id])->count();
            // 众筹领导奖
            $memberclass[$key]['a3'] = DB::table('balance_records2')->where(['type'=>2,'is_add'=>1,'user_id'=>$value->id])->sum('num');
            //众筹静态分红奖
            $memberclass[$key]['a4'] = DB::table('balance_records2')->where(['type'=>4,'is_add'=>1,'user_id'=>$value->id])->sum('num');
            //众筹爱心值
            $memberclass[$key]['a5'] = DB::table('investments2')->where(['user_id'=>$value->id])->sum('money');
            // 众筹股东分红
            $memberclass[$key]['a6'] = DB::table('balance_records2')->where(['type'=>5,'is_add'=>1,'user_id'=>$value->id])->sum('num');   
            $team = self::getCountId([$value->id],$memberclass1,1,10);
            foreach ($team as $k1=>$v1)
            {
                if ($v1 === $value->id){
                    unset($team[$k1]);
                }
            }
            if (empty($team)) {
                $memberclass[$key]['teamMoney'] = 0;
            }else{
                $memberclass[$key]['teamMoney'] = DB::table('investments2')->whereIn('user_id',$team)->sum('money'); 
            }
        }
        $total = $memberclass->total();//总条数

        $page = ceil($total / config('admin.pages'));//共几页

        $currentPage = $memberclass->currentPage();//当前页

        return view('admin.member2.index', compact('memberclass', 'total', 'page', 'currentPage'));        
    }

    /**
    *查询要查询用户指定级别内的所有下级id
    *$uid:要查询用户集合
    *$class:要查询的级别
    *$userall:静态变量占位
    *$users:用户集合
    *return----查询指定用户的指定级别内的所有下级id集合(包括自己)
    */
    public static function getCountId($uid,$users,$userall = '',$class=''){
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
                if(in_array($v->pid,$uid)){
                    array_push($userChildren,$v->id);
                } 
            }else{
                if($v->pid == $uid){
                    array_push($userChildren,$v->id);
                } 
            }
        }
        $userall = array_unique(array_merge($userall, $userChildren));
        if(!empty($userChildren)){
            if($class){
                $class--;
                if($class > 0){
                    self::getCountId($userChildren,$users,'',$class);
                }       
            }else{
                self::getCountId($userChildren,$users);
            }
        }
        sort($userall);

        // dump($userall);
        return $userall;
    }
}
