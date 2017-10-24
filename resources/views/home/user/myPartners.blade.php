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
<link rel="stylesheet" href="css/swiper.min.css"/>
<link rel="stylesheet" type="text/css" href="font/iconfont.css"/>
<link rel="stylesheet" href="css/common.css"/>
<link rel="stylesheet" href="css/index.css"/>
<script type="text/javascript" src="js/swiper.min.js"></script>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<style>
	body{background-color:#f5f5f5;}
	.public_head{
		
	}
</style>
</head>
<body>
<div class="public_head">
	<h3 class="con"></h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-top:48px;padding-bottom:0">
	<div class="bonus_box">
		<ul class="teamList">
			<li class="teamItem">
				<span>1</span>
				<img src="images/rank01.png" alt=""/>
				<div class="team_con">
					<p>Asdes</p>
					<span>18574198899</span>
				</div>
				<div class="team_identity">
					<p class="team_shenfen">
						<i class="iconfont icon-dengji"></i>
						<span>会员</span>
					</p>
					<p class="team_time">2017-08-10</p>
				</div>
			</li>
		</ul>
	</div>
</div>
<script src="https://cdn.bootcss.com/handlebars.js/4.0.10/handlebars.min.js"></script>
<script id="bonus" type="text/x-handlebars-template">
{{#each this}}
	<li class="teamItem">
		<span>{{addOne @index}}</span>
		<img src={{img}} alt=""/>
		<div class="team_con">
			<p>{{name}}</p>
			<span>{{phone}}</span>
		</div>
		<div class="team_identity">
			<p class="team_shenfen">
				<i class="iconfont icon-dengji"></i>
				<span>{{id}}</span>
			</p>
			<p class="team_time">{{time}}</p>
		</div>
	</li>
{{/each}}
</script>
<script type="text/javascript">
	var bonuslist = [
		{img:'images/rank01.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'会员'},
		{img:'images/rank02.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'股东'},
		{img:'images/rank03.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'会员'},
		{img:'images/rank04.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'股东'},
		{img:'images/rank05.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'会员'},
		{img:'images/rank06.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'股东'},
		{img:'images/rank07.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'会员'},
		{img:'images/rank03.png',name:'Asdes',phone:'18574198899',time:'2017-08-10',id:'会员'}
	];
	var handleHelper = Handlebars.registerHelper("addOne",function(index){
         return index+1;
    });
	var myTemplate = Handlebars.compile($("#bonus").html());
	$('.teamList').html(myTemplate(bonuslist));
	var _t = (window.location.href).split('=')[1];
	switch(_t){
		case '0':
			$('.con').text('一级小伙伴');
			break;
		case '1':
			$('.con').text('二级小伙伴');
			break;
		case '2':
			$('.con').text('三级小伙伴');
			break;
		default:
			$('.con').text('一级小伙伴');
			break;
	}
</script>
</body>
</html>