<?php
Route::group(['middleware'=>'cart'],function(){
    Route::get('/shop/cart','ShopController@cart');     //购物车---------需登录
//    Route::get('/shop/addCart','ShopController@addCart');   //加入购物车------需登录
    Route::get('/shop/cartEdit','ShopController@cartEdit'); //购物车修改 ------需登录
    Route::get('/shop/cartDel','ShopController@cartDel'); //购物车删除 ------需登录
    Route::get('/shop/submitOrders','ShopController@submitOrders');//购物车确认页------需登录
    Route::get('/shop/payment','ShopController@payment');   //购买页------需登录
    Route::post('/shop/order_pay','ShopController@order_pay');   //订单余额支付-------需登录
    Route::post('shop/recash_point','ShopController@recash_point');   //订单复投积分支付-------需登录
});
?>