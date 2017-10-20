<?php

	#轮播图

    Route::get('banner/index','BannerController@index');//轮播图页面
	Route::any('banner/add','BannerController@add');//添加页面
	Route::any('banner/edit/{id}','BannerController@edit');//修改页面
	
    Route::post('banner/editinfo','BannerController@editinfo');//执行修改信息操作

    #公告notice
    Route::get('banner/noticeindex','BannerController@noticeindex');//轮播图页面
	Route::any('banner/noticeadd','BannerController@noticeadd');//添加处理
	Route::any('banner/noticeedit/{id}','BannerController@noticeedit');//修改页面
  

    #简介brief
    Route::get('banner/briefindex','BannerController@briefindex');//轮播图页面
	Route::any('banner/briefadd','BannerController@briefadd');//添加处理
	Route::any('banner/briefedit/{id}','BannerController@briefedit');//修改页面
 

    #新手必看novice
    Route::get('banner/novvveindex','BannerController@novvveindex');//轮播图页面
	Route::any('banner/novvveadd','BannerController@novvveadd');//添加处理
	Route::any('banner/novvveedit/{id}','BannerController@novvveedit');//修改页面

	
	Route::any('banner/del','BannerController@del');//删除处理
	




