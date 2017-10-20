<?php
Route::group(['namespace'=>'Home'],function() {
    Route::get('wxpay/index/{order_id?}/{openid?}', 'WxPayController@index');//发起微信支付
    Route::get('wxpay/getOpenId/{id}', 'WxPayController@getOpenId');//获取openid
    Route::any('callBack/paynotify', 'CallBackController@paynotify');//微信回调地址
    //微信App支付
    Route::get('wxAppPay/sendRequest','WxAppPayController@sendRequest');//发起微信App支付
    Route::any('wxAppPay/notify','WxAppPayController@notify');//微信App支付回调地址

    //网页授权
    Route::get('wxChat/index', 'WxChatController@index');//检测当前环境是否是微信端
    Route::get('wxChat/loginRegister', 'WxChatController@loginRegister');//进行授权

    //微信认证
    Route::any('wxAuth/weiXinChat', 'WxAuthController@weiXinChat');//微信认证
})
?>
