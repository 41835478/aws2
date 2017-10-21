<?php

	#会员操作

    Route::get('admin2/order/index','OrderController@index');//订单列表
	Route::any('admin2/order/orderinfo/{id}','OrderController@orderinfo');//订单详情
	Route::any('admin2/order/edit/{id}','OrderController@edit');//修改页面
	//Route::any('order/del','OrderController@del');//删除处理
    Route::post('admin2/order/editinfo','OrderController@editinfo');//执行修改信息操作
    Route::get('admin2/order/export','OrderController@export');//订单列表



   

