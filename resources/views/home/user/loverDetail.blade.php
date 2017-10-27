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
<link rel="stylesheet" href="/home/css/main.css">
<script type="text/javascript" src="/home/js/fly.js"></script>
<script type="text/javascript" src="/home/js/swiper.min.js"></script>
<script type="text/javascript" src="/home/js/jquery-3.1.1.min.js"></script>
<style>
	body{background-color:#f5f5f5;}
	.act_list{background-color:#fff;}
</style>
</head>
<body>
<div class="public_head">
	<h3>爱心值明细</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="content" style="padding-top:48px">
	<ul style="padding-top:12px;">
		@foreach ($data as $k=>$v)
		<li class="act_list">
			<img src="/home/images/red05.png" alt="">
			<div class="act_class">
				<p class="top_p">{{$v->info}}</p>
				<p class="time">{{$v->created_at}}</p>
			</div>
			<div class="act_money">
				<span>
					@if ( $v->is_add == 1 )
					+{{$v->num}}
					@elseif ($v->is_add == 2 )
					-{{$v->num}}
					@endif

				</span>
			</div>
		</li>
		@endforeach
	</ul>
</div>
<script>
	
</script>
</body>
</html>