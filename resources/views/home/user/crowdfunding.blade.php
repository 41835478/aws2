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
<link rel="stylesheet" href="/home/css/swiper.min.css"/>
<link rel="stylesheet" type="text/css" href="/home/font/iconfont.css"/>
<link rel="stylesheet" href="/home/css/common.css"/>
<link rel="stylesheet" href="/home/css/index.css"/>
<script type="text/javascript" src="/home/js/tip.js"></script>
<script type="text/javascript" src="/home/js/swiper.min.js"></script>
<script type="text/javascript" src="/home/js/jquery-3.1.1.min.js"></script>
<style>
	body{background-color:#f5f5f5;}
	.public_head{
		background: -webkit-linear-gradient(left, #20a8ee , #2194eb); 
        background: -o-linear-gradient(right, #20a8ee, #2194eb); 
        background: -moz-linear-gradient(right, #20a8ee, #2194eb); 
        background: linear-gradient(to right, #20a8ee , #2194eb); 
        border:0;
	}
	.zhongbonus{background:url("/home/images/zhongbg.png") no-repeat center center;text-align:center;background-size: 100% 100%;color:#fff;}
	.zhongbonus .zhong-heart{height:60px;line-height: 60px;font-size: 16px;overflow:hidden;}
	.zhongbonus>h2{font-size: 40px;overflow:hidden;height:38px;line-height: 38px;}
	.zhong-m{padding:65px 0 20px;}
	.zhong-m .zhong-money{height:24px;line-height: 24px;font-size: 16px;}
	.zhong-m .zhong-txt{height:22px;line-height: 22px;font-size: 14px;}
</style>
</head>
<body>
<div class="public_head">
	<h3>众筹奖金</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="content" style="padding-top:48px;padding-bottom:0">
	<div class="zhongbonus">
		<p class="zhong-heart">我的爱心值</p>
		<h2>{{$love}}</h2>
		<div class="zhong-m">
			<p class="zhong-money">&yen;{{$count}}</p>
			<p class="zhong-txt">累积奖金</p>
		</div>
	</div>
	<div class="center_content">
		<ul class="centerList centerList1">
			<li class="centerItem">
				<a href="{{url('users/loverDetail')}}" class="a_jump">
					<img src="/home/images/heart01.png" alt=""/>
					<span>爱心值明细</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
		</ul>
		<ul class="centerList centerList2">
			<li class="centerItem">
				<a href="{{url('users/loverBonus')}}" class="a_jump">
					<img src="/home/images/heart02.png" alt=""/>
					<span>爱心奖金</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
			<li class="centerItem stock">
				<a href="{{url('users/stockBonus')}}" class="a_jump">
					<img src="/home/images/heart03.png" alt=""/>
					<span>股东分红</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
		</ul>
		<ul class="centerList centerList2">
			<li class="centerItem">
				<a href="{{url('users/loverDistribution')}}" class="a_jump">
					<img src="/home/images/heart04.png" alt=""/>
					<span>爱心分销奖</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
			<li class="centerItem">
				<a href="{{url('users/loverleader')}}" class="a_jump">
					<img src="/home/images/heart05.png" alt=""/>
					<span>爱心领导奖</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
		</ul>
	</div>
</div>
<script>
	$('.stock').on('click',function(){
		addBox('body');
		outBox('您还不是股东，无法查看股东分红。','stockBonus.html');
	});
</script>
</body>
</html>