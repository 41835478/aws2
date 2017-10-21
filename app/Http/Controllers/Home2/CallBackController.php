<?php

namespace App\Http\Controllers\Home2;

use App\Http\Model\Incomerecode;
use App\Http\Model\Order2 as Order;
use App\Http\Model\User;
use App\Http\Services\RowCommonService;
use App\Http\Services\WxPayService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;

class CallBackController extends Controller
{
    protected $WxPayService;
    protected $rowCommonService;

    public function __construct(WxPayService $wxPayService,RowCommonService $rowCommonService)
    {
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
