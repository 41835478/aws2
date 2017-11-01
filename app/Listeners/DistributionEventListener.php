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
     * @param  DistributionEvent $event
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
        $maxLevel = Config2::find(4)->value; //获取分销奖励层数

        if ($maxLevel >= $level) {

            $user = User::find($user_id);
            Log::info('用户', [$user->toArray()]);
            if ($level == 1) {

                $user = User::find($user_id);

            } else {
                $user = User::find($event->data['upUser_id']);
            }
            $upUser = $user->upUser;

            if (count($upUser) > 0) {//一级
                Log::info('上级用户', [$upUser->toArray()]);
                if ($level == 1 && $user->consumer_num == 1) { //第一级返佣，并且用户第一消费，给上级推荐人加1
                    $upUser->increment('recommend_count');
                }
                $config_id = $data[$level];//获取配置表id
                $value = Config2::find($config_id)->value;
                $percentage = $value / 100; //计算百分比
                \Log::info($level . '级百分比' . $percentage);
                $userIncome = $totalMoney * $percentage;//计算返佣钱
                $res = $this->threeRecordService->setRecord($user_id, $upUser->id, $level, $userIncome, $level . '代分销奖金');
                if ($res) {
                    $res1 = $this->accountRecordService->setAccountRecord($upUser->id, $userIncome, BalanceRecord2::TYPE_DISTRIBUTION_PRIZE, $level . '代分销奖金', 1);
                    if ($res1) {
                        \Log::info($level . '级返佣成功');
                        event(new DistributionEvent(['level' => $level + 1, 'money' => $totalMoney, 'user_id' => $user_id, 'upUser_id' => $upUser->id]));
//
                    } else {
                        \Log::info($level . '级账户记录失败');
                    }
                } else {
                    \Log::info($level . '级记录失败');
                }

            } else {

                \Log::info('没有上级无需返佣');

            }
        } else {
            \Log::info('返佣结束');
        }
    }


}
