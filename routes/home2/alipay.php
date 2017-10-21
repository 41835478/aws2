<?php
Route::group(['namespace'=>'Home2'],function() {
    Route::get('alipay/index/{order_id?}', 'AliPayController@index');//发起支付宝支付
    Route::any('home2/aliPay/return_url', 'AliPayController@return_url');//支付宝支付回调地址

    Route::get('aliAppPay/aliPay/{id?}', 'AliAppPayController@aliPay');//发起支付宝App支付
    Route::any('aliAppPay/notify_url', 'AliAppPayController@notify_url');//支付宝支付App回调地址
})
?>

