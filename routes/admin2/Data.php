<?php
Route::get('admin2/data/index','DataController@index');//数据统计

Route::any('admin2/data/configindex','DataController@configindex');//参数页面
Route::any('admin2/data/configinfo','DataController@configinfo');//参数提交

