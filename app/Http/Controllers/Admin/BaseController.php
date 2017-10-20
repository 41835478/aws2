<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\OnOff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\ActiveLogEvent;



class BaseController extends Controller
{
    public function index()
    {
        return view('admin.layouts.master');
    }

    public function webOnOff()//加载网站开关视图
    {
        $find=OnOff::find(1);
        return view('admin.layouts.webOnOff',compact('find'));
    }

    public function editWebOnOff(Request $request)//修改网站开关
    {
        $onOff=$request->only('on_off')['on_off'];
        $pay_num=$request->only('pay_num')['pay_num'];
        $flag=$request->only('flag')['flag'];
        $cart_onoff=$request->only('cart_onoff')['cart_onoff'];
        $qrcode_onofff=$request->only('qrcode_onoff')['qrcode_onoff'];
        $mod=OnOff::find(1);
        $mod->on_off=$onOff;
        $mod->pay_num=$pay_num;
        $mod->flag=$flag;
        $mod->cart_onoff=$cart_onoff;
        $mod->qrcode_onoff=$qrcode_onofff;
        if($mod->save()){
            event(new ActiveLogEvent('执行了网站设置'));
            return back()->with('success','网站设置成功');
        }
        return back()->withErrors('网站设置失败');
    }
}