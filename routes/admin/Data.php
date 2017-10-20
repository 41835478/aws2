<?php
Route::get('data/index','DataController@index');//数据统计

Route::get('data/configindex','DataController@configindex');//参数页面
Route::any('data/configinfo','DataController@configinfo');//参数提交

Route::get('data/oneorder','DataController@oneorder');//业绩

