<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 9:38
 */
namespace App\Http\Controllers\Home2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\User;
use App\Http\Services\AuthService;
use Cache;
class InfoController extends Controller{

    const AD = 'advertisement';

    #项目简介
    public function info(){
        $return = DB::table(self::AD)->where(['type'=>3])->first()?:null;

        return view('home.info.projectBrief',['return'=>$return]);
    }
    #新手必看
    public function newList(){
        $return = DB::table(self::AD)->where(['type'=>4])->select()->get()?:null;

        return view('home.info.BeginnerGuide',['return'=>$return]);
    }
    #必看详情
    public function newInfo(Request $request){
        $id = $request->input('id');
        $return = DB::table(self::AD)->where(['type'=>4,'id'=>$id])->first()?:null;
        return view('home.info.registerRule',['return'=>$return]);
    }
    #系统公告
    public function sysList(){
        $return = DB::table(self::AD)->where(['type'=>2])->select()->get()?:null;
        return view('home.info.SystemNotice',['return'=>$return]);
    }
    #公告详情
    public function sysInfo(Request $request){
        $id = $request->input('id');
        $return = DB::table(self::AD)->where(['type'=>2,'id'=>$id])->first()?:null;
        return view('home.info.NoticeDetails',['return'=>$return]);
    }
    const USER='user';
    /**
     *我的账户
     */
    #我的账户
    public function account_settings(){
        return view('home.info.accountsettings');
    }
    #修改登录密码
    public function modify_login(){
        #查询用户信息
        $auth = new AuthService();
        $uid = $auth->rememberDecrypt(\Session::get('home_user_id'));
        // $uid=5;
        $users=DB::table(self::USER)->where(['id'=>$uid])->first();
        return view('home.info.modify_login',['users'=>$users]);
    }
    #修改支付密码
    public function modify_pay(){
        #查询用户信息
        $auth = new AuthService();
        $uid = $auth->rememberDecrypt(\Session::get('home_user_id'));
        // $uid=5;
        $users=DB::table(self::USER)->where(['id'=>$uid])->first();

        return view('home.info.modify_pay',['users'=>$users]);
    }
    #修改信息提交
    public function user_info(Request $request){
        #查询用户信息
        $auth = new AuthService();
        $uid = $auth->rememberDecrypt(\Session::get('home_user_id'));
        // $uid = 5;
        $code = $request->input('code');
        $pwd = $request->input('pwd');
        $t_pwd = $request->input('t_pwd');
        $type = $request->input('type');
        if($request->session()->has('yzmCode')){
            if($code==session('yzmCode')){
                if($pwd != $t_pwd){
                   exit("<script>alert('两次密码输入不一致');history.go(-1);</script>");
                }
                $pwd=md5($pwd);
                if($type == 'pay'){
                    $res = DB::table(self::USER)->where(['id'=>$uid])->update(['paypwd'=>$pwd,'update_at'=>time()]);
                    if($res>0){
                        $request->session()->forget('yzmCode');
                        exit("<script>alert('修改成功');location.href='/shop/index';</script>");
                    }
                }elseif($type == 'login'){
                    $res = DB::table(self::USER)->where(['id'=>$uid])->update(['pwd'=>$pwd,'update_at'=>time()]);
                    if($res>0){
                        $request->session()->forget('yzmCode');
                        exit("<script>alert('修改成功');location.href='/register/index';</script>");
                    }
                }else{
                    exit("<script>alert('参数有误，请刷新重新提交');history.go(-1);</script>");
                }
                exit("<script>alert('修改失败');history.go(-1);</script>");
            }
            exit("<script>alert('验证码不正确');history.go(-1);</script>");
        }
        exit("<script>alert('验证码已失效，请重新获取');history.go(-1);</script>");
    }


}