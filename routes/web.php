<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

////后台路由
Route::get('captcha/{tmp}','Admin\CaptchaController@captcha');//验证码
Route::group(['namespace' => 'Admin','middleware'=>'admin'], function () {
    //后台首页开始
    Route::get('admin/index', 'BaseController@index')->name('admin.index');
    Route::get('index/index', 'IndexController@index');

    Route::get('crontab/index','CrontabController@index');//定时清空三盘的购买次数的数据

    require_once base_path('routes/admin/webOnoff.php');//网站开关
    //后台首页结束
    require_once base_path('routes/admin/goodsClass.php');//商品分类
    require_once base_path('routes/admin/goods.php');//商品管理
    require_once base_path('routes/admin/banner.php');
    require_once base_path('routes/admin/member.php');

    require_once base_path('routes/admin/order.php');
    require_once base_path('routes/admin/Data.php');
    require_once base_path('routes/admin/admin_wheel.php');//幸运转盘管理
    require_once base_path('routes/admin/withdraw.php');//提现管理
    require_once base_path('routes/admin/direct.php');//分销管理
    require_once base_path('routes/admin/row.php');//公排管理

    require_once base_path('routes/admin/elegant.php');//贵人币管理

    require_once base_path('routes/admin/discRow.php');//三网公排管理

    require_once base_path('routes/admin/wxMenu.php');//微信底部菜单

});

#众筹专区后台
Route::group(['namespace' => 'Admin2','middleware'=>'admin'], function () {
    require_once base_path('routes/admin2/investment.php');
    require_once base_path('routes/admin2/goodsClass.php');//商品分类
    require_once base_path('routes/admin2/goods.php');//商品管理
    require_once base_path('routes/admin2/order.php');
    require_once base_path('routes/admin2/Data.php');
    require_once base_path('routes/admin2/users.php');


});
require base_path('routes/admin/user.php');//后台管理员管理
require_once base_path('routes/admin/login.php');//后台登录退出

//----------------------------------------------------------------以下为前台路由--------------------------------------------------------------------------

Route::get('test/index','Home\TestCellController@index');//测试控制器

require_once base_path('routes/home/homeLogin.php');//前台注册、登录

Route::get('crontab/dealRedis','Home\CrontabController@dealRedis');//定时任务进行排单
Route::get('task/index','Home\CrontabController@index');//定时任务进行清空用户购买次数
Route::get('lucky/wheelLuck','Home\CrontabController@wheelLuck');//定时任务进行清空用户幸运转盘转动次数

Route::group(['middleware'=>'on.off'],function(){
    Route::get('/', 'Home\ShopController@index');//网站首页
    ////前台路由

    Route::get('direct/index','Home\DirectController@index');//算法控制器
//
    Route::group(['middleware'=>'lock'],function(){//该路由组用于锁定用户操作
        Route::group(['namespace'=>'Home','middleware'=>'home.auth'],function(){
            require_once base_path('routes/home/user.php');
            require_once base_path('routes/home/login_shop.php');//积分商城
            require_once base_path('routes/home/score.php');//积分商城
        });
    });
    require_once base_path('routes/home/wxPay.php');//微信支付
    require_once base_path('routes/home/alipay.php');//支付宝支付
//    require_once base_path('routes/home/homeLogin.php');//前台注册、登录
    require_once base_path('routes/home/info.php');//商城文章页,我的账户路由-------【这里面有锁定用户操作的路由组】
    require_once base_path('routes/home/shop.php');//商城首页路由

    #前台众筹专区商品
    require_once base_path('routes/home2/shop.php');//商城首页路由
    require_once base_path('routes/home2/wxPay.php');//微信支付
    require_once base_path('routes/home2/alipay.php');//支付宝支付    
    // require_once base_path('routes/home/wheel.php');//大转盘

    require_once base_path('routes/home/elegant.php');//贵人币注册
});

Route::get('web.onOff',function(){
    return view('home.public.onOff',['str'=>'系统正在维护中，请稍后再试。。。','flag'=>1]);//加载网站开关视图
});
Route::get('cart.onOff',function(){
    return view('home.public.onOff',['str'=>'系统购物功能尚未开放，敬请期待。。。','flag'=>2]);//加载网站购物开关视图
});
Route::get('qrcode.onOff',function(){
    return view('home.public.onOff',['str'=>'系统二维码功能尚未开放，请稍后再试。。。','flag'=>2]);//加载网站二维码开关视图
});
Route::get('uses.locking',function(){
    return view('home.public.onOff',['str'=>'您的账号已经被系统锁定，如有疑问请联系客服','flag'=>2]);//加载用户账号锁定视图
});


Route::get('test/insert','Admin2\CrontabController@action');
