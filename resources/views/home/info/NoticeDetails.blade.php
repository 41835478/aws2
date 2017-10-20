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
		background-color:#fff;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>公告详情</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content pjt_content">
	<div class="fenge"></div>
	<div class="project_body NoticeDetails_body">
		<h1 class="ND_tit">{{$return->title}}</h1>
		<p class="time">{{date('Y-m-d',$return->update_at)}}</p>
		{!! $return->content !!}
		{{--<p>爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新。</p>
		<p>爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新爱无尚平台更新更新。</p>
		<p>无尚平台更新更新爱无尚平台更新。</p>--}}
	</div>
</div>
</body>
</html>