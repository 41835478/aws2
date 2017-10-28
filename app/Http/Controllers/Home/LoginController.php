<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\OnOff;
use App\Http\Model\User;
use App\Http\Requests\Home\EditPwdRequest;
use App\Http\Requests\Home\RegisterRequest;
use Illuminate\Http\Request;
use Cache;

class LoginController extends BaseController
{
    public function index($pid=0)//加载注册页面
    {
        $onOff=OnOff::find(1);
        $type=1;
        if($onOff->flag==2){//说明用户不可注册
            $type=2;
        }
        $phone='';
        if($pid){
            $phone=User::where(['id'=>$pid])->value('phone');
        }
        return view('home.register.index',['pid'=>$pid,'type'=>$type,'phone'=>$phone]);
    }

    #三期注册流程
    public function index1($pid=0)//加载注册页面
    {
        return view('home.register.index1',['pid'=>$pid]);
    }

    public function goRegister1()
    {
        $data = $_POST; 
        $dd = [];
        $dd['pid'] = $data['pid'] ? $data['pid'] : 0 ;
        $dd['phone'] = $data['phone'];
        $dd['name'] = '默认昵称'.rand(100,10000);
        $findPhone=User::where('phone',$data['phone'])->first();        
        if(!$findPhone){
            if (Cache::has('registerCode1')) {
                if ($data['code'] == Cache::get('registerCode1')) {
                    $dd['pwd'] = md5($data['code']);
                    $dd['paypwd'] = md5($data['code']);
                    $dd['create_at'] = time();
                    $dd['update_at'] = time();
                    $res = User::insertGetId($dd);
                    if ($res) {
                        $result=$this->encryptUser($res);
                        if($result){
                            session(['home_user_id'=>$result]);
                        }
                        session(['home_user_id'=>$result]);
                        session(['mobile' => $data['phone']]);
                        session(['pwd' => $data['code']]);
                        Cache::pull('registerCode1');
//                                        session()->forget('registerCode');
                        return $this->ajaxMessage(true, '注册成功', ['flag' => 2]);
                    }
                    return $this->ajaxMessage(false, '注册失败');
                }
                return $this->ajaxMessage(false, '验证码不正确');
            }
            return $this->ajaxMessage(false, '验证码已失效，请重新获取');
        }
        return $this->ajaxMessage(false, '该手机号已经注册');
    }

    public function agreement()//注册页面中的用户注册协议
    {
        return view('home.register.agreement');
    }

    public function goRegister(RegisterRequest $request)//添加去注册
    {
        $onOff=OnOff::find(1);
        if($onOff->flag==1){
            $date=$request->except(['_token','pwd_confirmation','code','prev_phone']);
            $prev_phone=$request->only('prev_phone')['prev_phone'];
            $code=$request->only('code')['code'];
            if($request->has('pid')&&$request->input('pid')!=0) {
                $find = User::find($request->input('pid'));
                if ($find) {
                    if($find->phone==$prev_phone){
                        if ($find->phone != $date['phone']) {
                            $findPhone=User::where('phone',$date['phone'])->first();
                            if(!$findPhone){
                                $date['pid'] = $request->input('pid');
                                if (Cache::has('registerCode')) {
                                    if ($code == Cache::get('registerCode')) {
                                        $pwd = $date['paypwd'];
                                        $date['pwd'] = md5($date['pwd']);
                                        $date['paypwd'] = md5($pwd);
                                        $date['create_at'] = time();
                                        $date['update_at'] = time();
                                        $res = User::insertGetId($date);
                                        if ($res) {
                                            session(['mobile' => $date['phone']]);
                                            session(['pwd' => $pwd]);
                                            Cache::pull('registerCode');
//                                        session()->forget('registerCode');
                                            return $this->ajaxMessage(true, '注册成功', ['flag' => 2]);
                                        }
                                        return $this->ajaxMessage(false, '注册失败');
                                    }
                                    return $this->ajaxMessage(false, '验证码不正确');
                                }
                                return $this->ajaxMessage(false, '验证码已失效，请重新获取');
                            }
                            return $this->ajaxMessage(false, '该手机号已经注册');
                        }else{
                            return $this->ajaxMessage(false, '该手机号已经注册');
                        }
                    }else{
                        return $this->ajaxMessage(false, '非法注册');
                    }
                }else{
                    return $this->ajaxMessage(false, '非法注册');
                }
            }else{
                return $this->ajaxMessage(false, '推荐人手机号不能为空');
            }
        }else{
            return $this->ajaxMessage(false,'当前系统为不可注册状态');
        }
    }
    public function sssendCode(Request $request)//发送验证码
    {
        $onOff=OnOff::find(1);
        if($onOff->flag==1){
            $res=User::where('phone',$request->input('phone'))->first();
            if($res){
                return $this->ajaxMessage(false,'该手机已注册，可以通过密码登录');
            }
            if(!Cache::has('registerCode')){
                $res=$this->sendRegisterMsg($request->input('phone'));
                if($res){
                    return $this->ajaxMessage(true,'验证码已发送，请注意查收',['flag'=>3]);
                }
                return $this->ajaxMessage(false,'验证码发送失败');
            }
            return $this->ajaxMessage(false,'验证码10分钟后失效',['flag'=>4]);
        }else{
            return $this->ajaxMessage(false,'当前系统为不可注册状态');
        }
    }

