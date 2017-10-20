<?php
Route::get('row/index','RowController@index');//点位升级列表
Route::get('row/point','RowController@point');//见点奖列表
Route::get('row/recommend','RowController@recommend');//推荐奖列表
Route::get('row/promote','RowController@promote');//升级奖列表
Route::get('row/rowOrder','RowController@rowOrder');//排位订单记录表
Route::get('row/promoteInfo','RowController@promoteInfo');//升级信息记录列表

Route::get('row/integral','RowController@integral');//积分记录表
?>