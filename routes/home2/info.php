<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 9:53
 */
Route::group(['namespace'=>'Home2'],function(){
    Route::get('info/info','InfoController@info');//项目简介
    Route::get('info/newList','InfoController@newList');//新手必看
    Route::get('info/newInfo','InfoController@newInfo');//新手必看文章页
    Route::get('info/sysList','InfoController@sysList');//系统公告
    Route::get('info/sysInfo','InfoController@sysInfo');//公告详情

    //该路由组用于锁定用户操作
    Route::group(['middleware'=>'lock'],function(){
        /*我的账户*/
        Route::get('info/account_settings','InfoController@account_settings');//账户设置

        Route::get('info/modify_login','InfoController@modify_login');//修改登录密码
        Route::get('info/modify_pay','InfoController@modify_pay');//修改支付密码
        Route::post('info/user_info','InfoController@user_info');//修改信息提交
    });
});
