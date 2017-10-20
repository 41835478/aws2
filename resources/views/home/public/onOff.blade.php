<!DOCTYPE html>
<html>
<head>
<title>爱无尚</title>
<meta charset="utf-8"/>
<meta name="author" content="jbs"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=GBK"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta name="format-detection" content="telephone=no"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="Cache-Control" content="no-cache"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta name="description" content="" />
<meta name="Keywords" content="" />
<link rel="stylesheet" href="{{asset('home/css/swiper.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('home/font/iconfont.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/common.css')}}"/>

<link rel="stylesheet" href="{{asset('home/css/main.css')}}">
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<style>
	body{
		background-color:#f5f5f5;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>爱无尚</h3>
	<!--$flag==2说明是转盘所以返回键,$flag==1说明是网站开关所以没有返回键-->
	@if($flag==2)
		<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
	@endif
</div>
<!-- 内容区 -->
<div class="content paySuccess_content">
	<img class="PS_img" src="{{asset('home/images/paySuccess.png')}}" alt="">
	<p class="PS_p1">{{$str}}</p>
</div>
</body>
</html>