    public function sendyamcode(Request $request)//修改密码时使用
    {

        $res=User::where('phone',$request->input('phone'))->first();
        
        if($res){
//             Cache::forget('yzmCode');
            //if(!$request->session()->has('yzmCode')){

                $rese=$this->yzmsendMsg($request->input('phone'));
                 //dd($rese);
                if($rese){
                    return $this->ajaxMessage(true,'验证码已发送，请注意查收',['flag'=>3]);
                }
            //     return $this->ajaxMessage(false,'验证码发送失败');
            // }
        }else{
            return $this->ajaxMessage(false,'该手机号不存在');
        }
    }


    public function sendCode(Request $request)//发送验证码
    {
        $res=User::where('phone',$request->input('phone'))->first();
        if(!$res){
            return $this->ajaxMessage(false,'此账号不存在，请重新输入或注册账号',['flag'=>4]);
        }
        if(!Cache::has('registerCode')){
            $res=$this->sendRegisterMsg($request->input('phone'));
            if($res){
                return $this->ajaxMessage(true,'验证码已发送，请注意查收',['flag'=>3]);
            }
            return $this->ajaxMessage(false,'验证码发送失败');
        }
        return $this->ajaxMessage(false,'验证码10分钟后失效',['flag'=>4]);
    }

    public function login(Request $request)//执行登录操作
    {
        $onOff=OnOff::find(1);
        if($onOff->flag==2){//说明当前为不可注册状态要保存session
            $arr=explode(',',$onOff->phone);
            if(in_array($request->input('phone'),$arr)){
                session(['phone'=>$request->input('phone')]);
            }
        }
        $date['phone']=addslashes($request->input('phone'));//转译特殊字符
        $date['pwd']=md5($request->input('pwd'));
        $res=User::where($date)->first();
        if($res){
            if($res->locking==2){
                $res->status=1;
                $res->login_at=time();
                if($res->save()){
                    $result=$this->encryptUser($res->id);
                    if($result){
                        session(['home_user_id'=>$result]);
                        return $this->ajaxMessage(true,'登录成功',['flag'=>1]);
                    }
                }
            }
            return $this->ajaxMessage(false,'账号已经被锁定，暂时无法登录，请联系客服',['flag'=>1]);
        }
        return $this->ajaxMessage(false,'账号或密码错误',['flag'=>1]);
    }

    public function forgetPwd()//加载忘记密码操作
    {
        return view('home.register.forgetPwd');
    }

    public function editPwd(EditPwdRequest $request)//执行忘记密码操作
    {
        $date=$request->except(['_token','newpwd_confirmation','code']);
        $code=$request->only('code')['code'];
        if(Cache::has('registerCode')){
            if($code==Cache::get('registerCode')){
                $user=User::where(['phone'=>$date['phone']])->first();
                if($user){
                    $user->pwd=md5($date['newpwd']);
                    $user->update_at=time();
                    $res=$user->save();
                    if($res){
                        Cache::pull('registerCode');
//                    session()->forget('registerCode');
                        return $this->ajaxMessage(true,'修改密码成功',['flag'=>1]);
                    }
                    return $this->ajaxMessage(false,'修改密码失败');
                }
                return $this->ajaxMessage(false,'该用户不存在');
            }
            return $this->ajaxMessage(false,'验证码不正确');
        }
        return $this->ajaxMessage(false,'请先获取验证码');
    }


    public function sssendCode1(Request $request)//发送验证码
    {
        $onOff=OnOff::find(1);
        if($onOff->flag==1){
            $res=User::where('phone',$request->input('phone'))->first();
            if($res){
                return $this->ajaxMessage(false,'该手机已注册，可以通过密码登录');
            }
            if(!Cache::has('registerCode1')){
                $res=$this->sendRegisterLogin($request->input('phone'));
                if($res){
                    return $this->ajaxMessage(true,'验证码已发送，请注意查收',['flag'=>3]);
                }
                return $this->ajaxMessage(false,'验证码发送失败');
            }
            return $this->ajaxMessage(false,'验证码10分钟后失效',['flag'=>4]);
        }else{
            return $this->ajaxMessage(false,'当前系统为不可注册状态');
        }
    }
}
