<?php
namespace App\Http\Controllers\Home2;

use Illuminate\Http\Request;
use App\Http\Requests\Home\ElegantRequest;
use App\Http\Model\Elegant;
use App\Http\Controllers\Controller;
class ElegantController extends BaseController
{
    public function index()//加载贵人币注册第一个视图
    {
        return view('home.elegant.index');
    }

    public function index2()//加载贵人币注册第二个视图
    {
        return view('home.elegant.index2');
    }

    public function register(ElegantRequest $request)//贵人币注册操作
    {
        $data=$request->except(['cart_front','cart_bg','cart_hold','bank_img',]);
        $bank_code=$request->only('bank_code')['bank_code'];
        $sex=$request->only('sex')['sex'];
        $ID_code=$request->only('ID_code')['ID_code'];
        $ID_cart=$this->validateIDCard($ID_code);
        if(!$ID_cart){
            return $this->ajaxMessage(false,'身份证格式错误');
        }
        $code=$this->luhm($bank_code);
        if(!$code){//说明银行卡号格式输入有误
            return $this->ajaxMessage(false,'银行卡格式输入错误');
        }
        $arr=array('男','女');
        if(!in_array($sex,$arr)){
            return $this->ajaxMessage(false,'输入的性别不合法');
        }
        if($request->hasFile('cart_front')){//身份证正面
            $path = $this->uploadsFile($request, 'uploads/cart', 'cart_front');
            if ($path) {
                $data['identity_front'] = $path;
            } else {
                return $this->ajaxMessage(false,'上传身份证正面图片失败');
            }
        }else{
            return $this->ajaxMessage(false,'请上传身份证正面图片');
        }
        if($request->hasFile('cart_bg')){//身份证背面
            $path = $this->uploadsFile($request, 'uploads/cart', 'cart_bg');
            if ($path) {
                $data['identity_back'] = $path;
            } else {
                return $this->ajaxMessage(false,'上传身份证背面图片失败');
            }
        }else{
            return $this->ajaxMessage(false,'请上传身份证背面图片');
        }
        if($request->hasFile('cart_hold')){//手持身份证
            $path = $this->uploadsFile($request, 'uploads/cart', 'cart_hold');
            if ($path) {
                $data['identity_hold'] = $path;
            } else {
                return $this->ajaxMessage(false,'上传手持身份证图片失败');
            }
        }else{
            return $this->ajaxMessage(false,'请上传手持身份证图片');
        }
        if($request->hasFile('bank_img')){//银行卡正面照片
            $path = $this->uploadsFile($request, 'uploads/cart', 'bank_img');
            if ($path) {
                $data['bank_img'] = $path;
            } else {
                return $this->ajaxMessage(false,'上传银行卡正面图片失败');
            }
        }else{
            return $this->ajaxMessage(false,'请上传银行卡正面图片');
        }
        if(Elegant::create($data)){
            return $this->ajaxMessage(true,'贵人币注册成功');
        }
        return $this->ajaxMessage(false,'贵人币注册失败');
    }

    public function luhm($s)//银行卡号验证
    {
        $n = 0;
        for ($i = strlen($s); $i >= 1; $i--) {
            $index = $i - 1;
            //偶数位
            if ($i % 2 == 0) {
                $n += $s{$index};
            } else {//奇数位
                $t = $s{$index} * 2;
                if ($t > 9) {
                    $t = (int)($t / 10) + $t % 10;
                }
                $n += $t;
            }
        }
        return ($n % 10) == 0;
    }

    public function validateIDCard($IDCard)//校验身份证
    {
        if (strlen($IDCard) == 18) {
            return $this->check18IDCard($IDCard);
        } elseif ((strlen($IDCard) == 15)) {
            $IDCard = $this->convertIDCard15to18($IDCard);
            return $this->check18IDCard($IDCard);
        } else {
            return false;
        }
    }

//计算身份证的最后一位验证码,根据国家标准GB 11643-1999
    public function calcIDCardCode($IDCardBody) {
        if (strlen($IDCardBody) != 17) {
            return false;
        }

        //加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值
        $code = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;

        for ($i = 0; $i < strlen($IDCardBody); $i++) {
            $checksum += substr($IDCardBody, $i, 1) * $factor[$i];
        }

        return $code[$checksum % 11];
    }

// 将15位身份证升级到18位
    public function convertIDCard15to18($IDCard) {
        if (strlen($IDCard) != 15) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($IDCard, 12, 3), array('996', '997', '998', '999')) !== false) {
                $IDCard = substr($IDCard, 0, 6) . '18' . substr($IDCard, 6, 9);
            } else {
                $IDCard = substr($IDCard, 0, 6) . '19' . substr($IDCard, 6, 9);
            }
        }
        $IDCard = $IDCard . $this->calcIDCardCode($IDCard);
        return $IDCard;
    }

// 18位身份证校验码有效性检查
    public function check18IDCard($IDCard) {
        if (strlen($IDCard) != 18) {
            return false;
        }

        $IDCardBody = substr($IDCard, 0, 17); //身份证主体
        $IDCardCode = strtoupper(substr($IDCard, 17, 1)); //身份证最后一位的验证码

        if ($this->calcIDCardCode($IDCardBody) != $IDCardCode) {
            return false;
        } else {
            return true;
        }
    }
}
?>