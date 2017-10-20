<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 19:39
 */

namespace App\Http\Services;


use App\Http\Model\User;

class WxInterfaceService
{
    protected $tokenUrl = '';
    public function index($code,$user_id)//网页授权
    {
        $this->tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . config('home.APPID') . '&secret=' . config('home.SECRET') . '&code=' . $code . '&grant_type=authorization_code';
        $access_token_contents = file_get_contents($this->tokenUrl);
        $access_token = json_decode($access_token_contents, true);
        $find=User::where(['openid' => $access_token['openid']])->value('id');
        if ($find) {//说明以前关注过，这里直接跳转到index方法就好
            return true;
        } else{
            $userInfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token['access_token'] . '&openid=' . $access_token['openid'] . '&lang=zh_CN';
            $userInfoContents = file_get_contents($userInfoUrl);
            $userInfo = json_decode($userInfoContents, true);
            if ($userInfo) {
                $user=User::find($user_id);
                $user->openid = $userInfo['openid'];
                $user->name = $this->filterNickname($userInfo['nickname']);
                $user->sex = $userInfo['sex'];
            
                $url=$userInfo['headimgurl'];
                $res=self::WecahtInfo($url);
                $string = str_replace('/www/wwwroot/api.aus.com/public/', '', $res);
                $user->pic =$string;
                if ($user->save()) {
                    return true;
                }
                return false;
            } else {
                return redirect($this->tokenUrl);
            }
        }
    }

    /**
     * 过滤微信昵称中的表情（不过滤 HTML 符号）
     */
    public static function filterNickname($nickname)
    {
        $pattern = array(
            '/\xEE[\x80-\xBF][\x80-\xBF]/',
            '/\xEF[\x81-\x83][\x80-\xBF]/',
            '/[\x{1F600}-\x{1F64F}]/u',
            '/[\x{1F300}-\x{1F5FF}]/u',
            '/[\x{1F680}-\x{1F6FF}]/u',
            '/[\x{2600}-\x{26FF}]/u',
            '/[\x{2700}-\x{27BF}]/u',
            '/[\x{20E3}]/u'
        );
        $nickname = preg_replace($pattern, '', $nickname);
        return trim($nickname);
    }

 // #微信注册内容
     
 //    public static function WecahtInfo($url)
 //    {

 //        $head_img = '/www/wwwroot/tjzbdkj.com/public/images/'.md5('zxc'.time()).'.jpg';
 //        #下载用户头像
 //        $result = self::dlfile($url,$head_img);
 //        if ($result) {
 //            return '/'.$head_img;
 //        }else{
 //            return false;
 //        }
 //    }
 #微信注册内容
    public static function WecahtInfo($user)
    {

        $head_img = '/www/wwwroot/api.aus.com/public/images/'.md5('qwez'.time()).'.jpg';
        #下载用户头像
        $result = self::dlfile($user,$head_img);
        if ($result) {
            return '/'.$head_img;
        }else{
            return false;
        }
    }




#下载微信头像
    public static function dlfile($file_url,$save_to)
    {   
            
        $ch = curl_init();
        $timeout = 5; 
        curl_setopt($ch, CURLOPT_POST, 0); 
        curl_setopt($ch,CURLOPT_URL,$file_url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
        $file_content = curl_exec($ch);
        curl_close($ch);
        $downloaded_file = fopen($save_to, 'w');
        $res = fwrite($downloaded_file, $file_content);
        fclose($downloaded_file);
        return $res;
    }

}