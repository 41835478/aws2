<?php

	Route::get('users/index','UserController@index');//用户主页

	Route::get('users/myaccount','UserController@myaccount');//账户信息
	Route::get('users/turnaccount','UserController@turnaccount');//余额转账
	Route::get('users/withdrawals','UserController@withdrawals');//账户体现
	Route::get('users/choosebnak','UserController@choosebnak');//选择银行卡
	Route::post('users/editaccount','UserController@editaccount');//余额提交

	Route::get('users/editdata','UserController@editdata');//修改用户资料
	Route::post('users/editdatainfo','UserController@editdatainfo');//修改用户资料

	Route::get('users/myintegral','UserController@myintegral');//积分主页
	Route::get('users/recastIntegral','UserController@recastIntegral');//复投积分
	Route::get('users/consumption','UserController@consumption');//消费积分
	Route::get('users/looppoints','UserController@looppoints');//复投积分
	Route::any('users/turnmyintegral/{id}','UserController@turnmyintegral');//积分转账
	Route::post('users/editintegral','UserController@editintegral');//积分转账提交

	Route::get('users/mybonus','UserController@mybonus');//我的奖金
	Route::any('users/bonus_jiandian/{id?}','UserController@bonus_jiandian');//见点奖金奖金

	
	Route::get('users/jifenshengji','UserController@jifenshengji');//积分升级
	Route::get('users/ranking_orders','UserController@ranking_orders');//公排订单
	Route::get('users/myteam','UserController@myteam');//我的团队
	Route::get('users/activememberorders','UserController@activememberorders');//激活会员订单页面
	Route::post('users/editactivememberorders','UserController@editactivememberorders');//激活会员订单
	


	Route::get('users/accountbinding','UserController@accountbinding');//账户绑定页面
	Route::get('users/addbank/{id?}','UserController@addbank');//添加银行卡页面
	Route::get('users/bindingaliplay','UserController@bindingaliplay');//绑定支付宝页面
	Route::post('users/bindingdel','UserController@bindingdel');//解除 删除绑定
	Route::post('users/editbinding','UserController@editbinding');//提交

	Route::get('users/shippingaddress','UserController@shippingaddress');//收货地址
	Route::get('users/manageaddress','UserController@manageaddress');//管理收货地址
	Route::post('users/addressdefault','UserController@addressdefault');//设为默认收货地址
	Route::get('users/toaddress','UserController@toaddress');//添加收货地址页面
	Route::post('users/editaddress','UserController@editaddress');//添加收货地址页面
	Route::post('users/addressEdit','UserController@addressEdit');//修改收货地址	


	Route::any('users/userorder/{type}','UserController@userorder');//用户订单
	Route::any('users/userorderin/{id}','UserController@userorderin');//用户订单详情
	Route::post('users/edituserorder','UserController@edituserorder');//用户订单修改
	
	Route::get('users/createqrcode','UserController@createqrcode');//生成二维码
	Route::get('users/bingwx','UserController@bingwx');//二维码
	Route::get('users/logout','UserController@logout');//退出

	Route::get('users/balance','UserController@balance');//余额充值记录
    Route::get('users/mynumcount','UserController@mynumcount');//我的团队人数

    #三次开发路由
    Route::get('users/crowdfunding','UserController@crowdfunding');//众筹奖金
    Route::get('users/loverDetail','UserController@loverDetail');//爱心值明细
    Route::get('users/loverBonus','UserController@loverBonus');//爱心奖金
    Route::get('users/stockBonus','UserController@stockBonus');//股东分红
    Route::get('users/loverDistribution','UserController@loverDistribution');//爱心分销奖
    Route::get('users/loverleader','UserController@loverleader');//爱心领导奖
    Route::get('users/loverleader2','UserController@loverleader2');//爱心领导奖详情
    Route::get('users/myTeam_new','UserController@myTeam_new');//我的团队




    Route::group(['middleware'=>'qrcode'],function(){
        Route::get('users/qrcode','UserController@qrcode');//用户二维码
    })

?>