<?php
namespace App\Http\Services;

use Cache;
class SendCodeService
{
    public function sendMsg($mobile)//发送验证码
    {
        $username = "AWS";
        $pwd = "qR6vQ9fH";
        $password = md5($username.md5($pwd));
        $code=self::greatRand();
        $content = "您的注册验证码是：".$code."，请在十分钟内填写，切勿将验证码泄露于他人。【爱无尚】";
        $url = "http://120.55.248.18/smsSend.do?";
        $data=array('username'=>$username,'password'=>$password,'mobile'=>$mobile,'content'=>urlencode($content));
        $param=self::getSign($data);
        $result=self::http_curl($url,'post','json',$param);
        if($result){
//            session(['registerCode'=>$code]);
            Cache::put('registerCode',$code,2);
            return true;
        }else{
            return false;
        }
    }


   	public function yzmsendMsg($mobile)//发送验证码
    {
        $username = "AWS";
        $pwd = "qR6vQ9fH";
        $password = md5($username.md5($pwd));
        $code=self::greatRand();

        $content = "您的验证码是：".$code."，请在十分钟内填写，切勿将验证码泄露于他人。【爱无尚】";
        $url = "http://120.55.248.18/smsSend.do?";
        $data=array('username'=>$username,'password'=>$password,'mobile'=>$mobile,'content'=>urlencode($content));
        $param=self::getSign($data);
        $result=self::http_curl($url,'post','json',$param);
        //dd($result);
        if($result){
            session(['yzmCode'=>$code]);
//            Cache::put('yzmCode',$code,2);
            return true;
        }else{
            return false;
        }
    }


    //生成随机数
    private function greatRand(){
        $str = '1234567890';
        $result = '';
        for($i=0;$i<6;$i++){
            $result .= $str{rand(0,strlen($str)-1)};
        }
        return $result;
    }

    //生成签名
    private function getSign($data){
        $result = '';
        $i = 0;
        foreach($data as $k=>$v){
            $i++;
            if($i!=1){
                $result .= '&';
            }
            $result .= $k . '=' . $v;
        }

        return $result;
    }

    /*
     * $url 接口url
     * $type 请求类型 string
     * $res 返回数据类型 string
     * $arr post的请求参数 string*/
    private function http_curl($url, $type = 'get', $res = 'json', $arr = '')
    {
        //1、初始化curl
        $ch = curl_init();
        //2、设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//将抓取到的东西返回
        if ($type == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);// 传递一个作为HTTP “POST”操作的所有数据的字符串。
        }
        //3、采集
        $output = curl_exec($ch);

        if ($res == 'json') {
            if (curl_errno($ch)) {
                //请求失败，返回错误信息
                $str=curl_error($ch);
                //4、关闭
                curl_close($ch);
                return $str;
            } else {
                //请求成功
                $json=json_decode($output, true);
                //4、关闭
                curl_close($ch);
                return $json;
            }
        }
    }
}
?>