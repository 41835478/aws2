<?php

namespace App\Http\Middleware\Home;

use App\Http\Model\User;
use App\Http\Services\AuthService;
use Closure;

class HomeMiddleware
{
    protected $user;
    protected $auth;
    public function __construct(User $user,AuthService $auth)
    {
        $this->user=$user;
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
            $res=$this->user->find($user_id);
            if($res){
                return $next($request);
            }
        }
        return redirect(url('register/index'));
    }
}
