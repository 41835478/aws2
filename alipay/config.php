<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016**********17",

		//RSA2商户私钥，（换成自己私钥）查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝私钥。
		'merchant_private_key' => "MIIEbJ+QCK74niEEtk651xjdiMdxvnpp+QO***************************************************************************EAo9kg==",
		
		//异步通知地址（123.123.com换成自己域名）
		'notify_url' => "http://123.123.com/alipay/notify_url.php",
		
		//同步跳转（123.123.com换成自己域名）
		'return_url' => "http://132.123.com/alipay/return_url.php",

		//编码格式（不要修改）
		'charset' => "UTF-8",

		//签名方式（不要修改）
		'sign_type'=>"RSA2",

		//支付宝网关（不要修改）
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//RSA2支付宝公钥,（换成自己公钥）查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiUMxvOhzEtiKvQEYyuYEsML28GgAHEPmkRUAqSx4rHQnDVgoLBg80KNPrFIkYDufdEjbQYIedZUCZcH78cM8EkOU27QmRLReJcRbtM/***************************************************************************TR37dYYmhCPoTgkGIQQPT34sMh6g9MfAH1EWOpFjdvuhtsqgihq7w/6h+KrAjE8mSlbjpauxcJ3Y0yLhuy5K9ewQIDAQAB",
		
	
);