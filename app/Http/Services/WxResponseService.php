<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 10:18
 */

namespace App\Http\Services;


class WxResponseService
{
    public function responseNews($postObj, $arr)//回复多图文消息
    {
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>" . count($arr) . "</ArticleCount>
                        <Articles>";
        foreach ($arr as $k => $v) {
            $template .= "<item>
                        <Title><![CDATA[" . $v['title'] . "]]></Title> 
                        <Description><![CDATA[" . $v['description'] . "]]></Description>
                        <PicUrl><![CDATA[" . $v['picUrl'] . "]]></PicUrl>
                        <Url><![CDATA[" . $v['url'] . "]]></Url>
                        </item>";
        }
        $template .= "</Articles>
                        </xml>";
        $info = sprintf($template, $toUser, $fromUser, time(), 'news');
        echo $info;
        //注意多图文发送时，子图文不能超过8个
    }

    public function responseSubscribe($postObj)//回复微信用户的关注事件
    {
        $arr = array(
            array(
                'title' => '爱无尚',
                'description' => '欢迎关注爱无尚商城',
                'picUrl' => config('home.WEB').'/uploads/attention/default.jpg',
                'url' => config('home.WEB'),
            ),
        );
        $this->responseNews($postObj, $arr);
    }

    public function responseText($postObj, $content)//回复单文本
    {
        $template = '<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        </xml>';
        $fromUser = $postObj->ToUserName;
        $toUser = $postObj->FromUserName;
        $time = time();
        $msgType = 'text';
        $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
        echo $info;
    }

    public function responseImage($postObj, $media_id)//回复图片
    {
        $template="<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Image>
					<MediaId><![CDATA[%s]]></MediaId>
					</Image>
				</xml>";
        $fromUser = $postObj->ToUserName;
        $toUser = $postObj->FromUserName;
        $time = time();
        $msgType = 'image';
        $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $media_id);
        echo $info;
    }
}