<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 11:46
 */

namespace App\Http\Services;

use App\Events\RowAEvent;
use App\Events\RowBEvent;
use App\Events\RowCEvent;
use App\Http\Model\Config;
use App\Http\Model\Incomerecode;
use App\Http\Model\Order;
use App\Http\Model\Orderinfo;
use App\Http\Model\Rowa;
use App\Http\Model\Rowb;
use App\Http\Model\Rowc;
use App\Http\Model\Rowdata;
use App\Http\Model\Roworder;
use App\Http\Model\User;
use DB;
use Exception;
use Illuminate\Support\Facades\Redis;

class RowService
{
    protected $rowA;
    protected $rowB;
    protected $rowC;

    public function __construct(Rowa $rowA,Rowb $rowB,Rowc $rowC)
    {
        $this->rowA=$rowA;
        $this->rowB=$rowB;
        $this->rowC=$rowC;
    }

    public function index($order_id,$type)
    {
        $order = Order::find($order_id);
        if($order){
            $config=$this->configData();
            try{
                if ($type == 4) {//100元专区   说明是A盘
                    $this->mainRow($order_id, $order->user_id, 100, 1,$config->zpoint_a);
                }
                if ($type == 5) {//300元专区   说明是B盘
                    $this->mainRow($order_id, $order->user_id,300, 2,$config->zpoint_b);
                }
                if ($type == 6) {//2000元专区  说明是C盘
                    $this->mainRow($order_id, $order->user_id,2000, 3,$config->zpoint_c);
                }
            }catch(Exception $e){
                dd($e->getCode().'----'.$e->getLine().'----'.$e->getFile().'---'.$e->getMessage().'--我是rowService');
                return false;
            }
        }
    }

    public function RowInfo($row_id,$type)
    {
        if($type==1){
            $row=Rowa::find($row_id);
        }
        if($type==2){
            $row=Rowb::find($row_id);
        }
        if($type==3){
            $row=Rowc::find($row_id);
        }
        $date['prev_id']=$row->prev_id;
        $date['row_id']=$row_id;
        $date['current_level']=$row->current_level ;
        $date['user_id']=$row->user_id;
        return $date;
    }

