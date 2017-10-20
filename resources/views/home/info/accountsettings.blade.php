<!DOCTYPE html>
<html>
<head>
	<title>爱无尚</title>
	@include('home.public.header')
	<style>
		body{
			background-color:#f5f5f5;
		}
		.myBoxlist p{
			padding-left:3px;
			color:#666;
			font-size: 16px
		}
		.myBoxlist span{
			color:#a5a5a5;
			font-size:16px;
		}
	</style>
</head>
<body>
<div class="public_head" style="background-color:#fff">
	<h3 style="color:#333">账号设置</h3>
	<a style="font-size:20px;color:#333" href="javascript:history.go(-1);" class="iconfont icon-you-copy"></a>
</div>
<div class="content">
	<ul class="myBox">
		<li class="myBoxlist">
			<a href="/info/modify_login" class="a_jump">
				<p>修改登录密码</p>
				<span class="iconfont icon-you"></span>
			</a>
		</li>
		<li class="myBoxlist">
			<a href="/info/modify_pay" class="a_jump">
				<p>修改支付密码</p>
				<span class="iconfont icon-you"></span>
			</a>
		</li>
	<!-- 	<li class="myBoxlist">
			<a href="/users/logout" class="a_jump">
				<p>退出当前账号</p>
				<span class="iconfont icon-you"></span>
			</a>
		</li> -->
	</ul>
</div>
</body>
</html>