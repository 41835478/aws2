<?php

namespace App\Http\Middleware\Home;

use App\Http\Model\OnOff;
use Closure;

class QrcodeMiddleware
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
        if($onOff->qrcode_onoff==1||$request->session()->has('phone')){
            return $next($request);
        }
        return redirect('qrcode.onOff');
    }
}
