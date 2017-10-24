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
<script type="text/javascript" src="/home/js/swiper.min.js"></script>
<script type="text/javascript" src="/home/js/jquery-3.1.1.min.js"></script>
<style>
	body{background-color:#f5f5f5;}
	.public_head{
		background: -webkit-linear-gradient(left, #1fb6f0 , #2194eb); 
        background: -o-linear-gradient(right, #1fb6f0, #2194eb); 
        background: -moz-linear-gradient(right, #1fb6f0, #2194eb); 
        background: linear-gradient(to right, #1fb6f0 , #2194eb); 
        border:0;
	}
	.bonus{background: url(/home/images/lovebg.png) no-repeat center center;background-size: 100% 100%;padding: 45px 3.125% 5px;}
	.teamNumber{padding:12px 0;}
	.teamnum-list{height:54px;line-height: 54px;padding:0 4.6875%;background-color:#fff;border-bottom:1px solid #f5f5f5;overflow:hidden;}
	.teamnum-list img{display:block;float:left;width:25px;height:20px;margin-top:16px;}
	.teamnum-list span{display:block;float:left;padding-left:15px;font-size:16px;}
	.teamnum-list .icon-you{display:block;float:right;line-height: 56px;color:#999;}
	.teamnum-list .div_right{font-size: 14px;color:#999;padding-right:10px;}
</style>
</head>
<body>
<div class="public_head">
	<h3>爱心领导奖</h3>
	<!-- <span>规则</span> -->
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-top:48px;padding-bottom:0">
	<div class="bonus">
		<h2>
			<span>&yen;</span><em>{{$countMoney}}</em><span style="color:#114e7c">（已封顶）</span>
		</h2>
		<p>今日收益</p>
	</div>
	<div class="teamNumber">
		<ul>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang01.png" alt="图标"/>
				<span>一级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang02.png" alt="图标"/>
				<span>二级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang03.png" alt="图标"/>
				<span>三级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang04.png" alt="图标"/>
				<span>四级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang05.png" alt="图标"/>
				<span>五级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang06.png" alt="图标"/>
				<span>六级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang07.png" alt="图标"/>
				<span>七级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang08.png" alt="图标"/>
				<span>八级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang09.png" alt="图标"/>
				<span>九级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang10.png" alt="图标"/>
				<span>十级领导奖</span>
				<i class="iconfont icon-you"></i>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
	$('.myPartner').on('click',function(){
		var _t = $(this).index();
		_t = _t+1;
		window.location.href = "{{url('users/loverleader2')}}?type="+_t;
	});
</script>
</body>
</html>