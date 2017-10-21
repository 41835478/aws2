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
<link rel="stylesheet" href="{{asset('home/css/fly.css')}}">
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<style>
	body{
		background: #f5f5f5;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>我的积分</h3>
	<a href="{{url('users/index')}}" onclick="self.location=document.referrer;" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content">
	<img class="integral_imgo" src="{{asset('home/images/fly_6.png')}}" alt="">
	<div class="integral_cont">
		<div class="integral_imgbox">
			<img src="{{asset('home/images/fly_13.png')}}" alt="">
		</div>
		<div class="integral_pbox">
			<p class="integral_po">复投积分</p>
			<p class="integral_pt">可以转账,购买公排点位或激活直推会员</p>
		</div>
		<input onclick="javascript:window.location.href='/users/recastIntegral'" type="button" value="进入"/>
	</div>
	<div class="integral_cont">
		<div class="integral_imgbox integral_imgboxt">
			<img src="{{asset('home/images/fly_11.png')}}"  class="integral_imgf" alt="">
		</div>
		<div class="integral_pbox">
			<p class="integral_po">消费积分</p>
			<p class="integral_pt">可在积分商城购买产品</p>
		</div>
		<input onclick="javascript:window.location.href='/users/consumption'" type="button" value="进入"/>
	</div>
	<div class="integral_cont">
		<div class="integral_imgbox integral_imgboxf">
			<img src="{{asset('home/images/fly_12.png')}}" class="integral_imgt" alt="">
		</div>
		<div class="integral_pbox">
			<p class="integral_po">循环积分</p>
			<p class="integral_pt">每2400积分购买一次A盘、B盘、C盘点位</p>
		</div>
		<input onclick="javascript:window.location.href='/users/looppoints'" type="button" value="进入"/>
	</div>
</div>
</body>
</html>