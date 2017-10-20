<?php

	#会员操作

    Route::get('member/index','MemberController@index');//会员列表
    Route::post('member/locking','MemberController@locking');//会员列表中的锁定解锁功能
    Route::post('member/loginPwd','MemberController@loginPwd');//会员列表中的修改会员登录密码功能

    Route::get('member/recharge','MemberController@rechargeList');//会员充值记录列表

    Route::get('member/addUser','MemberController@addUser');//加载添加会员视图列表
    Route::post('member/actUser','MemberController@actUser');//执行添加会员操作

	Route::any('member/edit/{id}','MemberController@edit');//修改页面
	Route::any('member/del','MemberController@del');//删除处理
    Route::post('member/editinfo','MemberController@editinfo');//执行修改信息操作

    Route::post('member/nextUser','MemberController@loopNextUser');//获取下级

    Route::any('member/sheng/{id}','MemberController@sheng');//生成订单页面
    Route::post('member/shenginfo','MemberController@shenginfo');//生成订单页面提交

   

