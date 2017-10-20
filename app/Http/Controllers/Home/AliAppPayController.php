<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\PublicController as Controller;
use App\Http\Model\Incomerecode;
use App\Http\Model\Order;
use App\Http\Model\User;
use App\Http\Services\RowCommonService;
use Illuminate\Http\Request;
use DB;
use Exception;

class AliAppPayController extends Controller
{
    public $postCharset = "UTF-8";
    private $fileCharset = "UTF-8";
    private $app_id='2016060101467059';

    public $alipayrsaPublicKey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB";
    public $rsaPrivateKeyFilePath = '';
    public $rsaPrivateKey = "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDXf3YFbL7bHrcuVBQtNcRQlo+PGYMQGAVAnd6KH2ngXHsU+wBO5IBTW7tVd5dyVvY8dHnASmikGSZUpMsN2Uk/ftgqQVPQnK6bRCBHW4jb1DmUOXqEbpF52PItR1TeWpTF1ivwP1imh7LgrdreVfz1/0GUhgoXhyA55n3uBw0H4za28gc/iYlU1DE9phAWoeln5FFqFkEjoMUuey7ylVLGKJSJnDfkhK8cHNLoZeKDhMaaly1vidskKjeYdjJQvhjNDlJstOyJp83p8xX3yCTF00odbke044enfJDGhTvtYFydgoVHpIScm+ZN97Pb1HiZijdWuY/JehVFVmZ/zAwFAgMBAAECggEAf4ToVOt1wPpbEWolil8/rSR7DQXevZ5JNWR19KwEHgT7vH2PQCANI8argzbCgqGdEkcmaLhfVYOgYAQoOCi1JIKt7cs8iry8who9M5yhztu1utWMf2NiaIUNQefs+6sEUFGdLIx/rAOuwS9/zYN6riL/LqFmxWdrlXekWz8G4fvnKrS4+uO7VxhZMR++7xeWJPwcsLpNkxCDs3ibx88e4F8XJ4hOsvv3Mk2dz3Tev7APwZb42OPq581ja4maNxrR9GNzjztVR36wuy0r5+bE0pp3fHq8wl93q/ILIaAEz8M5aCW+We+3xOXtGDfrOA+CdbqkOTtWGifdKGVOOnUPnQKBgQDw4CFYAi4TtcQDqR/6Bws59uzEnHNlTMxRpRcdc0tLaWA2TeeT4fu031MLsIkVD8utFLqgYzW+mkQgOYtR/V6jZTC8tcvaZfikH9mvpbq1NYECN54Ga48sObIeN6EaDDqc4yKKjYw5/Tgzuyue2W8QXa5N4lpHqwyxK2ItC8aC7wKBgQDlB2g5G5FZkvjO2aozZ3dwvwYuK4E+W/YyszhwhmEl7C/OEp+dSblsGxqJQlc2muHnu4mVpoAdwVBNeyaKDpGTBhfLVoBEbaF4jjUasL+Yu5jGL2AejpS2L4Ya5ZVUzxfQED+hYCdKkoToeJV3uuF+Frasz3pUw3GPlpMOw9dQSwKBgH5x+a78ffmkyj/tsTaMKg2EnOfdBQqhVQRq+IZiNp1gtLvtC2rrDzn0neCeDGf9AbtbDVkSm2zyCF8uNf+VVO/LN9loSZndO7fUbG6zPh7P9mgWkCLopaDerK0GINDOqJog9cnr4jeywKUPVSevFolt1AlYkHHcze3XS1NAQjYLAoGAZCyWOIxHSe+P5iGsYSl7Q5Q55s3ejOD6UXi0Uftk2Ipy6maY69oIQTGlrK2YqeiasJoFdrBJzznznsAjvjTbFXyPwb+HAOcWvj0tGwx98Rb0npKwLw1cHEezF2adp2ehWb8RpcsBxItLmMbNUX4rDNRweCuTrSmDLTPGBKpCLfsCgYALUyjP6RecOXdxu2ATrk0nOo/JMkEEg6G8wZ5lbPY01VLWDVehktJkcR7IqY6D/n6Dv8kyuWBd+1zz3Y7xtSBdtQlDeN+N5JupMnTNu2uyF2JgyqZiA5YvbEMElokmj6sw3DqKkv5YXE0wWLy7sVLf535LrGmn3fP69WI2qlUVwg==";

    protected $rowCommonService;

    public function __construct(RowCommonService $rowCommonService)
    {
        $this->rowCommonService=$rowCommonService;
    }

