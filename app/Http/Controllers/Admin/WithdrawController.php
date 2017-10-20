<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Withdraw;
use App\Http\Model\Trueaccounts;
use App\Http\Model\User;
use App\Http\Model\Pointsrecode;
use App\Http\Model\Incomerecode;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use App\Http\Services\WxRedService;
use App\Http\Model\Balance;
use App\Events\ActiveLogEvent;

use Storage;
use DB;

use Cache;
use Exception;
class WithdrawController extends Controller
{

    protected $wxRedService;

    public function __construct(WxRedService $wxRedService)
    {
        $this->wxRedService=$wxRedService;
    }
 

    public function cashList(Request $request)//提现列表
    {
        $query=Withdraw::query();
        if($request->has('end'))
            $query->where('create_at','<=',strtotime($request->input('end')));
        if($request->has('start'))
            $query->where('create_at','>=',strtotime($request->input('start')));
        if($request->has('mobile'))
            $query->where('mobile',$request->input('mobile'));
        if($request->has('name'))
            $query->where('name','like','%'.$request->input('name').'%');
        $date=$query->orderby('id','desc')->paginate(config('admin.pages'));
        $res=$this->paging($date);
        return view('admin.withdraw.cashList',compact('date','res'));
    }

    #提现通过
    public function pass(Request $request,$id=0){
        if(!$id){
            $data=$request->input();
            $id=$data['id'];
        }
          //dd(11);
        $with=Withdraw::where('id',$id)->first();
        if($with->cash_way==1){//说明是支付宝提现
            if($with->status){
                return redirect(url('withdraw/cashList'))->with('error','该记录已经处理过');
            }
            if($with->cash_way==1){
                event(new ActiveLogEvent('执行了支付宝提现通过操作'));
                return redirect(url('aliCash/index',array('id'=>$id)));
            }
        }else{//微信提现
            if($with->status){
                return $this->ajaxMessage(false,'该记录已经处理过');
            }

            if($with['cash_way']==2){
                #微信红包TODO
                $user=User::where('id',$with['user_id'])->first();
                // dd($user['openid']);
                $userstring=strval($user['openid']);
                $arr['openid']=$userstring;
                $arr['hbname']="提现申请";
                $arr['body']="您的提现申请已经成功";
                $arr['fee']=$with['arrival_money'];

                $re = $this->wxRedService->sendhongbaoto($arr);

                $rest=Withdraw::where('id',$id)->update(['status'=>1]);
                $post=Withdraw::where('id',$id)->first();

                // #添加复投积分 20%
                // $dataf=[];
                // $dataf['user_id']=$users['id'];
                // $dataf['flag']=1;
                // $dataf['points_info']='提现获得';
                // $dataf['sign']=1;
                // $dataf['points']=$post['money'] * 0.20;
                // $dataf['create_at']=time();
                // Pointsrecode::insert($dataf);
                // User::where('id',$users['id'])->increment('repeat_points', $dataf['points']);

                // #添加到消费积分 10%
                // $datax=[];
                // $datax['user_id']=$users['id'];
                // $datax['flag']=2;
                // $datax['points_info']='提现获得';
                // $datax['sign']=1;
                // $datax['points']=$post['money'] * 0.10;
                // $datax['create_at']=time();
                // Pointsrecode::insert($datax);
                // $res=User::where('id',$users['id'])->increment('consume_points', $datax['points']);




                if($re){
                    event(new ActiveLogEvent('执行了微信提现通过操作'));
                    return $this->ajaxMessage(true,'发送成功',['flag'=>1]);
                }else{
                    return $this->ajaxMessage(false,'操作失败');
                }
            }
        }
    }

