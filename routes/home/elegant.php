<?php
Route::group(['namespace'=>'Home'],function(){
    Route::get('elegant/index','ElegantController@index');//贵人币注册视图1
    Route::get('elegant/index_view','ElegantController@index2');//贵人币注册视图2
    Route::post('elegant/nextAct','ElegantController@nextAct');//执行贵人币下一步操作
    Route::post('elegant/register','ElegantController@register');//贵人币注册操作
});

?>