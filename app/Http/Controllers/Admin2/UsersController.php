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
        $input = $request->only(['name', 'phone', 'start', 'end', 'level', 'pphone', 'status']);
        $query = $this->memberclass->newQuery();

        if ($request->has('phone')) {

            $query->where('phone', $input['phone']);

        }
        $menber = $this->memberclass->get();
        $memberclass = $query->select(['id','phone', 'account', 'login_name', 'name'])->orderby('id', 'desc')->paginate(config('admin.pages'));
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
        }
        $total = $memberclass->total();//总条数

        $page = ceil($total / config('admin.pages'));//共几页

        $currentPage = $memberclass->currentPage();//当前页

        return view('admin.member2.index', compact('memberclass', 'total', 'page', 'currentPage'));        
    }
}