    public function aliPay(Request $request,$id=0){
        if($id){
            $order_id=$id;
        }else{
            $order_id=$request->only('id')['id'];
        }
        $find=Order::find($order_id);
        if($find&&$find->status==1){
            $payData['alipay_sdk'] = 'alipay-sdk-php-20161101';
            $payData['app_id'] = $this->app_id;
            $payData['format'] = 'json';
            $payData['biz_content'] ='{"timeout_express":"30m","seller_id":"1505170818@qq.com","product_code":"QUICK_MSECURITY_PAY","total_amount":"'.$find->total_money.'","subject":"爱无尚","body":"爱无尚商城支付","out_trade_no":"'.$find->order_code.'"}';
            $payData['charset'] = 'UTF-8';
            $payData['method'] = 'alipay.trade.app.pay';
            $payData['notify_url'] =config('home.ALI_NOTIFY_URL');
            $payData['sign_type'] ='RSA';
            $payData['timestamp']=date('Y-m-d H:i:s');
            $payData['version']='1.0';
            $d = $this->argSort($payData);
            $payData['sign'] = $this->rsaSign($d);
            $data = $this->createLinkstring($payData);
            return $this->ajaxMessage(true,'返回数据成功', $data);
        }else{
            return $this->ajaxMessage(false,'非法订单');
//            return redirect(url('users/index'));
        }
    }

    public function notify_url(){             //回调
        $out_trade_no = $_POST['out_trade_no'];//商户订单号
//        $trade_no = $_POST['trade_no'];//支付宝交易号
//        $total_fee=$_POST['total_amount'];
        $trade_statue = $_POST['trade_status'];//交易状态
        if ($trade_statue == 'TRADE_FINISHED' || $trade_statue == 'TRADE_SUCCESS') {
            $order=Order::where(['order_code'=>$out_trade_no])->first();
            if($order&&$order->status==1) {
                DB::beginTransaction();
                try {
                    $order->status = 2;
                    $order->type = 2;
                    if ($order->save()) {
                        $data['user_id'] = $order->user_id;
                        $data['recode_info'] = '购买商品';
                        $data['flag'] = 2;
                        $data['money'] = $order->total_money;
                        $data['status'] = 1;
                        $data['type'] = 2;
                        $data['create_at'] = time();
                        $incomeRecode = Incomerecode::insert($data);
                        if ($incomeRecode) {
                            $user = User::find($order->user_id);
                            if (!$user->level) {
                                $user->level = 1;
                                if ($user->save()) {
                                    DB::commit();
                                    $this->rowCommonService->index($order->id);
                                    return redirect(url('users/index'));
                                } else {
                                    throw new Exception();
                                }
                            } else {
                                DB::commit();
                                $this->rowCommonService->index($order->id);
                                return redirect(url('users/index'));
                            }
                        } else {
                            throw new Exception();
                        }
                    } else {
                        throw new Exception();
                    }
                } catch (Exception $e) {
                    DB::rollBack();
                    echo 'fail';
                }
            }else{
                echo 'success';
            }
        }else{
            echo 'fail';
        }
    }
//验证签名
    public function rsaCheckV2($params, $rsaPublicKeyFilePath, $signType='RSA') {
        $sign = $params['sign'];
        // $params['sign'] = null;
        return $this->verify($this->getSignContent($params), $sign, $rsaPublicKeyFilePath, $signType);
    }

    function verify($data, $sign, $rsaPublicKeyFilePath, $signType = 'RSA') {
        if($this->checkEmpty($this->alipayPublicKey)){
            $pubKey= $this->alipayrsaPublicKey;
            $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }else {
            //读取公钥文件
            $pubKey = file_get_contents($rsaPublicKeyFilePath);
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
        }
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值
        if ("RSA2" == $signType) {
            $result = openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        } else {
            $result = openssl_verify($data, base64_decode($sign), $res);
        }
        if(!$this->checkEmpty($this->alipayPublicKey)) {
            //释放资源
            openssl_free_key($res);
        }
        return $result;
    }

    public function createLinkstring($para)             //返回参数拼接
    {
        $arg = "";
        while (list ($key, $val) = each($para)) {
            $arg .= $key . "=" . urlencode($val) . "&";
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);
        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }
        return $arg;
    }

    /**
     * 数组排序 按照ASCII字典升序
     * @param $para mixed 排序前数组
     * @return mixed 排序后数组
     */
    public static function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }

    public function rsaSign($params, $signType = "RSA") {  //获得签名
        return $this->sign($this->getSignContent($params), $signType);
    }

    protected function getSignContent($params) {        //签名内容拼接
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, $this->postCharset);
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }

    protected function sign($data, $signType = "RSA") {      //签名
        if($this->checkEmpty($this->rsaPrivateKeyFilePath)){
            $priKey=$this->rsaPrivateKey;
            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
                wordwrap($priKey, 64, "\n", true) .
                "\n-----END RSA PRIVATE KEY-----";
        }else {
            $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
            $res = openssl_get_privatekey($priKey);
        }
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = $this->fileCharset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //      $data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }
}

?>