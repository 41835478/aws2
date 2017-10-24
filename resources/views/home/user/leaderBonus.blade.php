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
		<ul class="bonusList bonusList1" style="display:block">
			<li class="div_clearFloat bonusItem">
				<span>1</span>
				<img src="images/rank01.png" alt=""/>
				<div class="bonus_con">
					<p>Asdes</p>
					<span>2017-08-10   12:46  </span>
				</div>
				<p>+&yen;10.00</p>
			</li>
		</ul>
	</div>
</div>
<script src="https://cdn.bootcss.com/handlebars.js/4.0.10/handlebars.min.js"></script>
<script id="bonus" type="text/x-handlebars-template">
{{#each this}}
	<li class="div_clearFloat bonusItem">
		<span>{{addOne @index}}</span>
		<img src={{img}} alt=""/>
		<div class="bonus_con">
			<p>{{name}}</p>
			<span>{{time}}</span>
		</div>
		<p>{{money}}</p>
	</li>
{{/each}}
</script>
<script type="text/javascript">
	var bonuslist = [
		{img:'images/rank03.png',name:'Asdes',time:'2017-08-10   12:46  ',money:'+￥1000.00'},
		{img:'images/rank03.png',name:'Asdes',time:'2017-08-10   12:46  ',money:'+￥1000.00'},
		{img:'images/rank03.png',name:'Asdes',time:'2017-08-10   12:46  ',money:'+￥1000.00'},
		{img:'images/rank03.png',name:'Asdes',time:'2017-08-10   12:46  ',money:'+￥1000.00'},
		{img:'images/rank03.png',name:'Asdes',time:'2017-08-10   12:46  ',money:'+￥1000.00'},
		{img:'images/rank03.png',name:'Asdes',time:'2017-08-10   12:46  ',money:'+￥1000.00'}
	];
	var handleHelper = Handlebars.registerHelper("addOne",function(index){
         return index+1;
    });
	var myTemplate = Handlebars.compile($("#bonus").html());
	$('.bonusList1').html(myTemplate(bonuslist));
	var _t = (window.location.href).split('=')[1];
	switch(_t){
		case '0':
			$('.con').text('一级领导奖');
			break;
		case '1':
			$('.con').text('二级领导奖');
			break;
		case '2':
			$('.con').text('三级领导奖');
			break;
		case '3':
			$('.con').text('四级领导奖');
			break;
		case '4':
			$('.con').text('五级领导奖');
			break;
		case '5':
			$('.con').text('六级领导奖');
			break;
		case '6':
			$('.con').text('七级领导奖');
			break;
		case '7':
			$('.con').text('八级领导奖');
			break;
		case '8':
			$('.con').text('九级领导奖');
			break;
		case '9':
			$('.con').text('十级领导奖');
			break;
		default:
			$('.con').text('一级领导奖');
			break;
	}			
</script>
</body>
</html>