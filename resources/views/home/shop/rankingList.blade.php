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
	.public_head{background-color:#fff;}
	.public_head h3{color:#333;}
	.public_head a{color:#333;} 	
</style>
</head>
<body>
<div class="public_head">
	<h3>排行榜单</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
	<i class="iconfont icon-edit"></i>
</div>
<!-- 内容区 -->
<div class="content" style="padding-bottom:12px">
	<ul class="div_displayFlex rankNav">
		<li class="div_borderBox rankNavOn">
			<span>业绩排行</span>
		</li>
		<li class="div_borderBox">
			<span>团队人数</span>
		</li>
	</ul>
	<div class="ranklist">
		<img class="rankImg" src="/home/images/culp2.png" alt=""/>
		<div class="rankBox">
			<ul class="rankingList" style="display:block">
				@foreach ($yj as $k=>$v)
				<li class="div_borderBox rankBox-item">
					<span>{{ $k+1 }}</span>
					<img src="{{ $v->pic?asset($v->pic):'/home/images/rank01.png' }}" alt=""/>
					<p>{{ $v->phone }}</p>
					<h3>￥{{ $v->all_money }}</h3>
				</li>
				@endforeach
			</ul>
			<ul class="rankingNum">	
				@foreach ($rs as $k=>$v)
				<li class="div_borderBox rankBox-item">
					<span>{{ $k+1 }}</span>
					<img src="{{ $v->pic?asset($v->pic):'/home/images/rank01.png' }}" alt=""/>
					<p>{{ $v->phone }}</p>
					<h3>{{ $v->all_user }}人</h3>
				</li>
				@endforeach

			</ul>
		</div>
	</div>
</div>
<script src="https://cdn.bootcss.com/handlebars.js/4.0.10/handlebars.min.js"></script>
<script type="text/javascript">
	/*选项卡*/
	$('.rankNav>li').on('click',function(){
		$('.rankNav>li').removeClass('rankNavOn');
		$('.rankNav>li').eq($(this).index()).addClass('rankNavOn');
		$('.rankBox>ul').css('display','none');
		$('.rankBox>ul').eq($(this).index()).fadeIn(300);
	});
</script>
</body>
</html>