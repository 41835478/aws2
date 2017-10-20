<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Payment;
use App\Http\Model\Withdraw;
use App\Http\Services\AlipayFundTransToaccountTransferRequestService;
use App\Http\Services\AopClientService;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;

class AliCashController extends Controller
{
    protected $aopClient;
    protected $aliPayFundTransToaccountTransferQuest;

    public function __construct(AopClientService $aopClientService,AlipayFundTransToaccountTransferRequestService $alipayFundTransToaccountTransferRequestService)
    {
        $this->aopClient=$aopClientService;
        $this->aliPayFundTransToaccountTransferQuest=$alipayFundTransToaccountTransferRequestService;
    }

    public function index($id)//支付宝提现
    {
        $withDraw=Withdraw::find($id);
        $payment=Payment::where(['user_id'=>$withDraw->user_id,'type'=>2])->first(['bankname','number','phone']);
        if($payment->number){
            $osn             = $withDraw->out_biz_no;//$withDraw->out_biz_no
            $payee_account   = $payment->number;//$payment->number
            $payee_real_name = $payment->bankname;//$payment->bankname
            $amount          = $withDraw->arrival_money;//$withDraw->arrival_money
//            dd($osn.'--'.$payee_account.'--'.$payee_real_name.'--'.$amount);
            if($amount<=0){
                return redirect(url('withdraw/cashList'))->withErrors('转账金额小于0元了');
            }
            $msg=$this->AlipayFundTransToaccountTransfer($osn,$payee_account,$amount,$payee_real_name);
            if($msg['success']=='1'){
                $find=Withdraw::where(['out_biz_no'=>$msg['out_biz_no']])->first();
                $find->status=1;
                $res=$find->save();
                if($res){
                    return redirect(url('withdraw/cashList'))->with('success','转账成功');
                }else{
                    return redirect(url('withdraw/cashList'))->withErrors('转账成功，但修改数据失败');
                }
            }else{
                return redirect(url('withdraw/cashList'))->withErrors($msg['text']);
            }
        }else{
            return redirect(url('withdraw/cashList'))->withErrors('该用户没有绑定支付宝');
        }
    }

    /*
     *该方法为支付宝转账方法
     *osn 交易单号
     *payee_account 收款人帐号
     *amount 转账金额
     *payee_real_name 收款方真实姓名
     */


    public function AlipayFundTransToaccountTransfer($osn,$payee_account,$amount,$payee_real_name){
        $msg = array();
        if(!$osn){
            $msg['success'] = 2;
            $msg['text']    = '交易单号为空';
            return $msg;
        }elseif(!$payee_account){
            $msg['success'] = 2;
            $msg['text']    = '收款人帐号为空';
            return $msg;
        }elseif(!$amount || $amount<0.1){
            $msg['success'] = 2;
            $msg['text']    = '转账金额不能小于0.1';
            return $msg;
        }elseif(!$payee_real_name){
            $msg['success'] = 2;
            $msg['text']    = '收款人姓名为空';
            return $msg;
        }else{
            $aop =$this->aopClient;
            $aop->gatewayUrl         = 'https://openapi.alipay.com/gateway.do';
            $aop->appId              = config('home.Ali_APPID');
            $aop->rsaPrivateKey      = config('home.RSAPRIVATEKRY');
            $aop->alipayrsaPublicKey = config('home.ALIPAYRSAPUBLICKEY');
            $aop->apiVersion         = '1.0';
            $aop->signType           = 'RSA';
            $aop->postCharset        = 'UTF-8';
            $aop->format             = 'json';
            $request = $this->aliPayFundTransToaccountTransferQuest;
            $request->setBizContent("{" .
                "    \"out_biz_no\":\"".$osn."\"," .
                "    \"payee_type\":\"ALIPAY_LOGONID\"," .
                "    \"payee_account\":\"".$payee_account."\"," .
                "    \"amount\":\"".$amount."\"," .
                "    \"payer_show_name\":\"天津市彩白云天商贸有限公司\"," .
                "    \"payee_real_name\":\"".$payee_real_name."\"," .
                "    \"remark\":\"转账备注\"," .
                "    \"ext_param\":\"{\\\"order_title\\\":\\\"用户提现\\\"}\"" .
                "  }");
            $result = $aop->execute ( $request);
            $resultCode = $result->alipay_fund_trans_toaccount_transfer_response->code;
            $out_biz_no=$result->alipay_fund_trans_toaccount_transfer_response->out_biz_no;
            if(!empty($resultCode)&&$resultCode == 10000){
                $msg['success'] = 1;
                $msg['text']    = '支付宝转账成功';
                $msg['out_biz_no']=$out_biz_no;
                return $msg;
            }else{
                $resultMsg  = $result->alipay_fund_trans_toaccount_transfer_response->sub_msg;
                $msg['success'] = 2;
                $msg['text']    = $resultMsg;
                return $msg;
            }
        }
    }

    public function order_num(){
        $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderCode = $code[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderCode;
    }
}
