<?php

namespace App\Http\Controllers\Home2;

use App\Http\Model\Incomerecode;
use App\Http\Model\User;
use App\Http\Model\Wheel;
use App\Http\Model\Wheellist;
use App\Http\Services\AuthService;
use App\Http\Services\SendCodeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;

class WheelController extends BaseController
{
    protected $wheel;

    public function __construct(AuthService $auth,SendCodeService $msg,Wheel $wheel)
    {
        parent::__construct($auth,$msg);
        $this->wheel = $wheel;
    }
//$timer代表是否可抽奖  $lucky==1是有一次机会==0没机会
    public function index()//加载转盘视图
    {
        $lucky=0;
        $mod = $this->wheel->first();
        if($mod->on_off==1){//转盘开关打开了
            $check=$this->checkUserLogin();
            if($check){
                $user_id=$this->checkUser();
                $user=User::find($user_id);
                if(!$user->lucky){
                    $lucky=1;
                    $timer=0;
                }else{
                    $lucky=0;
                    $timer=1;
                }
            }else{
                $timer=1;
            }
            $key=1;
            return view('home.wheel.index', compact('mod','timer','key','lucky'));
        }else{
            $str='幸运转盘暂时关闭，请下次再来吧。';
            return view('home.public.onOff',['str'=>$str,'flag'=>2]);
        }
    }

    public function luckyStart()//开始抽奖
    {
        $check=$this->checkUserLogin();
        if($check){
            $user_id=$this->checkUser();
            $user=User::find($user_id);
            if($user->lucky<1){
                $mod = $this->wheel->first();
                $prize_arr = array(
                    '0' => array('id' => 1, 'min' => 1, 'max' => 60, 'prize' => $mod->prize_1, 'v' => $mod->angel_1),
                    '1' => array('id' => 2, 'min' => 61, 'max' => 120, 'prize' => $mod->prize_2, 'v' => $mod->angel_2),
                    '2' => array('id' => 3, 'min' => 121, 'max' => 180, 'prize' => $mod->prize_3, 'v' => $mod->angel_3),
                    '3' => array('id' => 4, 'min' => 181, 'max' => 240, 'prize' => $mod->prize_4, 'v' => $mod->angel_4),
                    '4' => array('id' => 5, 'min' => 241, 'max' => 300, 'prize' => $mod->prize_5, 'v' => $mod->angel_5),
                    '5' => array('id' => 6, 'min' => 301, 'max' => 360, 'prize' => $mod->prize_6, 'v' => $mod->angel_6),
                    // '6'=>array('id'=>7,'min'=>array(32,92,152,212,272,332),'max'=>array(58,118,178,238,298,358,),'prize'=>'七等奖','v'=>50),
                );
                $res=$this->backResult($prize_arr);
                if($res['angle']>=1&&$res['angle']<=60){
                    $key=0;
                }
                if($res['angle']>=61&&$res['angle']<=120){
                    $key=1;
                }
                if($res['angle']>=121&&$res['angle']<=180){
                    $key=2;
                }
                if($res['angle']>=181&&$res['angle']<=240){
                    $key=3;
                }
                if($res['angle']>=241&&$res['angle']<=300){
                    $key=4;
                }
                if($res['angle']>=301&&$res['angle']<=360){
                    $key=5;
                }
                $result=$this->writeUser($user_id,$res);
                if($result){
                    return $this->ajaxMessage(true,'抽奖成功',['key'=>$key]);
                }
                return $this->ajaxMessage(false,'抽奖失败');
            }
            return $this->ajaxMessage(false,'已经没有抽奖机会了，请下次再来');
        }else{
            return $this->ajaxMessage(false,'未登录');
        }
    }

    public function writeUser($user_id,$res)//写入数据
    {
        DB::beginTransaction();
        try{
            $user=User::where(['id'=>$user_id])->increment('lucky',1);
            if($user){
                $temp=preg_replace("/[\\x80-\\xff]/","",$res['prize']);//保留非汉字（过滤汉字），注意两条反斜线
                if($temp){
                    $res1=User::where(['id'=>$user_id])->increment('account',$temp);
                    if($res1){
                        $res2=User::where(['id'=>$user_id])->increment('bonus',$temp);
                        if($res2){
                            $date['user_id']=$user_id;
                            $date['recode_info']='转盘抽奖中了'.$temp.'元';
                            $date['flag']=1;
                            $date['money']=$temp;
                            $date['status']=1;
                            $date['type']=2;
                            $date['create_at']=time();
                            $res3=Incomerecode::insert($date);
                            if($res3){
                                $date['user_id']=$user_id;
                                $date['prize']=$res['prize'];
                                $date['create_at']=time();
                                $res4=$wheel=Wheellist::insert($date);
                                if($res4){
                                    DB::commit();
                                    return true;
                                }else{
                                    throw new Exception();
                                }
                            }else{
                                throw new Exception();
                            }
                        }else{
                            throw new Exception();
                        }
                    }else{
                        throw new Exception();
                    }
                }else{
                    $date['user_id']=$user_id;
                    $date['prize']=$res['prize'];
                    $date['create_at']=time();
                    $wheel=Wheellist::insert($date);
                    if($wheel){
                        DB::commit();
                        return true;
                    }else{
                        throw new Exception();
                    }
                }
            }else{
                throw new Exception();
            }
        }catch(Exception $e){
            DB::rollBack();
            return false;
        }

    }

    public function checkUserLogin()//用于判断用于是否登录
    {
        if(session()->has('home_user_id')){
            return true;
        }
        return false;
    }


    //中奖概率额算法

    public function getRand($proArr)
    {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset($proArr);
        return $result;
    }

//函数getRand()会根据数组中设置的几率计算出符合条件的id，我们可以接着调用getRand().
    public function backResult($prize_arr)
    {
        foreach ($prize_arr as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        $rid = $this->getRand($arr);//根据概率获取奖项id
        $res = $prize_arr[$rid - 1];//中奖项
        $min = $res['min'];
        $max = $res['max'];
        if ($res['id'] == 7) {//七等奖
            $i = mt_rand(0, 5);
            $result['angle'] = mt_rand($min[$i], $max[$i]);
        } else {
            $result['angle'] = mt_rand($min, $max);
        }
        $result['prize'] = $res['prize'];
        return $result;
//代码中，我们调用getRand(),获取通过概率运算后得到的奖项，
//然后根据奖项中的配置的角度范围，在你最小角度和最大角度生成一个角度值，并构建数组，包含角度angle和奖项prize,最终以json格式输出。
    }
}
