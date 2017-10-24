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
	.bonus>p{height:48px;line-height: 48px;}
	.bonus{background: url(/home/images/lovebg.png) no-repeat center center;background-size: 100% 100%;padding: 45px 3.125% 5px;}
	.bonus>h2{height:40px;line-height: 40px;}
	.lovernav{background-color:#fff;border-bottom:1px solid #d2d2d2;}
	.lovernav li{width:25%;text-align: center;height:48px;line-height: 48px;font-size: 16px;color:#666666;}
	.lovernav li span{font-size: 30px;line-height: 52px;}
	.lovernav li.lovernav-on{border-bottom:3px solid #158be3;color:#158be3;}
	.bonus_box ul{display:none;}
	.lover-layer{
		box-shadow: 0 0px 10px #e1e7f3;
	    -webkit-box-shadow: 0 0px 10px #e1e7f3;
	    -moz-box-shadow: 0 0px 10px #e1e7f3;
	    -ms-box-shadow: 0 0px 10px #e1e7f3;
	    -o-box-shadow: 0 0px 10px #e1e7f3;
	    border-radius: 3px;
	    padding: 5px 3.3%;
	    position: relative;
	    background-color:#fff;
	    padding:54px 0;
	    text-align:center;
	}
	.lover-layer>img{display:block;margin:0 auto;width:75px;height:75px;}
	.lover-layer>h2{margin-top:6px;height:48px;line-height: 48px;font-size: 16px;}
	.lover-layer>p{font-size: 18px;color:#ffb32a;height:20px;line-height: 20px;}
	@media screen and (min-width: 350px){
		.bonus_con>p {
		    line-height: 34px;
		    height: 34px;
		}
	}
	
</style>
</head>
<body>
<div class="public_head">
	<h3>爱心分销金</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-top:48px;padding-bottom:0">
	<div class="bonus">
		<h2>
			<span>&yen;</span><em>8000.00</em>
		</h2>
		<p>累计奖励金额</p>
	</div>
	<ul class="lovernav div_displayFlex">
		<li class="div_borderBox lovernav-on">一级</li>
		<li class="div_borderBox">二级</li>
		<li class="div_borderBox">三级</li>
		<li class="div_borderBox"><span class="iconfont icon-more"></span></li>
	</ul>
	<div class="bonus_box">
		<ul class="bonusList bonusList1" style="display:block">
			<li class="div_clearFloat bonusItem">
				<span>1</span>
				<img src="/home/images/rank01.png" alt=""/>
				<div class="bonus_con">
					<p>Asdes</p>
					<span>2017-08-10   12:46  </span>
				</div>
				<p>+￥1000.00</p>
			</li>
		</ul>
		<ul class="bonusList bonusList2">
			<li class="div_clearFloat bonusItem">
				<span>1</span>
				<img src="/home/images/rank01.png" alt=""/>
				<div class="bonus_con">
					<p>Asdes</p>
					<span>2017-08-10   12:46  </span>
				</div>
				<p>+￥1000.00</p>
			</li>
		</ul>
		<ul class="bonusList bonusList3">
			<li class="div_clearFloat bonusItem">
				<span>1</span>
				<img src="/home/images/act_icon08.png" alt=""/>
				<div class="bonus_con">
					<p>Asdes</p>
					<span>2017-08-10   12:46  </span>
				</div>
				<p>+￥1000.00</p>
			</li>
		</ul>
		<ul class="lover-layer">
			<img src="images/laugh.png" alt=""/>
			<h2>四-九级累计奖金总金额：</h2>
			<p>&yen;3000.00</p>
		</ul>
	</div>
</div>
<script src="https://cdn.bootcss.com/handlebars.js/4.0.10/handlebars.min.js"></script>
<script type="text/javascript">

	/*导航切换*/
	$('.lovernav li').on('click',function(){
		$('.lovernav li').removeClass('lovernav-on');
		$('.lovernav li').eq($(this).index()).addClass('lovernav-on');
		$('.bonus_box ul').css('display','none');
		$('.bonus_box ul').eq($(this).index()).show(300);
	});
</script>
</body>
</html>