<?php
Route::get('withdraw/cashList','WithdrawController@cashList');
Route::get('withdraw/accountslist','WithdrawController@accountslist');// 转账列表

Route::any('withdraw/pass/{id?}','WithdrawController@pass');//提现通过
Route::post('withdraw/fell','WithdrawController@fell');//提现驳回

Route::get('withdraw/aliCashPass/{id}','WithdrawController@aliCashPass');//支付宝提现通过

Route::get('aliCash/index/{id}','AliCashController@index');//提现驳回
?>