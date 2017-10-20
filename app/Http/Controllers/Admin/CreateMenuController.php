<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateMenuController extends Controller
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu=$menu;
    }

    public function getAccessToken()//得到微信access_token
    {
        //将access_token 存在session/cookie中
        if (session('access_token') && session('expire_time') > time()) {
            //如果access_token在session并没有过期
            return session('access_token');
        } else {
            //如果access_token不存在或者已经过期，重新取access_token
            $appId = config("home.GZ_APPID");
            $appSecret = config("home.GZ_SECRET");
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appId . "&secret=" . $appSecret;
            $res = $this->http_curl($url, 'get', 'json');
            $access_token = $res['access_token'];
            //将重新获取到的access_token存到session
            session(['access_token'=>$access_token]);
            session(['expire_time'=>time() + 7000]);
            return $access_token;
        }
    }

    public function customMenu()//微信自定义菜单
    {
        $date=$this->menu->where(['parent_id'=>0])->orderBy('sort','asc')->limit(3)->get();
        $postArr=array();
        foreach($date as $v){
            $childArr = $this->menu->where(['parent_id'=>$v['id']])->get()->toArray();
            $arr = array();
            $arr['name'] = urlencode($v['name']);
            if($childArr){
                $arr['sub_button'] = array();
                foreach($childArr as $v2){
                    $arr2 = array();
                    $arr2['name'] = urlencode($v2['name']);
                    if($v2['type'] == 2){
                        $arr2['type'] = 'view';
                        $arr2['url'] = $v2['url'];
                    }else{
                        $arr2['type'] = 'click';
                        $arr2['key'] = 'click_'.$v2['id'];
                    }
                    $arr['sub_button'][] = $arr2;
                }
            }else{
                if($v['type'] == 2){
                    $arr['type'] = 'view';
                    $arr['url'] = $v['url'];
                }else{
                    $arr['type'] = 'click';
                    $arr['key'] = 'click_'.$v['id'];
                }
            }
            $postArr['button'][] = $arr;
        }
        $access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        $postJson = urldecode(json_encode($postArr));
        $res = $this->http_curl($url,'post', 'json',$postJson);
        if($res['errcode']==0&&strtolower($res['errmsg']=='ok')){
            return back()->with('success','生成微信底部菜单成功');
        }
        return back()->withErrors('生成微信底部菜单失败');
    }

    /*
     * $url 接口url
     * $type 请求类型 string
     * $res 返回数据类型 string
     * $arr post的请求参数 string*/
    public function http_curl($url, $type = 'get', $res = 'json', $arr = '')
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
        //4、关闭
        curl_close($ch);
        if ($res == 'json') {
            return json_decode($output, true);
        }
    }
}
