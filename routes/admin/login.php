<?php
Route::get('login/index','Admin\LoginController@index');//加载后台登录页面
Route::post('login/login','Admin\LoginController@login');//后台登录处理
Route::get('login/layout','Admin\LoginController@layout');//后台退出处理