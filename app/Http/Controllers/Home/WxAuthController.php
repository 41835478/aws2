<?php

namespace App\Http\Controllers\Home;

use App\Http\Services\WxResponseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxAuthController extends Controller
{
    protected $wx;

    public function __construct(WxResponseService $wx)
    {
        $this->wx=$wx;
    }

    public function weiXinChat()//微信验证
    {
        //获取到微信推送过来post（xml格式）
        $postArr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        //处理消息类型，并设置回复类型和内容
//        $postObj = simplexml_load_string($postArr);
        $postObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);
        //判断该数据是否是订阅的事件推送
        if (strtolower($postObj->MsgType) == 'event') {//关注微信账号
            if (strtolower($postObj->Event) == 'subscribe') {
                $this->wx->responseSubscribe($postObj);//实例化回复微信关注
            }
        }
    }
}
