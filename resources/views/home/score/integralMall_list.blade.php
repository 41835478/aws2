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
		background: -webkit-linear-gradient(top, #62df9d , #ace9a5); 
		background: -o-linear-gradient(bottom, #62df9d, #ace9a5); 
		background: -moz-linear-gradient(bottom, #62df9d, #ace9a5); 
		background: linear-gradient(to bottom, #62df9d , #ace9a5);
		border:0;
	}
	.hotRecomend-con{padding-bottom:0;}
	.hotRecomend-num{margin-top:16px;}
</style>
</head>
<body>
<div class="public_head">
	<h3 id="inteTitle" style="color:#333">{{$class->name}}</h3>
	<a style="color:#333" href="/score/index" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-bottom:0">
	<div class="integralList">
		<ul class="intergralListbox">
			@if( empty($goods))
				暂无数据
			@else
				@foreach( $goods as $h)
					<li class="div_clearFloat intergralList">
						<a href="/score/info?s={{$h->id}}" class="div_left div_clearFloat a_jump">
							<img src="{{asset($h->pic)}}" alt=""/>
							<div class="hotRecomend-con">
								<p class="hotRecomend-txt">{{$h->name}}</p>
								<p class="hotRecomend-num">
									<em>{{$h->money}}</em><span>积分</span>
								</p>
							</div>
						</a>
						<button class="integralExchange" onClick="location.href='/score/info?s={{$h->id}}'" type="button">兑换</button>
					</li>
				@endforeach

			@endif
		</ul>
	</div>
</div>
<script type="text/javascript" src="/home/js/handlebars-1.0.0.beta.6.js"></script>

</body>
</html>