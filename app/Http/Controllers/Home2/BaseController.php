<?php

namespace App\Http\Controllers\Home2;

use App\Http\Services\AuthService;
use App\Http\Services\SendCodeService;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;

class BaseController extends Controller
{
    protected $auth;
    protected $msg;

    public function __construct(AuthService $auth,SendCodeService $msg)
    {
        $this->auth=$auth;
        $this->msg=$msg;
//        session(['url'=>'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']]);
    }

    /**
     * @return string 返回用户的id
     */
    public function checkUser()//用于登录id解密
    {
        return $this->auth->rememberDecrypt(\Session::get('home_user_id'));
    }

    /**
     * @param $id
     * @return string
     */
    public function encryptUser($id)//用于登录id的加密
    {
        return $this->auth->rememberEncrypt($id);
    }

    /**
     * @param $phone
     * @return bool  发送注册短信验证码
     */
    public function sendRegisterMsg($phone)
    {
        return $this->msg->sendMsg($phone);
    }
    /**
     * @param $phone
     * @return bool  发送注册短信验证码
     */
    public function yzmsendMsg($phone)
    {
        return $this->msg->yzmsendMsg($phone);
    }

    /**
     * @return bool  判断当前环境是否是微信从而决定是否进行网页授权
     */
    public function isWeiXin()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'))//说明当前环境是微信
        {
            return true;
        }
        return false;
    }
}
