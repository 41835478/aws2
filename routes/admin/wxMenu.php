<?php
Route::get('menu/index','WxMenuController@index');//加载添加微信一级菜单视图
Route::post('menu/actNav','WxMenuController@actNav');//执行添加微信一级菜单操作

Route::get('menu/nav','WxMenuController@nav');//加载添加微信底部菜单视图
Route::post('menu/addMenu','WxMenuController@addMenu');//添加微信底部菜单

Route::get('menu/menuList','WxMenuController@menuList');//微信菜单列表
Route::get('menu/menuEdit/{id}','WxMenuController@menuEdit');//加载微信菜单列表中的修改操作
Route::post('menu/sort','WxMenuController@sort');//微信菜单列表中的排序操作
Route::post('menu/menuDel','WxMenuController@menuDel');//微信菜单列表中的删除操作

Route::get('menu/editFirstNav','WxMenuController@editFirstNav');//加载修改一级菜单视图
Route::post('menu/actEditNav','WxMenuController@actEditNav');//执行修改一级菜单操作

Route::post('menu/actEditMenu','WxMenuController@actEditMenu');//修改微信底部菜单

Route::get('createMenu/customMenu','CreateMenuController@customMenu');//生成微信导航菜单
?>