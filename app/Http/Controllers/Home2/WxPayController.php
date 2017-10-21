<?php

namespace App\Http\Controllers\Home2;

use App\Http\Model\Order2 as Order;
use App\Http\Model\User;
use App\Http\Services\AuthService;
use App\Http\Services\SendCodeService;
use App\Http\Services\WxPayService;
use Illuminate\Http\Request;

class WxPayController extends BaseController
{
    protected $WxPayService;

    public function __construct(WxPayService $wxPayService,AuthService $auth,SendCodeService $msg)
    {
        parent::__construct($auth,$msg);
        $this->WxPayService=$wxPayService;
    }

    public function getOpenId(Request $request,$id)//获取用户openid
    {   
        $code =$request->input('code');
        if (!$code) {
            $url = urlencode(config('home2.WEB').'/wxpay/getOpenId/'.$id);
            $sendUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . config('home2.APPID') . '&redirect_uri=' . $url . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
            return redirect($sendUrl);
        }
        $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . config('home2.APPID') . '&secret=' . config('home2.SECRET') . '&code=' . $code . '&grant_type=authorization_code';
        $access_token_contents = $this->https_request($tokenUrl);
        $access_token = json_decode($access_token_contents, true);
        $openid=$access_token['openid'];
//        exit('<script>window.location.href="/home/mobileWxPay/wxChatPay?id='.$id.'&openid='.$openid.'"</script>');
        exit('<script>window.location.href="http://www.tjzbdkj.com/wxpay/index?order_id='.$id.'&openid='.$openid.'"</script>');
    }

    public function https_request($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)){
            return 'ERROR'.curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }

    public function index(Request $request)
    {   
        $orderId=$request->input('order_id');
        $openid=$request->input('openid');

        $order=Order::find($orderId);
        if($order&&$order->status==1&&($order->total_money>0)){
//            $user_id=$this->checkUser();
//            $user=User::find($user_id);
//            if($user->openid){
//                $openid=$user->openid;
//            }
            if($openid) {
                $date['pay'] = $order->total_money*100;//$order->total_money*100;
                //$appid = C('APPID');
                $key = config('home2.KEY');
                //var_dump($key);
                $data = array();
                $data['appid'] = config('home2.APPID');
                $data['mch_id'] = config('home2.MCH_ID');
                $data['attach'] = '微信支付';
                $data['body'] = '爱无尚商品';
                $data['detail'] = '商品详情';
                $data['nonce_str'] = time() . rand(10000, 99999);
                $data['notify_url'] = config('home2.NOTIFY_URL');
                $data['openid'] = $openid;
                $data['out_trade_no'] = $order->order_code;
                $data['spbill_create_ip'] = $request->ip();//终端ip
                $data['total_fee'] = $date['pay'];
                $data['trade_type'] = 'JSAPI';
                $sign = $this->WxPayService->getSign($data, $key);//签名

                $xmlStr = '<xml>
                   <appid><![CDATA[' . $data['appid'] . ']]></appid>
                   <mch_id><![CDATA[' . $data['mch_id'] . ']]></mch_id>
                   <openid><![CDATA[' . $data['openid'] . ']]></openid>
                   <attach><![CDATA[' . $data['attach'] . ']]></attach>
                   <body><![CDATA[' . $data['body'] . ']]></body>
                   <detail><![CDATA[' . $data['detail'] . ']]></detail>
                   <nonce_str><![CDATA[' . $data['nonce_str'] . ']]></nonce_str>
                   <notify_url><![CDATA[' . $data['notify_url'] . ']]></notify_url>
                   <out_trade_no><![CDATA[' . $data['out_trade_no'] . ']]></out_trade_no>
                   <spbill_create_ip><![CDATA[' . $data['spbill_create_ip'] . ']]></spbill_create_ip>
                   <total_fee><![CDATA[' . $data['total_fee'] . ']]></total_fee>
                   <trade_type><![CDATA[' . $data['trade_type'] . ']]></trade_type>
                   <sign><![CDATA[' . $sign . ']]></sign>
                </xml>';
                $sendUrl = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
                $result = $this->WxPayService->postXmlCurl($xmlStr, $sendUrl);
                $resultArr = $this->WxPayService->xmlToArray($result);

                if (!array_key_exists("appid", $resultArr) || !array_key_exists("prepay_id", $resultArr) || $resultArr['prepay_id'] == "") {
                    echo '下单失败 ' . $resultArr['return_code'] . '：' . $resultArr['return_msg'];
                    die;
                }
                $parametersArr = array();
                $parametersArr['appId'] = config('home2.APPID');
                $parametersArr['timeStamp'] = strval(time());
                $parametersArr['nonceStr'] = $resultArr['nonce_str'];
                $parametersArr['package'] = 'prepay_id=' . $resultArr['prepay_id'];
                $parametersArr['signType'] = 'MD5';
                $sign = $this->WxPayService->getSign($parametersArr, $key);
                $parametersArr['paySign'] = $sign;
                $jsApiParameters = json_encode($parametersArr);
                return view('home2.wxPay.wxChatPay', ['jsApiParameters'=>$jsApiParameters]);
            }else{
                return redirect(url('wxpay/getOpenId',['id'=>$orderId]));
            }
        }else{
            return redirect(url('users/index'));
        }
    }


    public function text()
    {
        dd(11);
    }
}
