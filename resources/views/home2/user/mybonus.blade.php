
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



<link rel="stylesheet" href="{{asset('home/css/index.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/swiper.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('home/font/iconfont.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/common.css')}}"/>

<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<style>
	body{background-color:#f5f5f5;}
	.public_head{
		background: -webkit-linear-gradient(left, #1d93ec , #0188ed); 
        background: -o-linear-gradient(right, #1d93ec, #0188ed); 
        background: -moz-linear-gradient(right, #1d93ec, #0188ed); 
        background: linear-gradient(to right, #1d93ec , #0188ed); 
        border:0;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>我的奖金</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-top:48px;padding-bottom:0">
	<div class="bonus">
		<h2>
			<span>￥</span><em>{{$users['bonus']}}</em>
		</h2>
		<p>奖金总额</p>
	</div>
	<div class="bonusBox">
		<div class="div_displayFlex bonus_award">
			<a href="{{url('users/bonus_jiandian',['id'=>1])}}" class="a_jump">
				<img src="{{asset('home/images/bonus01.png')}}" alt=""/>
				<span>见点奖金</span>
			</a>
			<a href="{{url('users/bonus_jiandian',['id'=>2])}}" class="a_jump">
				<img src="{{asset('home/images/bonus02.png')}}" alt=""/>
				<span>分销奖金</span>
			</a>
			<a href="{{url('users/bonus_jiandian',['id'=>3])}}" class="a_jump">
				<img src="{{asset('home/images/bonus03.png')}}" alt=""/>
				<span>推荐奖金</span>
			</a>
			<a href="{{url('users/bonus_jiandian',['id'=>4])}}" class="a_jump">
				<img src="{{asset('home/images/bonus04.png')}}" alt=""/>
				<span>升级奖金</span>
			</a>
		</div>
	</div>
</div>
</body>
</html>