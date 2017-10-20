<?php
Route::group(['namespace' => 'Admin','prefix'=>'user','middleware'=>'admin'], function () {
    //管理员管理
    Route::get('index','UserController@index');//加载修改管理员信息视图
    Route::post('validatePwd','UserController@validatePwd');//验证旧密码是否正确
    Route::post('actEditPwd','UserController@actEditPwd');//执行修改管理员密码
    Route::get('editInfo','UserController@editInfo');//加载修改管理员信息视图
    Route::post('actEditInfo','UserController@actEditInfo');//执行修改管理员信息操作
});