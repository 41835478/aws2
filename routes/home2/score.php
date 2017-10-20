<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 9:53
 */
//Route::group(['namespace'=>'Home'],function(){
    Route::get('score/index','ScoreController@index');//首页
    Route::get('score/list','ScoreController@lists');//列表
    Route::get('score/info','ScoreController@info');//详情
    Route::post('score/exchange','ScoreController@exchange');//提交兑换
//});
?>