<?php

namespace App\Listeners;

use App\Events\DistributionEvent;
use App\Http\Model\BalanceRecord2;
use App\Http\Model\User;
use App\Services\AccountRecordService;
use App\Services\ThreeRecordService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DistributionEventListener
{
    protected $accountRecordService;
    protected $threeRecordService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AccountRecordService $accountRecordService, ThreeRecordService $recordService)
    {
        $this->accountRecordService = $accountRecordService;
        $this->threeRecordService = $recordService;
    }

    /**
     * Handle the event.
     *
     * @param  DistributionEvent  $event
     * @return void
     */
    public function handle(DistributionEvent $event)
    {
        //定义几级返佣对应配置表的返佣比例id
        $data = [
            1 => 2,
            2 => 3,
            3 => 4,
        ];
        //三级分销返佣;
        \Log::info('三级返佣开始');
        $totalMoney = $event->data['money'];//投资订单总价格
        $level = $event->data['level'];//几级返佣
        $user_id = $event->data['user_id'];
        if ($level > 0 && $level <= 3) {

            if ($level == 1) {

                $user = User::find($user_id);

            } else {
                $user = User::find($event->data['upUser_id']);
            }
            $upUser = $user->upUser;


            if (count($upUser) > 0) {//一级
                if ($level == 1) {
                    if ($user->consumer_num == 1) {
                        $upUser->increment('recommend_count');
                    }
                }
                //获取用户的日封顶
                $money = 0;
                $investment = $upUser->investment;
                if (count($investment) > 0) {
                    //计算封顶收益
                    $investmentTotalMoney = $investment->money + $investment->give_money;
                    $moneyPercentage = $investment->money / $investmentTotalMoney;
                    $investmentMoney = $investment->money - $moneyPercentage * $investment->sum_money;
                    $money = getInt($investmentMoney);
                    if ($money > 10000) {
                        $money = 10000;
                    }
                }
                \Log::info('日封顶' . $money);
                $dayMoney = $upUser->accountRecords()
                    ->whereIn('type', [BalanceRecord2::TYPE_TEAM_PRIZE, AccountRecord::TYPE_THREE_LEVEL])
                    ->where('created_at', '>=', Carbon::today())
                    ->where('created_at', '<=', Carbon::today()->addDay())
                    ->sum('num');//获取今天的所有下级收益
                \Log::info('上级今天收益' . $dayMoney);

                if ($money > $dayMoney) { //如果日封顶为达到继续奖励
                    $config_id = $data[$level];//获取配置表id

                    $value = Config::find($config_id)->value;
                    $percentage = $value / 100; //计算百分比
                    \Log::info($level . '级百分比' . $percentage);
                    $userIncome = $totalMoney * $percentage;//计算返佣钱
                    if (($dayMoney + $userIncome) > $money) {//把超出的收益减去;
                        $userIncome = $money - $dayMoney;
                    }
                    $res = $this->threeRecordService->setRecord($user_id, $upUser->id, $userIncome, $level . '代分销奖金');
                    if ($res) {
                        $res1 = $this->accountRecordService->setAccountRecord($upUser->id, $userIncome, AccountRecord::TYPE_THREE_LEVEL, $level . '代分销奖金', 1);

                        if ($res1) {
                            $res2 = $upUser->increment('dynamic_income', $userIncome);
                            if ($res2) {
                                \Log::info($level . '级返佣成功');
                                event(new ThreeLevelEvent(['level' => $level + 1, 'money' => $totalMoney, 'user_id' => $user_id, 'upUser_id' => $upUser->id]));
                            } else {
                                \Log::info($level . '级动态余额失败');

                            }
                        } else {
                            \Log::info($level . '级账户记录失败');
                        }
                    } else {
                        \Log::info($level . '级三级记录失败');
                    }
                } else {
                    \Log::info('用户日封顶达到直接越过，为下一级用户返佣');
                    event(new ThreeLevelEvent(['level' => $level + 1, 'money' => $totalMoney, 'user_id' => $user_id, 'upUser_id' => $upUser->id]));
                }


            } else {

                \Log::info('没有上级无需返佣');

            }
        } else {
            \Log::info('三级返佣结束');
        }
    }
}
