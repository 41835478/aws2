<?php

namespace App\Http\Controllers\Home2;

use App\Http\Model\Incomerecode;
use App\Http\Model\Order2 as Order;
use App\Http\Model\User;
use App\Http\Services\RowCommonService;
use App\Http\Services\WxPayService;
use App\Services\InvestmentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;

class CallBackController extends Controller
{
    protected $WxPayService;
    protected $rowCommonService;
    protected $investmentService;
    public function __construct(WxPayService $wxPayService,RowCommonService $rowCommonService,InvestmentService $investmentService)
    {
        $this->investmentService = $investmentService;
        $this->WxPayService=$wxPayService;
        $this->rowCommonService=$rowCommonService;
    }

    public function paynotify()//微信支付回调
    {
        $xml = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        $xmlArr = $this->WxPayService->xmlToArray($xml);
        if( ($xmlArr['result_code'] == 'SUCCESS') || ($xmlArr['result_code'] == 'SUCCESS') ){
//             file_put_contents('./log.txt',file_get_contents('./log.txt')."\n".'支付成功');
            $result = $xmlArr;
            $result = $this->WxPayService->wxorderquery($xmlArr['transaction_id']);
            if($result != 'ERROR'){
                $order=Order::where(['order_code'=>strval($result['out_trade_no'])])->first();//修改订单
                if($order&&$order->status==1){
                    #处理逻辑
                    $order->status=2;
                    $order->type=1;
                    if($order->save()){
                        $res = $this->investmentService->investment($order->user_id,$order->id);
                        if($res){
                            \Log::info('微信回调分销成功');
                            echo 'success';
                        }else{
                            \Log::info('微信回调分销失败');
                            echo 'fail';
                        }
                    }
                }else{
                    echo 'success';
                }
            }
            echo 'fail';
        }else{
            // file_put_contents('./log.txt',file_get_contents('./log.txt')."\n".'支付失败');
            exit("fail");
        }
    }
}
