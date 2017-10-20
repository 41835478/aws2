
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
<link rel="stylesheet" href="{{asset('home/css/LArea.css')}}">
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('home/js/LAreaData1.js')}}"></script>
<script src="{{asset('home/js/LAreaData2.js')}}"></script>
<script src="{{asset('home/js/LArea.js')}}"></script>
<style>
	body{background-color:#f5f5f5;}
	.footer{width:100%;padding:0;height:50px;line-height: 50px;border:0;}
	.paymentItem>p{padding:0;color:#666;}
	.paymentItem>span{color:#333;font-size: 16px;width:70%;overflow:hidden;text-align: right;height:50px;}
	.paymentItem>span.selectCity{color:#999999;}
	.footer{padding:0;width:100%;height:50px;line-height: 50px;}
	.paymentList>li{height:50px;line-height: 50px;}
	.content-block{
		width:78%;
		float:right;
	}
	.content-block input{
       	 border:0;
       	 font-size: 16px;
       	 color: #333;
       	 float: right;
       	 text-align: right;
       	 line-height: 50px;
       	 width:100%;
    }
    ::-webkit-input-placeholder {
        color: #333;font-size:16px
    } 
    :-moz-placeholder {
        color: #333; font-size:16px
    } 
    ::-moz-placeholder {
        color: #333; font-size:16px
    } 
    :-ms-input-placeholder {
        color: #333; font-size:16px
    } 
    .demo::-webkit-input-placeholder {
        color: #999999;font-size:16px
    } 
    .demo:-moz-placeholder {
        color: #999; font-size:16px
    } 
    .demo::-moz-placeholder {
        color: #999; font-size:16px
    } 
    .demo:-ms-input-placeholder {
        color: #999; font-size:16px
    }
    .paymentList{border-top:0;}
</style>
</head>
<body>
<div class="public_head" style="background-color:#fff">
	<h3 style="color:#333">添加新地址</h3>
	<a style="color:#333;" href="javascript:history.go(-1);location.reload()" class="iconfont icon-fanhui"></a>
</div>
<div class="content" style="padding-bottom:50px;">
	<ul class="paymentList">
		<li class="paymentItem">
			<p>收货人</p>
			<input placeholder="" name="name" id="name" />
		</li>
		<li class="paymentItem">
			<p>联系电话</p>
			<input placeholder=""   name="phone" id="phone" />
		</li>
		<li class="paymentItem">
			<p>所在街区</p>
			<div class="content-block">
	            <input class="demo" id="demo2" type="text" readonly placeholder="请选择 >" />
	            <input id="value2" type="hidden" />
            </div>

		</li>
	</ul>
	<div class="addressDetail">
		<textarea class="demo"  id="demo"  placeholder="请填写详细地址，不少于5个字"></textarea>
	</div>
	<div class="setDefault">
		<p class="div_left">设为默认</p>
		<i class="iconfont icon-guanbi"  id="di" data-num="0"></i>
	</div>
</div>
<footer class="footer">
	<button type="button" id="btn1" class="edit_save true">保存</button>
</footer>
<script type="text/javascript">
	$('.setDefault i').on('touchend',function(){
        $(this).toggleClass('icon-guan');
        if($('.setDefault i').hasClass('icon-guan')){
            $(this).attr("data-num",1);
        }else{
            $(this).attr("data-num",0);
        }
    })
        

	var area2 = new LArea();
    area2.init({
        'trigger': '#demo2',
        'valueTo': '#value2',
        'keys': {
            id: 'value',
            name: 'text'
        },
        'type': 2,
        'data': [provs_data, citys_data, dists_data]
    });
</script>


<script type="text/javascript">
// window.onload=function(){
//     document.getElementById('btn1').onclick=function(){
//         this.disabled=true;
//         setTimeout(function (){
//             document.getElementById('btn1').disabled=false;
//         },3000);
//     }
     
// }
  $('.true').click(function(){
            var name=$('#name').val();
            var phone=$('#phone').val();
            var demo2=$('#demo2').val();
            var demo=$('#demo').val();
            var di=$('#di').attr("data-num");
            var gh={{$dizhi}};
          
         
            if(name==""){
                alert('请输入收货人');
                return false;
            }
             if(phone==""){
                alert('请输入手机号');
                return false;
            }
             if(!phone.match(/^1[34578]\d{9}$/)){
                alert('手机号不符合规则！');
                return false;
            }
             if(demo2==""){
                alert('请输入地址');
                return false;
            }
             if(demo==""){
                alert('请输入详细地址');
                return false;
            }
           var data={
                'name':name,
                'phone':phone,
                'demo2':demo2,
                'demo':demo,
                'di':di,
                'gh':gh,
               
            }
            
            var url="{{url('users/editaddress')}}";
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
                                window.location.href="{{url('users/shippingaddress')}}";
                              //window.location.href = document.referrer;

                             } 
                              if(data.data.flag==2)  {
                              	//self.location=document.referrer;

                                window.location.href="javascript:history.go(-3);location.reload()";
                              }                  
            
                        }else{
                            alert(data.message);
                            window.location.reload();
                        }                  
                },
             
            })
        }

 

</script>


</body>
</html>