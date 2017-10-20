<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\User;
use App\Http\Services\AuthService;
use App\Http\Services\SendCodeService;
use App\Http\Services\WxInterfaceService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxChatController extends BaseController
{
    protected $wxInterfaceService;

    public function __construct(WxInterfaceService $wxInterfaceService,AuthService $auth,SendCodeService $msg)
    {
        parent::__construct($auth,$msg);
        $this->wxInterfaceService=$wxInterfaceService;
    }

    public function index()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'))//说明当前环境是微信
        {
            $user_id=$this->checkUser();
            $user=User::find($user_id);
            if(!$user->openid){
                return redirect(url('wxChat/loginRegister'));
            }
        }
        return redirect(url('/'));
    }

    public function loginRegister(Request $request)
    {
        $user_id=$this->checkUser();
        $code=$request->only('code')['code'];
        if (!$code) {
            $url = urlencode(config('home.WEB').'/wxChat/loginRegister');
            $sendUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . config('home.APPID') . '&redirect_uri=' . $url . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            return redirect($sendUrl);
        }
        $res=$this->wxInterfaceService->index($code,$user_id);
        if($res){
            return redirect(url('/'));
        }
    }
}