    public function aliCashPass($id)//支付宝提现通过
    {
        //dd($id);
        $with=Withdraw::where('id',$id)->first();
        if($with['status'] != 0){
            return redirect(url('withdraw/cashList'))->with('error','该记录已经处理过');
        }
        event(new ActiveLogEvent('执行了支付宝提现通过操作'));
       

                // #添加复投积分 20%
                // $dataf=[];
                // $dataf['user_id']=$users['id'];
                // $dataf['flag']=1;
                // $dataf['points_info']='提现获得';
                // $dataf['sign']=1;
                // $dataf['points']=$with['money'] * 0.20;
                // $dataf['create_at']=time();
                // Pointsrecode::insert($dataf);
                // User::where('id',$users['id'])->increment('repeat_points', $dataf['points']);

                // #添加到消费积分 10%
                // $datax=[];
                // $datax['user_id']=$users['id'];
                // $datax['flag']=2;
                // $datax['points_info']='提现获得';
                // $datax['sign']=1;
                // $datax['points']=$with['money'] * 0.10;
                // $datax['create_at']=time();
                // Pointsrecode::insert($datax);
                // $res=User::where('id',$users['id'])->increment('consume_points', $datax['points']);
        return redirect(url('aliCash/index',array('id'=>$id)));
    }

    #提现驳回
    public function fell(Request $request){
        $data=$request->input();
        
        $with=Withdraw::where('id',$data['id'])->first();
        if($with['status'] != 0){
            return $this->ajaxMessage(false,'该记录已经处理过');
        }
        #查询用户
        $users=User::where('id',$with['user_id'])->first();
 $num=0;
//开启事务 
DB::beginTransaction();
try{ 

        $rest=Withdraw::where('id',$data['id'])->update(['status'=>2]);
        $ress=User::where('id',$with['user_id'])->increment('account', $with['money']);


                #添加到Pointsrecode
                $dddd=[];
                $dddd['user_id']=$users['id'];
                $dddd['flag']=1;
                //$dddd['points_info']='提现';
                $dddd['money']=$with['money'];
                $dddd['status']=1;
                $dddd['type']=6;
                $dddd['create_at']=time();
                incomerecode::insert($dddd);

                #扣除复投积分 20%
                $dataf=[];
                $dataf['user_id']=$with['user_id'];
                $dataf['flag']=1;
                $dataf['points_info']='提现驳回';
                $dataf['sign']=2;
                $dataf['points']=$with['money'] * 0.20;
                $dataf['create_at']=time();
                Pointsrecode::insert($dataf);
                User::where('id',$users['id'])->decrement('repeat_points', $dataf['points']);

                #扣除到消费积分 10%
                $datax=[];
                $datax['user_id']=$with['user_id'];
                $datax['flag']=2;
                $datax['points_info']='提现驳回';
                $datax['sign']=2;
                $datax['points']=$with['money'] * 0.10;
                $datax['create_at']=time();
                Pointsrecode::insert($datax);
                $res=User::where('id',$users['id'])->decrement('consume_points', $datax['points']);

                $num=1;
    

//中间逻辑代码 
    DB::commit(); 
}catch (\Exception $e) { 
//接收异常处理并回滚 
    DB::rollBack(); 
}
        if($num==1){
            event(new ActiveLogEvent('执行了驳回提现操作'));
            return $this->ajaxMessage(true,'操作成功',['flag'=>1]);
        }else{
            return $this->ajaxMessage(false,'操作失败'); 
        }


    }


    public function accountslist(Request $request){
        $input = $request->only([ 'phone', 'pphone']);
        $query=Trueaccounts::query();
         if ($mem = User::where('phone', $input['pphone'])->first()) {
            $mem = $mem->toArray();
        }
         if ($users = User::where('phone', $input['phone'])->first()) {
            $users = $users->toArray();
        }
        //$where=[];
        if($request->has('phone')){
             $query = $query ->where( 'cid' , $users['id']);
           // $where['cid']=$users['id'];
        }
        if ($request->has('pphone')) {
             $query = $query ->where( 'jid' , $mem['id']);
            //$where['jid']=$mem['id'];
        }
        $user=User::get();
        $account=$query->orderby('id','desc')->paginate(10);
           foreach ($account as $k => $v) {
               foreach ($user as $key => $value) {
                   if($v['cid']==$value['id']){
                        $account[$k]['cname']=$value['name'];
                        $account[$k]['cphone']=$value['phone'];
                        $account[$k]['cpic']=$value['pic'];
                   }
               }
               foreach ($user as $key => $value) {
                   if($v['jid']==$value['id']){
                        $account[$k]['jname']=$value['name'];
                        $account[$k]['jphone']=$value['phone'];
                        $account[$k]['jpic']=$value['pic'];
                   }
               }
           }

        //dd($account);
        return view('admin.withdraw.accountslist',compact('account'));
    }

}
