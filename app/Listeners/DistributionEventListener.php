<?php

namespace App\Listeners;

use App\Events\DistributionEvent;
use App\Http\Model\BalanceRecord2;
use App\Http\Model\Config2;
use App\Http\Model\User;
use App\Services\AccountRecordService;
use App\Services\ThreeRecordService;

use Illuminate\Support\Facades\Log;

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
            1 => 5,
            2 => 6,
            3 => 7,
            4 => 8,
            5 => 9,
            6 => 10,
            7 => 11,
            8 => 12,
            9 => 13,
        ];
        \Log::info('分销返佣开始');
        $totalMoney = $event->data['money'];//投资订单总价格
        $level = $event->data['level'];//几级返佣
        $user_id = $event->data['user_id'];
        $maxLevel = Config2::find(4)->value('value'); //获取分销奖励层数
        if ($level > 0 && $level <= $maxLevel) {

            $user = User::find($user_id);
            Log::info('用户',[$user->toArray()]);
            $upUser = $user->upUser;

            if (count($upUser) > 0) {//一级
                Log::info('上级用户',[$upUser->toArray()]);
                if ($level == 1 && $user->consumer_num == 1) { //第一级返佣，并且用户第一消费，给上级推荐人加1
                    $upUser->increment('recommend_count');
                }
                $recommend_result = $upUser->recommend_count >= $level; //判断直推几人拿几代

                if($recommend_result){ //判断能拿几代奖金
//                    //获取用户的日封顶
//                    $money = 0;
//                    $config25 = Config2::find(25)->value('value');
//                    $config26 = Config2::find(26)->value('value');
//                    $config27 = Config2::find(27)->value('value');
//                    $config28 = Config2::find(28)->value('value');
//
//                    if($upUser->recommend_count >=1 && $upUser->recommend_count < $config25)
//                    {
//                        $money = 1000;
//                    }
//                    elseif ($upUser->recommend_count >= $config25 && $upUser->recommend_count <$config26)
//                    {
//                        $money = 2000;
//                    }
//                    elseif ($upUser->recommend_count >= $config26 && $upUser->recommend_count < $config27)
//                    {
//                        $money = 4000;
//                    }
//                    elseif ($upUser->recommend_count >= $config27 && $upUser->recommend_count <$config28)
//                    {
//                        $money = 8000;
//                    }
//
//                \Log::info('日封顶' . $money);
//                    $dayMoney = $upUser->accountRecords()
//                        ->whereIn('type', [BalanceRecord2::TYPE_DISTRIBUTION_PRIZE, BalanceRecord2::TYPE_LEADER_PRIZE])
//                        ->where('created_at', '>=', Carbon::today())
//                        ->where('created_at', '<=', Carbon::today()->addDay())
//                        ->sum('num');//获取今天的所有下级收益
//                    \Log::info('上级今天收益' . $dayMoney);

//                    if ($money > $dayMoney) { //如果日封顶为达到继续奖励
                        $config_id = $data[$level];//获取配置表id
                        $value = Config2::find($config_id)->value;
                        $percentage = $value / 100; //计算百分比
                        \Log::info($level . '级百分比' . $percentage);
                        $userIncome = $totalMoney * $percentage;//计算返佣钱
//                        if (($dayMoney + $userIncome) > $money) {//把超出的收益减去;
//                            $userIncome = $money - $dayMoney;
//                        }
                        $res = $this->threeRecordService->setRecord($user_id, $upUser->id, $userIncome, $level . '代分销奖金');
                        if ($res) {
                            $res1 = $this->accountRecordService->setAccountRecord($upUser->id, $userIncome, BalanceRecord2::TYPE_DISTRIBUTION_PRIZE, $level . '代分销奖金', 1);
                            if ($res1) {
                                $res2 = $upUser->increment('account', $userIncome);
                                if ($res2) {
                                    \Log::info($level . '级返佣成功');
                                    event(new DistributionEvent(['level' => $level + 1, 'money' => $totalMoney, 'user_id' => $user_id,]));
                                } else {
                                    \Log::info($level . '级动态余额失败');
                                }
                            } else {
                                \Log::info($level . '级账户记录失败');
                            }
                        } else {
                            \Log::info($level . '级记录失败');
                        }
//                    } else {
//                        \Log::info('用户日封顶达到直接越过，为下一级用户返佣');
//                        event(new DistributionEvent(['level' => $level + 1, 'money' => $totalMoney, 'user_id' => $user_id]));
//                    }
                }else{
                    Log::info('直推人数不够');
                }

            } else {

                \Log::info('没有上级无需返佣');

            }
        } else {
            \Log::info($level.'级返佣结束');
        }
    }


}
