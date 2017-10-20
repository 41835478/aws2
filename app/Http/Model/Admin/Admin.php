<?php

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $key='huaLove1314';
    protected $rand='ILoveYou';

    protected $table="admin";

    public function getEncrypt($data)//得到加密值
    {
        $encrypt = $this->encrypt($data, $this->key);
        return $encrypt;
    }

    public function getDecrypt($data)//得到解密
    {
        $decrypt = $this->decrypt($data, $this->key);
        return $decrypt;
    }

    public function encrypt($data, $key)
    {
        $key = md5($key);
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= $key{$x};
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }

    public function decrypt($data, $key)
    {
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        $char = $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            } else {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return $str;
    }

    public function updateAdmin($ip,$id)//更新admin表
    {
        $first=$this->find($id);
        $first->last_time=$first->current_time;
        $first->current_time=time();
        $first->last_ip=$first->current_ip;
        $first->current_ip=$ip;
        $first->status=1;
        if($first->save()){
            return true;
        }
        return false;
    }
}