    public function mainRow($order_id, $user_id, $money, $type,$pointFee)
    {
        if($type==1){
            $mod=$this->rowA;
        }
        if($type==2){
            $mod=$this->rowB;
        }
        if($type==3){
            $mod=$this->rowC;
        }
        try{
            $prevId = $mod->orderBy('id','desc')->skip(0)->take(1)->value('id');
            if ($prevId) {
                $prev = $mod->where(['id' => $prevId])->first(['level','prev_id']);//上级的层数
                if($prev->prev_id==0){
                    $backData = $this->getLevel($mod,$prev->level,$prevId,$prevId,$type);
                }else{
                    $backData = $this->getLevel($mod,$prev->level,$prev->prev_id,$prevId,$type);
                }
                $date['prev_id']=$backData['prev_id'];
                $selfLevel=$backData['level'];
            }else{
                $selfLevel=1;
            }
            $date['level'] = $selfLevel;
            $date['order_id'] = $order_id;
            $date['user_id'] = $user_id;
            $date['status'] = 1;
            $date['current_level'] = 1;
            $date['current_generate'] = 1;
            $date['create_at'] = time();
            $res1 = $mod->insertGetId($date);
            if ($res1) {
                $remark = $money . '元商品区';
                $res2 = $this->rowOrder($res1, $user_id, $remark, $money, $type);
                if ($res2) {
                    $res3 = $this->getTwentyScore($user_id,$user_id, $money, $pointFee);//向上20代返钱
                    if($res3){
                        DB::commit();
                        $this->loopUpDisk($res1,$type,$order_id);
                    }else{
                        throw new Exception();
                    }
                }else{
                    throw new Exception();
                }
            }else{
                throw new Exception();
            }
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getCode().'---'.$e->getLine().'---'.$e->getFile());
        }
    }

    public function loopUpDisk($row_id,$type,$order_id)//开始进盘
    {
        if($type==1){
            $date=$this->RowInfo($row_id,1);
            $date['type']=1;
            event(new RowAEvent($date,$order_id));
        }
        if($type==2){
            $date=$this->RowInfo($row_id,2);
            $date['type']=2;;
            event(new RowBEvent($date,$order_id));
        }
        if($type==3){
            $date=$this->RowInfo($row_id,3);
            $date['type']=3;
            event(new RowCEvent($date,$order_id));
        }
    }

    //$level 上级层数 $selfId 自己的id $type 当前盘类型
    public function getLevel($mod,$level,$prev_id,$selfId,$type)//获取层数
    {
        $date=array();
        if($type==1){//A盘
            $layer = bcpow(2, $level-1);
        }
        if($type==2){//B盘
            $layer = bcpow(3, $level-1);
        }
        if($type==3){//C盘
            $layer = bcpow(4, $level-1);
        }
        $count = $mod->where(['level' => $level])->count();//这里需要优化
        if ($count < $layer) {
            if($type==1){//A盘
                $aCount=$mod->where(['prev_id'=>$prev_id])->count();
                if($aCount==2){
                    $prev_id = $mod->where('id', '>', $prev_id)->min('id');
                }
            }
            if($type==2){//B盘
                $aCount=$mod->where(['prev_id'=>$prev_id])->count();
                if($aCount==3){
                    $prev_id = $mod->where('id', '>', $prev_id)->min('id');
                }
            }
            if($type==3){//C盘
                $aCount=$mod->where(['prev_id'=>$prev_id])->count();
                if($aCount==4){
                    $prev_id = $mod->where('id', '>', $prev_id)->min('id');
                }
            }
            $date['level']=$level;
            $date['prev_id']=$prev_id;
            return $date;
        }
        $date['level']=$level + 1;
        if($type==1){//A盘
            $date['prev_id']=$selfId-(bcpow(2, $level-1)-1);
        }
        if($type==2){//B盘
            $date['prev_id']=$selfId-(bcpow(3, $level-1)-1);
        }
        if($type==3){//C盘
            $date['prev_id']=$selfId-(bcpow(4, $level-1)-1);
        }
        return $date;
    }

    public function rowOrder($row_id, $user_id, $remark, $money, $type)//向排位订单中插入数据
    {
        $date['user_id'] = $user_id;
        $date['row_id'] = $row_id;
        $date['remark'] = $remark;
        $date['status'] = 1;
        $date['money'] = $money;
        $date['type'] = $type;
        $date['create_at'] = time();
        $res = Roworder::insert($date);
        if ($res) {
            return true;
        }
        return false;
    }

    /**
     * @param $from_id
     * @param $user_id
     * @param int $num
     * @param $money    购买专区的价格
     * @param $award    不同盘给上20代的见点奖
     * @return bool
     */
    public function getTwentyScore($from_id,$user_id, $money, $award, $num = 1)//得到上二十代用户
    {
        $pid = User::where(['id' => $user_id])->value('pid');
        if ($pid) {
            if($user_id!=$pid){
                if ($num <= 20) {
                    $res = $this->twentyBonus($from_id, $pid, $money, $award);
                    if ($res) {
                        $num++;
                        return $this->getTwentyScore($from_id,$pid, $money, $award, $num);
                    }
                }
            }
        }
        return true;
    }

    public function twentyBonus($user_id, $pid, $money, $award)//二十代奖金
    {
        DB::beginTransaction();
        try {
            $user=User::where(['id' => $pid])->first(['id','account','bonus']);
            $account=$user->account+$award;
            $bonus=$user->bonus+$award;
            $user->account=$account;
            $user->bonus=$bonus;
            $userRes=$user->save();
            if($userRes){
                $from_login_name = User::where(['id' => $user_id])->value('login_name');
                $to_login_name = User::where(['id' => $pid])->value('login_name');
                $info = $from_login_name . '购买了' . $money . '元专区的商品' . $to_login_name . '获得推荐奖' . $award . '元';
                $res2 = $this->incomeRecode($pid, $info, $award, 1, 4, $user_id);
                if ($res2) {
                    DB::commit();
                    return true;
                } else {
                    throw new Exception();
                }
            }else{
                throw new Exception();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function incomeRecode($to_user_id, $info, $money, $flag, $type, $from_user_id)//incomerecode表记录信息
    {
        $date['user_id'] = $to_user_id;
        $date['recode_info'] = $info;
        $date['flag'] = $flag;
        $date['money'] = $money;
        $date['status'] = 1;
        $date['type'] = $type;
        $date['from_id'] = $from_user_id;
        $date['create_at'] = time();
        $res = Incomerecode::insert($date);
        if ($res) {
            return true;
        }
        return false;
    }

    public function configData()
    {
        $config=Config::find(1);
        return $config;
    }
}