<?php
Route::group(['namespace'=>'Home2'],function(){
    Route::get('home2/shop/index','ShopController@index');//商城首页
    Route::get('home2/shop/goodsDetail','ShopController@goodsDetail');//商品详情
    Route::get('home2/shop/BaihuoMall','ShopController@BaihuoMall');  //商城分类
    Route::get('home2/shop/goodsList','ShopController@goodsList');  //商品列表
    Route::get('home2/shop/rankingList','ShopController@rankingList');  //排行榜单
    Route::get('home2/shop/paySuccess','ShopController@paySuccess');  //支付完成

//    Route::get('shop','ShopController@index');//商城首页
   Route::get('/hoem2/shop/cart','ShopController@cart');     //购物车---------需登录
    Route::get('/home2/shop/addCart','ShopController@addCart');   //加入购物车------需登录
   Route::get('/home2/shop/cartEdit','ShopController@cartEdit'); //购物车修改 ------需登录
   Route::get('/home2/shop/cartDel','ShopController@cartDel'); //购物车删除 ------需登录
   Route::get('/home2/shop/submitOrders','ShopController@submitOrders');//购物车确认页------需登录
   Route::get('/home2/shop/payment','ShopController@payment');   //购买页------需登录
   Route::post('/home2/shop/order_pay','ShopController@order_pay');   //订单余额支付-------需登录

    // Route::get('home2/shop/judgeLimitPay','ShopController@judgeLimitPay');   //每天限购10次对于每个网盘

//    Route::post('shop/recash_point','ShopController@recash_point');   //订单复投积分支付-------需登录
//    Route::get('shop/','ShopController@index');//商城首页
});
