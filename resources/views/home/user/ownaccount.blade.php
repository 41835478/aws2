
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
	.public_head i{
		color: white;
	}
	body{
		background: #f5f5f5;
	}
	.present_ban{
		margin-top: 7px;
		background: white;
		height: 123px;
		border-bottom: 1px #f5f5f5 solid;
	}
	.present_ban p {
	    font-size: 40px;
	    color: #666666;
	    line-height: 0px;
	    float: left;
	    margin-top: 49px;
	}
	.present_cont{
		background: white;height:auto;
	}
	.present_foot input[type=submit] {
    width: 100%;
    height: 50px;
    border: 0;
    background: none;
    font-size: 17px;
    text-align: center;
    line-height: 50px;
    color: white;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}
.modify_code{
    display: block;
    position: absolute;
    top: 14px;
    right: 3.125%;
    color: #2195ec;
    font-size: 14px;
    border: 1px solid #2195ec;
    border-radius: 5px;
    background-color: #eef7fe;
    height: 35px;
}
.present_change{border-bottom:1px solid #e6e6e6;position:relative;}
.present_change>p{float:left;}
.present_change>input{display:block;float:left;height:63px;border:0;padding:0 5px;}
</style>
</head>
<body>
<div class="public_head">
	<h3>众筹奖金转入余额</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content">
<!-- 	<div class="cancell_ban">
		<div class="cancell_bano">
			<p>好友账号</p>
			<input type="text" name="phone" class="phone" />
		</div>
	</div> -->
	<div class="present_ban">
		<em class="cancell_po">转入金额</em>
	    <div class="present_bann">
			<p>￥</p>
			<input type="number" name="num" class="num" />
		</div>
	</div>
	<div class="present_cont">
        <div class="present_conto present_change">
            <p>验证码：</p>
            <input type="number" name="code" class="code" />
            <button id="code" type="button" class="yzbtn modify_code" >获取验证码</button>
        </div>
		<div class="present_conto">
			<p>可用余额<span>￥{{$count}}</span></p>
		</div>
	</div>
	<div class="cancell_cont">
		<div class="cancell_conto">
			<p>注：转账最低金额为50元</p>
		</div>
	</div>
	<div class="present_foot">
     <input type="hidden" name="phone" class="cphone" value="13103810741">
	<!-- <input type="hidden" name="id" value="1" class="id" > -->
        <input  type="button" value="确认转入"   id="btn1" class="present_btn true">
	</div>
</div>
</body>



<script type="text/javascript">
window.onload=function(){
    document.getElementById('btn1').onclick=function(){
        this.disabled=true;
        setTimeout(function (){
            document.getElementById('btn1').disabled=false;
        },1000);
    }
 
}
$('.num').bind('input propertychange',function(){
    var is = $(this);
    if ( is.val() <= 0) {
        $('.num').val('');
    }
});
$('#code').on('click',function(){
    // var phone = $("#phone").val();
    // if(!(/^1[34578]\d{9}$/.test(phone))){ 
    //       alert("手机号码有误!");  
    //       return false; 
    //   } 
    var count = 60;
    var countdown = setInterval(CountDown, 1000);
    function CountDown() {
        $("#code").css('pointer-events', 'none');;
        $("#code").text("重新发送("+count +")");
        if (count == 0) {
          $("#code").css('pointer-events', 'auto');
           $("#code").text("发送验证码");
            clearInterval(countdown);
        };
        count--;
    }
});



 $('.yzbtn').click(function(){
            var phone=$('.cphone').val();
            if(phone==""){
                alert("请输入您的手机号码！");
                return false;
            }
            if(!phone.match(/^1[34578]\d{9}$/)){
                alert('手机号不符合规则！');
                return false;
            }
            // var data={
            // }
            var url="{{url('register/sendyamcode')}}";
               $.ajax({
                'url':url,
                'data':{phone:phone},
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                   if(data.status){
                        alert(data.message);
                        if(data.data.flag==3){
                            var wait=10;
                            time(this,wait);
                        }
                    }else{
                          alert(data.message);
                          window.location.reload();
                        }                  
                },
             
            })
            
        })



	  $('.true').click(function(){
            // var phone=$('.phone').val();
            var num=$('.num').val();
            // var id=$('.id').val();
            var code=$('.code').val();
            // if(phone==""){
            //     alert("请输入您的手机号码！");
            //     window.location.reload();
            //     return false;
            // }
            // if(!phone.match(/^1[34578]\d{9}$/)){
            //     alert('手机号不符合规则！');
            //     window.location.reload();
            //     return false;
            // }
            if(num==""){
            	alert('请输入金额');
                window.location.reload();
            	return false;
            }
            if(code==""){
                alert("请输入验证码！");
                window.location.reload();
                return false;
            }
            var data={
                'num':num,
                'code':code
            }
            var url="{{url('users/ownaccount')}}";
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