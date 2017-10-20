<?php
Route::group(['namespace'=>'Home2'],function(){
    Route::any('register/index/{pid?}','LoginController@index');//加载注册页面
    Route::get('register/agreement','LoginController@agreement');//加载用户注册协议页面
    Route::post('register/goRegister','LoginController@goRegister');//添加去注册
    Route::post('register/sendCode','LoginController@sendCode');//发送验证码

    Route::post('register/sendyamcode','LoginController@sendyamcode');//发送修改支付和登录验证码

    
    Route::post('register/sssendCode','LoginController@sssendCode');//验证码
    Route::post('login/homeLogin','LoginController@login');//执行登录操作
    Route::get('forget/forgetPwd','LoginController@forgetPwd');//加载忘记密码操作
    Route::post('forget/editPwd','LoginController@editPwd');//执行忘记密码操作
});
?>