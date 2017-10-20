<?php
Route::group(['namespace'=>'Home'],function() {
    Route::get('wheel/index', 'WheelController@index');//加载前台转盘首页
    Route::post('wheel/luckyStart','WheelController@luckyStart');//判断用户是否登录只用登陆的用户才可抽奖
})
?>