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
		body{
			background-color:#fff;
		}
	</style>
</head>
<body>
<div class="public_head" style="border:0">
	<h3>爱无尚商城</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
	<i class="iconfont icon-edit"></i>
</div>
<!-- 内容区 -->
<div class="content div_borderBox" style="padding-bottom:0;padding-top:48px">
	<div class="div_clearFloat">
		<ul class="mallNav">
			@foreach ($class as $k=>$v)
				@if ($k == 0)
					<li class="div_borderBox mallNavOn">{{ $v->name }}</li>
				@else
					<li class="div_borderBox">{{ $v->name }}</li>
				@endif
			@endforeach
		</ul>
		<div class="mallContent">
			@foreach ($class as $k=>$v)
			<div class="div_clearFloat mallContentlist" @if ($k == 0)style="display:block"@endif>
				@foreach ($v->children as $c)
					<a href="/shop/goodsList?type={{ $c->id }}" class="a_jump">
						<img src="{{ asset($c->pic) }}" alt="{{ $c->name }}"/>
						<p>{{ $c->name }}</p>
					</a>
				@endforeach
			</div>
			@endforeach
		</div>
	</div>
</div>
<script type="text/javascript">
    var _h = $(window).height();
    $('.mallNav').css('height',(_h-48));
	/*选项卡*/
    $('.mallNav>li').on('click',function(){
        $('.mallNav>li').removeClass('mallNavOn');
        $('.mallNav>li').eq($(this).index()).addClass('mallNavOn');
        $('.mallContent .mallContentlist').css('display','none');
        $('.mallContent .mallContentlist').eq($(this).index()).fadeIn(300);
    })
</script>
</body>
</html>