<?php

namespace App\Http\Middleware\Home;

use App\Http\Model\OnOff;
use Closure;

class OnOffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $onOff=OnOff::find(1);
        if($onOff->on_off==1||$request->session()->has('phone')){
            return $next($request);
        }
        return redirect('web.onOff');//网站开关路由
    }
}
