<?php

namespace App\Listeners;

use App\Events\RowAEvent;
use App\Events\RowEvent;
use App\Http\Model\Pointsrecode;
use App\Http\Model\Promoteinfo;
use App\Http\Model\Wheellist;
use App\Http\Services\CreateOrderService;
use App\Http\Services\RowService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Http\Model\Incomerecode;
use App\Http\Model\Looppoint;
use App\Http\Model\Promoterecode;
use App\Http\Model\Rowa;
use App\Http\Model\Roworder;
use App\Http\Model\User;
use DB;
use Exception;
use Illuminate\Support\Facades\Redis;

class RowAEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $createOrder;
    protected $row;

    public function __construct(CreateOrderService $createOrder,RowService $row)
    {
        $this->createOrder = $createOrder;
        $this->row=$row;
    }

    /**
     * Handle the event.
     *
     * @param  RowAEvent $event
     * @return void
     */
    public function handle(RowAEvent $event) //$row_id:上级盘位id  $now_row_id:当前盘位id  $flag:当前是那个盘  $user_id:当前用户id  $current_level:当前点位的等级
    {
        $date = $event->date;
        $order_id = $event->order_id;
        $res = $this->setPromoteRecode($date['row_id'], $date['type'], $date['user_id'], $date['current_level']);
        if ($res) {
            if ($date['prev_id']) {
                $result=$this->getSelfPrevInfo($date['row_id'], $date['prev_id'], $order_id);
//                if($result){
//                    if(Redis::exists('rowa')){
//                        $this->row->index(Redis::lpop('rowa'),4);
//                    }
//                }
            }
        }
    }

    public function getRowId($rowId, $aim_level, $num = 1)//得到对应要向上面第几代缴费的排位点id
    {
        if ($num <= $aim_level) {
            $prev_id = Rowa::where(['id' => $rowId])->value('prev_id');
            if ($prev_id) {
                $num++;
                return $this->getRowId($prev_id, $aim_level, $num);
            }
            return false;
        }
        return $rowId;
    }

    public function getSelfPrevInfo($now_row_id, $aim_row_id, $order_id)
    {
        $from_row = Rowa::where(['id' => $now_row_id])->first(['id', 'user_id', 'current_level']);
        $to_row = Rowa::where(['id' => $aim_row_id])->first(['id', 'user_id', 'current_level', 'current_generate','order_id']);
        return $this->updateDynasty($from_row, $to_row, $order_id);
    }

    public function updateDynasty($from_row, $to_row, $order_id)//升级循环判断
    {
        $feeConfig = $this->feeConfig($to_row->current_generate, $to_row->current_level+1);
        $where = array('row_id' => $to_row->id, 'current_level' => $to_row->current_level,
            'aim_level'=>$to_row->current_level+1, 'user_id' => $to_row->user_id, 'flag' => 1, 'status' => 1);
        if ($to_row->current_generate <= 3) {
            $main = $this->commonDynasty($to_row, $from_row, $feeConfig, $where);
            if ($main) {
                $promoteInfo = '见点收到红包' . $feeConfig['deductFee'];
                $res1 = $this->promoteInfo($from_row->id, $to_row->id, $to_row->current_level, 1, $feeConfig['deductFee'], $to_row->user_id, $promoteInfo, 1);
                if ($res1) {
                    $res2 = Promoterecode::where($where)->first(['id','promote_fee', 'aim_level']);
                    if ($res2->promote_fee >= $feeConfig['promoteFee']) {
                        $up_row_id = $this->getRowId($to_row->id, $res2->aim_level, $num = 1);
                        if ($up_row_id) {
                            $promoteInfo2 = '向上级交升级费' . $feeConfig['promoteFee'];
                            $res4 = $this->promoteInfo($to_row->id, $up_row_id, $to_row->current_level, 1, $feeConfig['promoteFee'], $to_row->user_id, $promoteInfo2, 2);
                            if ($res4) {
                                $main1 = $this->mainFunc2($up_row_id, $to_row->user_id, $feeConfig['promoteFee'], $res2->aim_level);
                                if ($main1) {
                                    $res3 = $this->startPromote($to_row->id, $to_row->current_level+1, $to_row->current_generate + 1, $where);
                                    if ($res3) {
                                        return $this->getSelfPrevInfo($to_row->id, $up_row_id, $order_id);
                                    }
                                }
                            }
                            return false;
                        } else {
                            $promoteInfo2 = '向上级交升级费' . $feeConfig['promoteFee'];
                            $res4 = $this->promoteInfo($to_row->id, $up_row_id, $to_row->current_level, 1, $feeConfig['promoteFee'], $to_row->user_id, $promoteInfo2, 2);
                            if ($res4) {
                                return $this->startPromote($to_row->id, $to_row->current_level+1, $to_row->current_generate + 1, $where);
                            }
                            return false;
                        }
                    }
                    return true;
                }
            }
            return false;
        }
        if ($to_row->current_generate == 4) {
            $main = $this->commonDynasty($to_row, $from_row, $feeConfig, $where);
            if ($main) {
                $promoteInfo = '见点收到红包' . $feeConfig['deductFee'];
                $res1 = $this->promoteInfo($from_row->id, $to_row->id, $to_row->current_level, 1, $feeConfig['deductFee'], $to_row->user_id, $promoteInfo, 1);
                if ($res1) {
                    $res2 = Promoterecode::where($where)->first(['id','promote_fee', 'aim_level']);
                    if ($res2->promote_fee >= $feeConfig['promoteFee']) {
                        $promote_fee = $res2->promote_fee - $feeConfig['promoteFee'];
                        if(($to_row->current_level + 1)<12){
                            $this->setPromoteRecode($to_row->id, 1, $to_row->user_id, $to_row->current_level + 1, $promote_fee);
                        }
                        try{
                            $pdb = Promoterecode::where($where)->first();//这里曾经是where('status',1)
                            $pdb->promote_fee=$feeConfig['promoteFee'];
                            $res4 = $pdb->save();
                            if (!$res4) {
                                return false;
                            }
                        }catch(Exception $e){
                            dd($e->getMessage());
                        }

                        $up_row_id=$this->getRowId($to_row->id,$to_row->current_level + 1,$num=1);
                        if ($to_row->current_level >= 11) {///可能改
                            $current_generate = $to_row->current_generate + 1;
                        } else {
                            $current_generate = $to_row->current_generate;
                        }
                        if($up_row_id){
                            $promoteInfo2='向上级交升级费'.$feeConfig['promoteFee'];
                            $res4=$this->promoteInfo($to_row->id,$up_row_id,$to_row->current_level,1,$feeConfig['promoteFee'],$to_row->user_id,$promoteInfo2,2);
                            if($res4){
                                $main1=$this->mainFunc2($up_row_id,$to_row->user_id,$feeConfig['promoteFee'],$to_row->current_level + 1);
                                if($main1){
                                    $res3=$this->startPromote($to_row->id,$to_row->current_level+1,$current_generate,$where);
                                    if($res3){
                                        return $this->getSelfPrevInfo($to_row->id,$up_row_id,$order_id);
                                    }
                                }
                            }
                            return false;
                        }else{
                            $promoteInfo2 = '向上级交升级费' . $feeConfig['promoteFee'];
                            $res4 = $this->promoteInfo($to_row->id, $up_row_id, $to_row->current_level, 1, $feeConfig['promoteFee'], $to_row->user_id, $promoteInfo2, 2);
                            if ($res4) {
                                return $this->startPromote($to_row->id, $to_row->current_level+1, $current_generate, $where);///可能改
                            }
                            return false;
                        }
                    }
                    return true;
                }
            }
            return false;
        }
        if ($to_row->current_generate >= 5 && $to_row->current_level == 12) {
            $where1 = array('row_id' => $to_row->id, 'current_generate' => $to_row->current_generate, 'type' => 1, 'user_id' => $to_row->user_id);
            $point = Looppoint::where($where1)->first();
            if (!$point) {
                $res = $this->writeLoopPoint($to_row->id, $to_row->user_id, $to_row->current_generate, $feeConfig['deductFee']);
            } else {
                $point->money=$point->money+$feeConfig['deductFee'];
                $point->point_money=$point->point_money+$feeConfig['deductFee'];
                $res=$point->save();
            }
            if ($res) {
                $res2 = $this->mainFunc($to_row->user_id, $from_row->user_id, $from_row->current_level, $feeConfig['redFee']);
                if ($res2) {
                    $money=Looppoint::where($where1)->value('money');
                    if ($money == 2400) {
                        $result1 = $this->writePointsRecode($to_row->user_id, 3, 1, '获取循环积分2400', 2400);
                        if (!$result1) {
                            return false;
                        }
                        $res3 = Looppoint::where($where1)->decrement('money', $money);
                        if (!$res3) {
                            return false;
                        }
                        $point_money = Looppoint::where($where1)->value('point_money');
                        if ($to_row->current_generate == 12) {
                            if ($point_money == $feeConfig['pointFee']) {//说明该出局了
                                return $this->outDisc($to_row->id, $to_row->user_id);
                            }
                        } else {
                            if ($point_money == $feeConfig['pointFee']) {//说明该生代了
                                $res4 = Rowa::where(['id' => $to_row->id])->increment('current_generate', 1);
                                if (!$res4) {
                                    return false;
                                }
                            }
                        }
                        $result2 = $this->writePointsRecode($to_row->user_id, 3, 2, '消耗循环积分2400购买了三个盘的点位', 2400);
                        if (!$result2) {
                            return false;
                        }
                        $this->loopPoint($to_row->order_id);//公排大循环
                    }
                    return true;
                }
            }
            return false;
        }
    }

    public function writePointsRecode($user_id, $flag, $sign, $info, $point)//循环积分记录详情
    {
        $date['user_id'] = $user_id;
        $date['flag'] = $flag;
        $date['sign'] = $sign;
        $date['points_info'] = $info;
        $date['points'] = $point;
        $date['create_at'] = time();
        return Pointsrecode::insert($date);
    }

    public function outDisc($row_id, $user_id)//12代要出局了
    {
        $date['status'] = 2;
        $date['update_at'] = time();
        $rowOrder = Roworder::where(['row_id' => $row_id, 'user_id' => $user_id, 'type' => 1])->update($date);
        if ($rowOrder) {
            $data['status'] = 2;
            $data['update_at'] = time();
            $row = Rowa::where(['row_id' => $row_id, 'user_id' => $user_id])->update($data);
            if ($row) {
                return true;
            }
        }
        return false;
    }

    public function loopPoint($order_id)//开始三个盘进行循环
    {
        $order_id1 = $this->createOrder->createOrder($order_id, 4);
        event(new RowEvent($order_id1, 1));

        $order_id2 = $this->createOrder->createOrder($order_id, 5);
        event(new RowEvent($order_id2, 2));

        $order_id3 = $this->createOrder->createOrder($order_id, 6);
        event(new RowEvent($order_id3, 3));
    }

    public function writeLoopPoint($row_id, $user_id, $current_generate, $money)//在A盘5-8代内向表中写入数据
    {
        $date['user_id'] = $user_id;
        $date['row_id'] = $row_id;
        $date['current_generate'] = $current_generate;
        $date['money'] = $money;
        $date['point_money'] = $money;
        $date['type'] = 1;
        $date['create_at'] = time();
        return Looppoint::insert($date);
    }

    public function commonDynasty($to_row, $from_row, $feeConfig, $where)//公共的升级函数
    {
        $find = Promoterecode::where($where)->first();
        if (!$find) {
            $rowA = Rowa::find($to_row->id);
            $res = $this->setPromoteRecode($to_row->id, 1, $rowA->user_id, $rowA->current_level);
            if (!$res) {
                return false;
            }
            $promote_fee = Promoterecode::where(['id' => $res])->value('promote_fee');
            $id = $res;
        } else {
            $id = $find->id;
            $promote_fee = $find->promote_fee;
        }
        $mod = Promoterecode::find($id);
        $mod->promote_fee = $promote_fee + $feeConfig['deductFee'];
        $res1 = $mod->save();
        if ($res1) {
            if ($feeConfig['redFee']) {
                return $this->mainFunc($to_row->user_id, $from_row->user_id, $from_row->current_level, $feeConfig['redFee']);
            }
            return true;
        }
        return false;
    }

    public function startPromote($rowId, $aim_level, $generate, $where)//升级改变升级表和排单表
    {
        DB::beginTransaction();
        try {
            $rowA = Rowa::find($rowId);
            $rowA->current_level = $aim_level;
            $rowA->current_generate = $generate;
            $res = $rowA->save();
            if ($res) {
                $db=Promoterecode::where($where)->first();
                $db->status = 2;
                $promote = $db->save();
                if ($promote) {
                    DB::commit();
                    return true;
                } else {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function setPromoteRecode($now_row_id, $flag, $user_id, $current_level, $arr ='')//向点位升级表中插入当前点位的升级信息
    {
        if($arr){
            $date['promote_fee']=$arr;
        }
        $date['row_id'] = $now_row_id;
        $date['current_level'] = $current_level;
        $date['aim_level'] = $current_level + 1;
        $date['flag'] = $flag;
        $date['status'] = 1;
        $date['user_id'] = $user_id;
        $date['create_at'] = time();
        $res = Promoterecode::insertGetId($date);
        if ($res) {
            return $res;
        }
        return false;
    }

    public function mainFunc($user_id, $from_id, $current_level, $redPacket)//向上级返红包
    {
        $to_login_name = User::where(['id' => $user_id])->value('login_name');
        $from_login_name = User::where(['id' => $from_id])->value('login_name');
        DB::beginTransaction();
        try {
//            $info = $from_login_name . '向上' . $current_level . '级' . $to_login_name . '返红包' . $redPacket;
            $info = $to_login_name . '收下' . $current_level . '级' . $from_login_name . '红包' . $redPacket;
            $res2 = $this->writeIncomeRecode($user_id, $info, 1, $redPacket, $from_id, 3);
            if ($res2) {
                if ($redPacket) {
                    $res = $this->writeUser($user_id, $redPacket);
                    if (!$res) {
                        throw new Exception();
                    }
                }
                DB::commit();
                return true;
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function mainFunc2($to_row_id, $from_id, $money, $current_level)//向上级交升级费
    {
        $rowA = Rowa::find($to_row_id);
        $to_login_name = User::where(['id' => $rowA->user_id])->value('login_name');
        $from_login_name = User::where(['id' => $from_id])->value('login_name');
        $info = $from_login_name . '向上' . $current_level . '级' . $to_login_name . '交升级费' . $money;
        DB::beginTransaction();
        try {
            $res1 = $this->writeIncomeRecode($rowA->user_id, $info, 1, $money, $from_id, 5);
            if ($res1) {
                DB::commit();
                return true;
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function writeUser($user_id, $redNum)//$redNum存入余额的红包的钱
    {
        $user=User::find($user_id);
        $account=$user->account+$redNum;
        $bonus=$user->bonus+$redNum;
        $user->account=$account;
        $user->bonus=$bonus;
        $res=$user->save();
        if($res){
            return true;
        }
        return false;
    }

    public function writeIncomeRecode($user_id, $recode_info, $flag, $money, $from_id, $type)//写入账户收支记录表
    {
        $date['user_id'] = $user_id;
        $date['recode_info'] = $recode_info;
        $date['flag'] = $flag;
        $date['money'] = $money;
        $date['status'] = 1;
        $date['from_id'] = $from_id;
        $date['type'] = $type;
        $date['create_at'] = time();
        return Incomerecode::insert($date);
    }

    public function promoteInfo($row_id, $to_row_id, $current_level, $flag, $promote_fee, $user_id, $info, $mark)//升级信息记录表
    {
        $date['row_id'] = $row_id;
        $date['to_row_id'] = $to_row_id;
        $date['current_level'] = $current_level;
        $date['flag'] = $flag;
        $date['promote_fee'] = $promote_fee;
        $date['user_id'] = $user_id;
        $date['info'] = $info;
        $date['mark'] = $mark;
        $date['create_at'] = time();
        $res = Promoteinfo::insert($date);
        if ($res) {
            return true;
        }
        return false;
    }

    /**
     * @param $dynasty
     * @return array
     */

    public function feeConfig($dynasty, $level)//$dynasty 第几代 通过当前代数得到要向上级交的升级费，上级的到的见点奖，上级的每个点的见点扣的费用
    {
//        if($to_row->current_generate<=4){
//            $feeConfig = $this->feeConfig($to_row->current_generate, $to_row->current_level+1);
//        }else{
//            $feeConfig = $this->feeConfig($to_row->current_generate, $to_row->current_level);
//        }
        $date = array();
        if($dynasty<=4){
            if ($level == 2) {
                $date['promoteFee'] = 100;
                $date['deductFee'] = 50;
                $date['redFee'] = 0;
            }
            if ($level == 3) {
                $date['promoteFee'] = 300;
                $date['deductFee'] = 75;
                $date['redFee'] = 25;
            }
            if($level==4){
                $date['promoteFee'] = 2000;
                $date['deductFee'] = 250;
                $date['redFee'] = 50;
            }
            if(in_array($level, [5, 6, 7,8])){
                $date['promoteFee'] = 3000;
                $date['deductFee'] = 1750;
                $date['redFee'] = 250;
            }
            if (in_array($level, [9, 10, 11, 12])) {
                $date['promoteFee'] = 4000;
                $date['deductFee'] = 1750;
                $date['redFee'] = 250;
            }
        }else{
            //        if ($dynasty == 4) {
//            if (in_array($level, [4, 5, 6, 7])) {
//                $date['promoteFee'] = 3000;
//            }
//            if (in_array($level, [8, 9, 10, 11])) {
//                $date['promoteFee'] = 4000;
//            }
//            $date['deductFee'] = 1750;
//            $date['redFee'] = 250;
//        }
            if ($dynasty == 5) {
                $date['deductFee'] = 600;
                $date['redFee'] = 2400;
                $date['pointFee'] = 19200;
            }
            if ($dynasty == 6) {
                $date['deductFee'] = 600;
                $date['redFee'] = 2400;
                $date['pointFee'] = 38400;
            }
            if ($dynasty == 7) {
                $date['deductFee'] = 600;
                $date['redFee'] = 2400;
                $date['pointFee'] = 76800;
            }
            if ($dynasty == 8) {
                $date['deductFee'] = 600;
                $date['redFee'] = 2400;
                $date['pointFee'] = 153600;
            }
            if ($dynasty == 9) {
                $date['deductFee'] = 2400;
                $date['redFee'] = 1600;
                $date['pointFee'] = 1228800;
            }
            if ($dynasty == 10) {
                $date['deductFee'] = 2400;
                $date['redFee'] = 1600;
                $date['pointFee'] = 2457600;
            }
            if ($dynasty == 11) {
                $date['deductFee'] = 2400;
                $date['redFee'] = 1600;
                $date['pointFee'] = 4915200;
            }
            if ($dynasty == 12) {
                $date['deductFee'] = 2400;
                $date['redFee'] = 1600;
                $date['pointFee'] = 9830400;
            }
        }
        return $date;
    }
}
