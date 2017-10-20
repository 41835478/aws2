
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
<link rel="stylesheet" href="{{asset('home/css/fly.css')}}">
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<style>
	body{
		background: #f5f5f5;
	}
	.public_head{
		background: white;
	}
	.public_head h3{
		color: black;
	}
	.public_head a{
		color: black;
	}
.bank_main li input[type=password] {
    display: block;
    width: 54%;
    height: 55px;
    border: 0;
    font-size: 15px;
    color: #333;
    line-height: 55px;
    background: none;
    float: left;
}
.bank_main li input[type=text]{width:35%;} 
</style>
</head>
<body>
<div class="public_head">
	<h3>绑定支付宝</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content">
	<div class="account_box"></div>
	<ul class="bank_main">
		<li>
			<p>支付宝账号：</p>
			<input type="text" placeholder="请输入您的手机号码"  name="number" class="number" onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入您的手机号码'}">
		</li>
		<li>
			<p>支付宝姓名：</p>
			<input type="text" placeholder="请输入支付宝绑定姓名" name="bankname" class="bankname" onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入支付宝绑定姓名'}">
		</li>
		<li>
			<p>手机号码：</p>
			<input type="text" placeholder="请输入您的手机号码" name="phone"  value="{{$phone}}"  readonly onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入您的手机号码'}">
            <input type="hidden" name="phone" class="phone" value="{{$pphone}}">
		</li>
		<li>
			<p>登录密码：</p>
			<input type="password" placeholder="请输入您的登录密码"  name="password" class="password" onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入您的登录密码'}">
		</li>
		<li>
			<p class="alipay_po">短信验证码:</p>
			<input type="text" placeholder="短信验证码"  name="code" class="code" onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入短信验证码'}" class="alipay_ipt">
			<input type="button" class="yzbtn" value="获取验证码">
		</li>
	</ul>
</div>
<input type="hidden" name="type" value="2" class="type">
<input type="button" value="确认绑定" id="btn1" class="account_btn true"/>
</body>
<script type="text/javascript">
window.onload=function(){
    document.getElementById('btn1').onclick=function(){
        this.disabled=true;
        setTimeout(function (){
            document.getElementById('btn1').disabled=false;
        },3000);
    }
     
}
 $('.yzbtn').click(function(){
            var phone=$('.phone').val();
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
               
            }
            var url="{{url('register/sendyamcode')}}";
              eeedAjax(data,url)
            
        })
    function eeedAjax(data,url){
            $.ajax({
                'url':url,
                'data':data,
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                	 if(data.status){
                        alert(data.message);
                        if(data.data.flag==3){
                            var wait=10;
                            time(this,wait)
                        }
                    }else{
                        	alert(data.message);
                        	window.location.reload();
                        }                  
                },
             
            })
        }



	  $('.true').click(function(){
         	var bankname=$('.bankname').val();
         	var number=$('.number').val();
         	var phone=$('.phone').val();
         	var password=$('.password').val();
         	var code=$('.code').val();

            var type=$('.type').val();
          
         
            if(number==""){
            	alert('请输入您的支付宝账户');
            	return false;
            }
             if(bankname==""){
            	alert('请输入支付宝绑定姓名');
            	return false;
            }
             if(password==""){
            	alert('请输入您的登录密码');
            	return false;
            }
             if(code==""){
            	alert('请输入短信验证码');
            	return false;
            }
         

            var data={
               	'password':password,
               	'bankname':bankname,
               	'phone':phone,
               	'code':code,
                'number':number,
                'type':type,
               
            }
            var url="{{url('users/editbinding')}}";
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
                	 	window.location.href="{{url('users/index')}}";
                	 } 
                		                  	
                            
                        }else{
                        	alert(data.message);
                        	window.location.reload();
                        }                  
                },
             
            })
        }
</script>
</html>