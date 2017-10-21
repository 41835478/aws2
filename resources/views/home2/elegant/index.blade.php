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
<link rel="stylesheet" href="{{asset('home/css/swiper.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('home/font/iconfont.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/common.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/index.css')}}"/>
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<style>
	body{
		background-color:#f5f5f5;
	}
	.public_head{background:#fff;}
	.public_head h3{color:#333;}
	::-webkit-input-placeholder {
        color: #999;font-size:16px
    } 
    :-moz-placeholder {
        color: #999; font-size:16px
    } 
    ::-moz-placeholder {
        color: #999; font-size:16px
    } 
    :-ms-input-placeholder {
        color: #999; font-size:16px
    } 
    .myBox>li {border-bottom: 1px solid #eaeaea;height:50px;line-height: 50px;}

	.myBoxlist{padding:0 3.125%;}
	.myBoxlist>p{padding:0;font-size: 16px;color:#353535;}
	.memberUser{font-size:16px;color:#333;display:block;float:right;text-align: right;width:72%;height:50px;}
	.noble-box{margin-top:12px;background:#fff;}
	.noble-box>h3{padding:0 3.125%;height:50px;line-height:50px;font-size: 16px;color:#333;background-color:#fff;border-bottom:1px solid #eaeaea;}
	.noble-pics{
		border-bottom:1px solid #eaeaea;
		padding:18px 3.125%;
		display: -webkit-box;
	    display: -moz-box;
	    display: -ms-flexbox;
	    display: -webkit-flex;
	    display: flex;
	    -webkit-box-orient: horizontal;
	    -webkit-box-direction: normal;
	    -moz-box-orient: horizontal;
	    -moz-box-direction: reverse;
	    -webkit-flex-direction: row;
	    flex-direction: row;
	    -webkit-justify-content: space-between;
	    -moz-box-pack: space-between;
	    -webkit--moz-box-pack: space-between;
	    box-pack: space-between;
	    justify-content: space-between;
	    -webkit-flex-wrap: wrap;
	    -webkit-box-lines: multiple;
	    -moz-flex-wrap: wrap;
	    flex-wrap: wrap;
	}
	.noble-pics li{
		width:30%;font-size:14px;height:108px;
	}
	.noble-pics li img{display:block;width:100%;height:100%;}
	.noble-pics li:nth-child(1){background:url("{{asset('home/images/card_bg1.png')}}") no-repeat center center;background-size:100%;}
	.noble-pics li:nth-child(2){background:url("{{asset('home/images/card_bg2.png')}}") no-repeat center center;background-size:100%;}
	.noble-pics li:nth-child(3){background:url("{{asset('home/images/card_bg3.png')}}") no-repeat center center;background-size:100%;}
	.content-con2 .noble-pics li:nth-child(1){background:url("{{asset('home/images/card_bg4.png')}}") no-repeat center center;background-size:100%;}
	.noble-btn{padding:24px 17% 0;}
	.noble-btn button{display:block;width:100%;height:45px;line-height: 45px;padding:0;background-color:#2194eb;font-size: 16px;color:#fff;border-radius:5px;}
</style>
</head>
<body>
<div class="public_head">
	<h3>贵人币注册</h3>
</div>
<!-- 内容区 -->
<div class="content">
	<form id="form1">
	<div class="content-con">
		<ul class="myBox">
			<li class="myBoxlist">
				<p>姓名</p>
				<input class="memberUser" name="name" type="text" placeholder="请输入您的姓名"/>
			</li>
			<li class="myBoxlist">
				<p>性别</p>
				<input class="memberUser" name="sex" type="text" placeholder="请输入您的性别"/>
			</li>
			<li class="myBoxlist">
				<p>手机号码</p>
				<input class="memberUser" name="mobile" type="text" placeholder="请输入您的手机号码"/>
			</li>
			<li class="myBoxlist">
				<p>身份证号码</p>
				<input class="memberUser" name="ID_code" type="text" placeholder="请输入您的身份证号"/>
			</li>
		</ul>
		<div class="noble-box">
			<h3>上传证件材料</h3>
			<ul class="div_displayFlex noble-pics">
				<li>
					<img src="" alt="" id="cart_front"/>
					<input type="file" accept="image\*" style="display:none" onchange="setImageShow('cart_front2','cart_front')"  name="cart_front" id="cart_front2" >
				</li>
				<li>
					<img src="" alt="" id="cart_bg"/>
					<input type="file" accept="image\*" style="display:none" onchange="setImageShow('cart_bg2','cart_bg')"  name="cart_bg" id="cart_bg2" >
				</li>
				<li>
					<img src="" alt="" id="cart_hold"/>
					<input type="file" accept="image\*" style="display:none" onchange="setImageShow('cart_hold2','cart_hold')"  name="cart_hold" id="cart_hold2" >
				</li>
			</ul>
		</div>
		<div class="noble-btn">
			<button type="button" id="nextStep">下一步</button>
		</div>
	</div>
	<div class="content-con2" style="display:none">
		<ul class="myBox">
			<li class="myBoxlist">
				<p>经纪人</p>
				<input class="memberUser" name="agent_name" type="text" placeholder="请输入经纪人的姓名"/>
			</li>
			<li class="myBoxlist">
				<p>地址</p>
				<input class="memberUser" name="address" type="text" placeholder="请输入您的地址"/>
			</li>
			<li class="myBoxlist">
				<p>银行名称</p>
				<input class="memberUser" name="bank_name" type="text" placeholder="请输入所属银行"/>
			</li>
			<li class="myBoxlist">
				<p>开户行</p>
				<input class="memberUser"  name="account_name" type="text" placeholder="请输入开户行名称"/>
			</li>
			<li class="myBoxlist">
				<p>银行卡号</p>
				<input class="memberUser" name="bank_code" type="text" placeholder="请输入您的银行卡号"/>
			</li>
		</ul>
		<div class="noble-box">
			<h3>上传证件材料</h3>
			<ul class="div_displayFlex noble-pics">
				<li>
					<img src="" id="bank_img"/>
					<input type="file" accept="image\*" style="display:none" onchange="setImageShow('bank_img2','bank_img')"  name="bank_img" id="bank_img2" >
				</li>
			</ul>
		</div>
		<div class="noble-btn">
			<button type="button"  onclick="doUpload()">提交</button>
		</div>
	</div>
	</form>
</div>
<footer class="footer">
	<div class="footerCon">
		<a href="/" class="a_jump">
			<img src="{{asset('home/images/icon-1.png')}}" alt=""/>
			<span class="footerlist-cn">首页</span>
		</a>
		<a href="/shop/cart" class="a_jump">
			<img src="{{asset('home/images/icon-2.png')}}" alt=""/>
			<span class="footerlist-cn">购物车</span>
		</a>
		<a href="{{url('elegant/index')}}" class="a_jump footerOn">
			<img src="{{asset('home/images/noble-icon.png')}}" alt=""/>
			<span class="footerlist-cn">贵人币</span>
		</a>
		<a href="{{url('users/index')}}" class="a_jump">
			<img src="{{asset('home/images/icon-4.png')}}" alt=""/>
			<span class="footerlist-cn">我的</span>
		</a>
	</div>
</footer>
<script type="text/javascript">
	$('#nextStep').on('click',function(){
		$('.content-con').css('display','none');
		$('.content-con2').show(500);
	});
</script>
</body>
</html>
<script>
	$('#cart_front').click(function(){//身份证正面
		$('#cart_front2').trigger('click');
	})
	$('#cart_bg').click(function(){//身份证反面
		$('#cart_bg2').trigger('click');
	})
	$('#cart_hold').click(function(){//手持身份证
		$('#cart_hold2').trigger('click');
	})
	$('#bank_img').click(function(){//银行卡正面照片
		$('#bank_img2').trigger('click');
	})

	function doUpload(){
		var formData = new FormData($("#form1")[0]);
		var name=formData.get('name');
		if(!name){
			alert('姓名不能为空');
			return false;
		}
		var sex=formData.get('sex');
		if(!sex){
			alert('性别不能为空');
			return false;
		}
		var mobile=formData.get('mobile');
		if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(mobile))){
			alert('手机号输入不合法');
			return false;
		}
		var ID_code=formData.get('ID_code');
		var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
		if(reg.test(ID_code) === false){
			alert("身份证输入不合法");
			return  false;
		}
		var agent_name=formData.get('agent_name');
		if(!agent_name){
			alert('经纪人不能为空');
			return false;
		}
		var address=formData.get('address');
		if(!address){
			alert('地址不能为空');
			return false;
		}
		var bank_name=formData.get('bank_name');
		if(!bank_name){
			alert('所属银行名称不能为空');
			return false;
		}
		var account_name=formData.get('account_name');
		if(!account_name){
			alert('开户行名称不能为空');
			return false;
		}
		var bank_code=formData.get('bank_code');
		if(!(/^\d{16}|\d{19}$/.test(bank_code))){
			alert("银行卡号输入不合法");
			return  false;
		}
		$.ajax({
			url: "{{url('elegant/register')}}",
			type: 'POST',
			data: formData,
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function (returndata) {
				if(returndata.status){
					alert(returndata.message);
				}else{
					alert(returndata.message);
					window.location.reload();
				}
			},
			error: function (msg) {
				var json=JSON.parse(msg.responseText);
				var arr = [];
				for(var obj in json){
					arr.push(json[obj])
				}
				alert(arr[0].toString());
			}
		})
	}

	function setImageShow(fileId,imgId){//上传图片显示,input内用onchange
		var docObj = document.getElementById(fileId);
		var fileList = docObj.files;
		var imgObjPreview = document.getElementById(imgId);
		imgObjPreview.style.width="100%";
		imgObjPreview.style.height="100%";
		imgObjPreview.src = window.URL.createObjectURL(fileList[0]);
	}
</script>