<?php
namespace App\Http\Services;
use App\Http\Model\Admin\Admin;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/14
 * Time: 13:21
 */
class AdminService
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin=$admin;
    }

    public function getUserInfo()//得到解码信息
    {
        $res=$this->admin->getDecrypt(session('info'));
        if($res){
            $arr=explode('-',$res);
            return $arr;
        }else{
            return false;
        }
    }
}