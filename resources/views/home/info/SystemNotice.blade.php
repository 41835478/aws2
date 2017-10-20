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
	<script type="text/javascript" src="/home/js/swiper.min.js"></script>
	<script type="text/javascript" src="/home/js/jquery-3.1.1.min.js"></script>
	<style>
		body{
			background-color:#f5f5f5;
		}
	</style>
</head>
<body>
<div class="public_head">
	<h3>系统公告</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content SystemNotice_content">
	@if ($return == null)
		暂无公告
	@else
		<ul class="Beginguide_ul SystemNotice_ul">
			@foreach ($return as $v)

				<li class="SN_li BG_li">
					<a href="/info/sysInfo?id={{$v->id}}">
						<span>{{$v->title}}</span>
						<i class="iconfont icon-you"></i>
					</a>
					<div class="SN_div">
				
						<p class="time">{{date('Y-m-d',$v->update_at)}}</p>
					</div>
				</li>
				@endforeach
		</ul>
		 	<p class="font">已经到底了... ...</p>
	@endif
</div>
<script>
	//$(".SystemNotice_ul li:first").find('a').find('span').css('color','#ffb32a')
</script>

{{--<script>
	for(var i=0; i<3; i++){
		var _li =   '<li class="SN_li BG_li">'
				+		'<a href="NoticeDetails.html">'
				+			'<span>爱无尚系统更新</span>'
				+			'<i class="iconfont icon-you"></i>'
				+		'</a>'
				+		'<div class="SN_div">'
				+			'<p class="p1">爱无尚系统更新更新更新，查看更新更新更新更新更新爱无尚系统更新更新更新，查看更新+更新更新更新更新</p>'
				+			'<p class="time">2017-06-21</p>'
				+		'</div>'
				+	'</li>';
		$(".SystemNotice_ul").append(_li);
	}

	$(".SystemNotice_ul li:first").find('a').find('span').css('color','#ffb32a')
</script>    --}}

</body>
</html>
