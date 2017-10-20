<?php
Route::get('adminWheel/index','WheelController@index');//加载转盘视图
Route::post('adminWheel/editWheel','WheelController@editWheel');//执行修改转盘配置操作
Route::get('adminWheel/wheelList','WheelController@wheelList');//幸运转盘列表
