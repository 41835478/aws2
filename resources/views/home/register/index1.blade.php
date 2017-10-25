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
	/* body{
		background-color:#f5f5f5;
	} */
	.register_box .login_bottom{margin: 40px auto 10px;}
	.login_zh{text-align: center;margin-bottom: 40px;}
	.login_nav .nav_li {border:0;width:100%;}
	.register_box .login_bottom { margin: 72px auto 10px;}
</style>
</head>
<body>
<div class="login_top">
	<img class="logo" src="/home/images/login_logo.png" alt="">
	<ul class="login_nav">
		<li class="nav_li nav_li1">
			<span>登录</span>
			<img class="jiao" src="/home/images/login_jiao.png" alt="">
		</li>
	</ul>
</div>
<div class="btm_box register_box">
	<div class="login_bottom">
		<div class="list_div">
			<img class="iconfont icon-zhanghao" src="/home/images/login_icon01.png" alt="">
			<input class="input" id="phone" type="text" placeholder="请输入手机号">
		</div>
		<div class="list_div">
			<img class="iconfont icon-mima" src="/home/images/login_icon03.png" alt="">
			<input class="yz_input input" type="text" placeholder="输入验证码" id="code">

			<input id="fetchCode" class="register_yzBtn" type="button" value="获取验证码">
		</div>
		<input type="hidden" name="pid" id="pid" value="{{$pid}}">

		<button class="register_btn" type="button">登录</button>
	</div>
</div>
<script>
	var wait=60;
	function time(o) {
		o = $(o);
	    if (wait == 0) {
	            o.css("pointer-events","auto");
	            o.val("获取验证码");
	            wait = 60;
	        } else {
	            o.css("pointer-events", "none");
	            o.val("重新发送(" + wait + ")");
	            wait--;
	            setTimeout(function() {
	            time(o)
	        }, 1000)
	    }
	};
	
	$("#fetchCode").on("click",function(){
		var phone = $('#phone').val();
		if(!(/^1[34578]\d{9}$/.test(phone))){
			alert('请填写正确的手机号！');
			return false;
		};
		if ( $('#fetchCode').val() =='获取验证码' ) {
			$.ajax({
				url:"{{url('register/sssendCode1')}}",
				type:"post",
				data:{phone:phone},
				success:function(data){
					alert(data.message);
				}
			});
		}
		time("#fetchCode");
	})
	//登录
	$('.register_btn').on('click',function(){
		var pid = $('#pid').val();
		var phone = $('#phone').val();
		if(!(/^1[34578]\d{9}$/.test(phone))){
			alert('请填写正确的手机号！');
			return false;
		};

		var code = $('#code').val();
		if (code.length < 0 ) {
			alert('请输入验证码');
			return false;
		}

		$.ajax({
			url:"{{url('register/goRegister1')}}",
			type:"post",
			data:{phone:phone,pid:pid,code:code},
			success:function(data){
				if ( data.status ){
					window.location.href = "{{url('/')}}";
				}else{
					alert(data.message);
				}
			}
		});


	});
</script>
</body>
</html>