<?php
Route::get('goodsClass/index','GoodsClassController@index');//加载商品分类视图
Route::post('goodsClass/addClass','GoodsClassController@addClass');//添加商品分类
Route::get('goodsClass/list','GoodsClassController@goodsList');//加载商品分类列表视图
Route::post('goodsClass/secondClass','GoodsClassController@secondClass');//分类列表中获取二级分类数据
Route::get('goodsClass/editClass/{id}','GoodsClassController@editClass');//加载商品列表中的修改视图
Route::post('goodsClass/actEditClass','GoodsClassController@actEditClass');//执行商品分类修改操作
Route::post('goodsClass/goodsClassDel','GoodsClassController@goodsClassDel');//商品分类列表中的删除操作
Route::post('goodsClass/sort','GoodsClassController@sort');//商品分类列表中的排序操作
Route::post('goodsClass/whetherDisplay','GoodsClassController@whetherDisplay');//商品分类列表中的显示不显示操作
?>