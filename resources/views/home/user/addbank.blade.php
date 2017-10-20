
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
	.bank_main li p{
		width: 85px;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>添加银行卡</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->

<div class="content">
	<div class="account_box"></div>
	<ul class="bank_main">
		<li>
			<p>银行名称：</p>
			<input type="text" placeholder="请输入银行名称" name="bankname" class="bankname"  onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入银行名称'}">
		</li>
		<li>
			<p>开户人：</p>
			<input type="text" placeholder="请输入开户人姓名"   name="bankusername" class="bankusername"  onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入开户人姓名'}">
		</li>
		<li>
			<p>银行卡号：</p>
			<input type="text" placeholder="请输入银行卡号"   name="number" class="number"  onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入银行卡号'}">
		</li>
		<li>
			<p>开户支行：</p>
			<input type="text" placeholder="请输入开户支行"   name="bankaddress"  class="bankaddress"  onfocus="this.placeholder = ''" onblur="if(this.placeholder == ''){this.placeholder = '请输入开户支行'}">
		</li>
	</ul>
</div>
<input type="hidden" value="3" name="type" class="type">
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

	  $('.true').click(function(){
         	var bankname=$('.bankname').val();
         	var bankusername=$('.bankusername').val();
         	var bankaddress=$('.bankaddress').val();
            var number=$('.number').val();
            var type=$('.type').val();
            var id=5;
          
         
            if(bankname==""){
            	alert('请输入银行名称');
            	return false;
            }
             if(bankusername==""){
            	alert('请输入开户人姓名');
            	return false;
            }
             if(number==""){
            	alert('请输入银行卡号');
            	return false;
            }
             if(bankaddress==""){
            	alert('请输入开户支行');
            	return false;
            }
           var data={
               	'bankusername':bankusername,
               	'bankname':bankname,
               	'bankaddress':bankaddress,
                'number':number,
                'type':type,
                'id':id,
               
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
                             if(data.data.flag==1)  {
                                window.location.href="{{url('users/index')}}";
                             } 
                             if(data.data.flag==5)  {
                                window.location.href="{{url('users/choosebnak')}}";
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