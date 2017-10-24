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
		background: -webkit-linear-gradient(left, #1d93ec , #0188ed); 
        background: -o-linear-gradient(right, #1d93ec, #0188ed); 
        background: -moz-linear-gradient(right, #1d93ec, #0188ed); 
        background: linear-gradient(to right, #1d93ec , #0188ed); 
        border:0;
	}
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
	<h3>我的团队</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-top:48px;padding-bottom:0">
	<div class="bonus">
		<h2>
			<em>{{$count}}</em>
		</h2>
		<p>团队人数</p>
	</div>
	<div class="teamNumber">
		<ul>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang01.png" alt="图标"/>
				<span>一级小伙伴</span>
				<i class="iconfont icon-you"></i>
				<p class="div_right">{{$one}}人</p>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang02.png" alt="图标"/>
				<span>二级小伙伴</span>
				<i class="iconfont icon-you"></i>
				<p class="div_right">{{$two}}人</p>
			</li>
			<li class="teamnum-list myPartner">
				<img src="/home/images/huang03.png" alt="图标"/>
				<span>三级小伙伴</span>
				<i class="iconfont icon-you"></i>
				<p class="div_right">{{$three}}人</p>
			</li>
			<li class="teamnum-list">
				<img src="/home/images/huang04.png" alt="图标"/>
				<span>更多小伙伴</span>
				<p class="div_right">{{$other}}人</p>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
	$('.myPartner').on('click',function(){
		var _t = $(this).index();
		_t = _t +1;
		window.location.href = "{{url('users/teamList')}}?type="+_t;
	});
</script>
</body>
</html>