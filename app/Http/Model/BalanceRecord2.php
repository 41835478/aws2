<?php/** * Created by PhpStorm. * User: Administrator * Date: 2017/10/23 * Time: 15:44 */namespace App\Http\Model;use Illuminate\Database\Eloquent\Model;class BalanceRecord2 extends Model{    protected $table = 'balance_records2';    protected $fillable = ['user_id','type','is_add','num','info'];    const TYPE_DISTRIBUTION_PRIZE = 1; //分销奖    const TYPE_LEADER_PRIZE = 2; //领导奖    const TYPE_WITHDRAW_PRIZE = 3; //提现    const TYPE_INVESTMENT = 4; //众筹}