
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
	.footer{
		width:100%;
		padding:0;
		height:50px;
	}
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
	.myBoxlist{padding:0 3.125%;}
	.myBoxlist>p{padding:0;font-size: 16px;color:#353535;}
	.memberUser{font-size:16px;color:#333;display:block;float:right;text-align: right;width:72%;height:54px;}
	.myBoxlist span.memberAvail{display:block;float:right;text-align: right;width:50%;overflow:hidden;font-size: 16px;color:#333;}
	.memberSelect{border:0;display:block;float:right;text-align: right;height:54px;font-size: 16px;color:#ffb32a;padding:0;background: url("{{asset('home/images/selectbg.png')}}") no-repeat right 24px;background-size:15px 8px;padding-right:20px;}
	.myBoxlist span.memberExpend{font-size: 16px;color:#ffb32a;display:block;float:right;}
</style>
</head>
<body>
<div class="public_head" style="background-color:#fff">
	<h3 style="color:#333">激活会员订单</h3>
	<a style="font-size:20px;color:#333" href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="content">
	<ul class="myBox">
		<li class="myBoxlist">
			<p>会员账号：</p>
			<input class="memberUser phone" type="text" placeholder="请输入您要激活的会员的账号"/>
		</li>
		<li class="myBoxlist">
			<p>可用复投币余额：</p>
			<span class="memberAvail">{{$users['repeat_points']}}</span>
		</li>
		<li class="myBoxlist">
			<p>激活订单：</p>
			<select class="memberSelect type" name="" id="">
				<option value="1">100元订单</option>
				<option value="2">300元订单</option>
				<option value="3">2000元订单</option>
			</select>
		</li>
		<li class="myBoxlist">
			<p>需消耗复投币：</p>
			<span class="memberExpend">100.00</span>
		</li>
	</ul>
</div>
<footer class="footer">
	<button class="edit_save true"   id="btn1" type="button">确定激活</button>
</footer>
<script type="text/javascript">
	$('.memberSelect').on('change',function(){
		var _txt = $(this).val();
		if(_txt==1){
			$('.memberExpend').text("100.00");
		}
		if(_txt==2){
			$('.memberExpend').text("300.00");
		}
		if(_txt==3){
			$('.memberExpend').text("2000.00");
		}
	})
</script>
</body>

<script type="text/javascript">



window.onload=function(){
    document.getElementById('btn1').onclick=function(){
        this.disabled=true;
        setTimeout(function (){
            document.getElementById('btn1').disabled=false;
        },5000);
    }
     
}
	  $('.true').click(function(){
            var phone=$('.phone').val();
            var type=$('.type').val();
           
            if(phone==""){
                alert("请输入会员账号！");
                return false;
            }
            if(!phone.match(/^1[34578]\d{9}$/)){
                alert('手机号不符合规则！');
                return false;
            }
            if(type==""){
            	alert('请输入激活的订单');
            	return false;
            }
            var data={
                'phone':phone,
                'type':type,
            }
            var url="{{url('users/editactivememberorders')}}";
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
                             if(data.data.flag==1)  {
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