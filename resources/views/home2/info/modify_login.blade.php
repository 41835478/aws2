
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
	<h3 style="color:#333">修改登录密码</h3>
	<a style="font-size:20px;color:#333" href="javascript:history.go(-1);" class="iconfont icon-you-copy"></a>
</div>
<form action="/info/user_info" method="post">
<div class="content" style="padding-bottom:68px">
	<ul class="modifyBox">
		<li class="modifylist">
			<i class="iconfont icon-shouji2"></i>
			<input type="hidden" name="type" value="login" />
			<input type="text" name="phone" placeholder="{{substr_replace($users->phone,'****',3,4)}}"/>
		</li>
		<li class="modifylist">
			<i class="iconfont icon-yanzhengyanzhengma"></i>
			<input type="text" name="code" placeholder="请输入短信验证码"/>
			<button id="fetchCode" type="button" class="modify_code">获取验证码</button>
		</li>
		<li class="modifylist">
			<i class="iconfont icon-mima1"></i>
			<input type="password" name="pwd" placeholder="请输入新密码"/>
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
	var wait=120;
	function time(o) {
		if (wait == 0) {
			o.removeAttribute("disabled");
			o.innerHTML="获取验证码";
			wait = 120;
		} else {

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
		};

			o.setAttribute("disabled", true);
			o.innerHTML = "重新发送(" + wait + ")";
			wait--;
			setTimeout(function () {
				time(o)
			}, 1000)
		}
	}
	$("#fetchCode").on("touchend",function(){
		time(fetchCode);
		var phone = "{{$users->phone}}";
		console.log(phone);
		if(phone==""){
			alert("请输入您的手机号码！");
			return false;
		}
		if(!phone.match(/^1[34578]\d{9}$/)){
			alert('手机号不符合规则！');
			return false;
		}
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