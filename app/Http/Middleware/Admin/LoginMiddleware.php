<?php

namespace App\Http\Middleware\Admin;

use App\Http\Model\Admin\Admin;
use App\Http\Model\Auth_group;
use App\Http\Model\Auth_rule;
use Closure;
use Illuminate\Http\Request;
use DB;
class LoginMiddleware
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin=$admin;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('info')){
            $res=$this->getInfo();
                  

            if(!$res){
                return redirect(url('login/index'))->with('error','亲你还没有登录哦！');
            }else{

                 //$path= $request->path();
                //$path=$_SERVER['REQUEST_URI'];
                //$this->quanxian($path);
                return $next($request);
            }
      
        }else{
            return redirect(url('login/index'))->with('error','亲你还没有登录哦！');
        }
    }

    private function getInfo()
    {
        $res=$this->admin->getDecrypt(session('info'));

        if($res){
            $arr=explode('-',$res);

            $result=$this->admin->where(['mobile'=>$arr[0],'id'=>$arr[1],'status'=>1])->first();
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            return redirect(url('login/index'))->with('error','亲你还没有登录哦！');
        }
    }


    public function quanxian($path){
        $res=$this->admin->getDecrypt(session('info'));
        $arr=explode('-',$res);

        $auth=Auth_group::where('a_id',$arr[1])->first();

        $array=explode(',',$auth['rules']);
        $auth_rule=Auth_rule::whereIn('id',$array)->pluck('name');
        $auth_rule=$auth_rule->toArray();
     

        $coun=substr_count($path,'/');
  
        if($coun >= 2){
 
                $ccahang=strripos($path,"/");
                $zchang=strlen($path);
                $jchang=$zchang-$ccahang;
                $path=substr($path, 0, -$jchang);

    
        }
        if($coun > 2){
 
                $ccahang=strripos($path,"/");
                $zchang=strlen($path);
                $jchang=$zchang-$ccahang;
                $path=substr($path, 0, -$jchang);

    
        }
//dd($path);
        if( !in_array($path,$auth_rule)){
            dd('暂无权限');
            //return redirect(url('admin/index'))->with('error','无权限');
        }

    }





}
