<?php
namespace App\Http\Services;
class AuthService
{
    private $pwdKey = 'jbs2017821,aiwushang';
    private $userIdKey = '2017619jbs,awstoken';
    private $iv='ILoveYou:myGirlFriend,1314.jbs';

//    public function userIdEncrypt($data)//用户id加密
//    {
//        $cryptText = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->pwdKey), $data, MCRYPT_MODE_CBC, md5(md5($this->pwdKey))));
//        $encrypted = trim($this->safe_b64encode($cryptText));////对特殊字符进行处理
//        return $encrypted;
//    }
//
//    public function userIdDecrypt($data)//用户id解密
//    {
//        $cryptTextTb = $this->safe_b64decode($data);//对特殊字符解析
//        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->pwdKey), base64_decode($cryptTextTb), MCRYPT_MODE_CBC, md5(md5($this->pwdKey))));
//        return $decrypted;
//    }

    public function rememberEncrypt($data)//用户id加密
    {
        $method = openssl_get_cipher_methods();
        $value = serialize($data);
        $date['iv'] = base64_encode(substr($this->iv, 0, 16));
        $date['value'] = openssl_encrypt($value, $method[1], $this->userIdKey, 0, base64_decode($date['iv']));
        $encrypt = base64_encode(json_encode($date));
        return $encrypt;
    }

    public function rememberDecrypt($data)//用户id解密
    {
        $method = openssl_get_cipher_methods();
        $encrypt = json_decode(base64_decode($data), true);
        $iv = base64_decode($encrypt['iv']);
        $tokenDeOpenssl = openssl_decrypt($encrypt['value'], $method[1], $this->userIdKey, 0, $iv);
        $decrypt = unserialize($tokenDeOpenssl);
        if($decrypt){
            return $decrypt;
        }
        return false;
    }

    //处理特殊字符
    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    //解析特殊字符
    public function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}
?>