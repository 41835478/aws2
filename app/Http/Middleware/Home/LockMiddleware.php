<?php

namespace App\Http\Middleware\Home;

//use App\Http\Model\OnOff;
use App\Http\Model\User;
use App\Http\Services\AuthService;
use Closure;

class LockMiddleware
{
    protected $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth=$auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('home_user_id')){
            $user_id=$this->auth->rememberDecrypt(\Session::get('home_user_id'));
            $user=User::find($user_id);
            if(count($user) == 0){
                $request->session()->forget('phone');
                $request->session()->forget('home_user_id');
                return redirect('/');
            }
            if($user->locking==2){//说明是未锁定可以继续其他操作
                return $next($request);
            }else{//说明账号已经被锁定
                return redirect('uses.locking');//用户账号已经被锁定
            }
        }else{
            return redirect(url('register/index'));//用户账号已经被锁定(跳转到登录页面)
        }
    }
}
