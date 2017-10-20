<!DOCTYPE html>
<html>
<head>
	<title>爱无尚</title>
	@include('home.public.header')
	<style>
		body{
			background-color:#fff;
		}
		::-webkit-input-placeholder {
			color: #959595;font-size:14px
		}
		:-moz-placeholder {
			color: #959595; font-size:14px
		}
		::-moz-placeholder {
			color: #959595; font-size:14px
		}
		:-ms-input-placeholder {
			color: #959595; font-size:14px
		}
		.footer{
			padding:0;
			width:100%;
			height:50px;
			line-height: 50px;
			border:0;
		}
	</style>
</head>
<body>
<div class="public_head" style="background-color:#fff">
	<h3 style="color:#333">修改支付密码</h3>
	<a style="font-size:20px;color:#333" href="javascript:history.go(-1);" class="iconfont icon-you-copy"></a>
</div>
<div class="content" style="padding-bottom:68px">
	<form method="POST" action="/info/user_info">
		<ul class="modifyBox">
			<li class="modifylist">
				<i class="iconfont icon-shouji2"></i>
				<input type="hidden" name="type" value="pay" />
				<input type="text" name="phone" readonly placeholder="{{substr_replace($users->phone,'****',3,4)}}"/>
			</li>
			<li class="modifylist">
				<i class="iconfont icon-yanzhengyanzhengma"></i>
				<input type="text" name="code" placeholder="请输入短信验证码"/>
				<button id="fetchCode" type="button" class="modify_code" >获取验证码</button>
			</li>
			<li class="modifylist">
				<i class="iconfont icon-mima1"></i>
				<input type="password" name="pwd" placeholder="请输入6位纯数字密码"/>
			</li>
			<li class="modifylist">
				<i class="iconfont icon-mima1"></i>
				<input type="password" name="t_pwd" placeholder="请再次输入密码"/>
			</li>
		</ul>

</div>
<footer class="footer">
	<button type="submit" class="edit_save">确认</button>

</footer>
</form>
<script type="text/javascript">
  $('#fetchCode').on("touchstart",function () {
		var count = 120;
		var countdown = setInterval(CountDown, 1000);
		function CountDown() {
		    $("#fetchCode").css('pointer-events', 'none');;
		    $("#fetchCode").text("重新发送("+count +")");
		    if (count == 0) {
		    	$("#fetchCode").css('pointer-events', 'auto');
		    	 $("#fetchCode").text("发送验证码");
		        clearInterval(countdown);
		    };
		    count--;
		}
		var phone = "{{$users->phone}}";
		var data={
			'phone':phone,
			'_token':"{{csrf_token()}}",
		};
		var url="{{url('register/sendyamcode')}}";
		sendAjax(data,url)
	})

	function sendAjax(data,url){
		$.ajax({
			'url':url,
			'data':data,
			'async':true,
			'type':'post',
			'dataType':'json',
			success:function(data){
				if(data.status){
					alert(data.message);
					if(data.data.flag==1){
						window.location.href="/users/index";
					}else if(data.data.flag==3){
						var wait=10;
						time(this,wait)
					}
				}else{
					alert(data.message);
				}
			},
			error:function(msg){
				var json=JSON.parse(msg.responseText);
				alert(Object.values(json)[0].toString());
			}
		})
	}
</script>
</body>
</html>