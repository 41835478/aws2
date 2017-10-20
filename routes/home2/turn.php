<?php
Route::get('turn/index','TurnController@index');//数据统计

Route::any('turn/configinfo','TurnController@configinfo');//参数提交