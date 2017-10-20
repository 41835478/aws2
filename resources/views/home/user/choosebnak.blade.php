
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
	.public_head i{
		color: black;
		font-size: 15px;
	}
	.public_head{
		background: white;
	}
	.public_head a{
		color: black;
	}
	.public_head h3{
		color: black;
	}



</style>
</head>
<body>
<div class="public_head">
	<h3>选择银行卡</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>

    <i onclick="window.location.href='/users/addbank/5'"  class="iconfont icon-jia"> </i>
</div>
<!-- 内容区 -->

<div class="content">
	<div class="present_ban">
	    <div class="present_bann">
			<p>￥</p>
			<input type="number" placeholder="请输入提现金额" name="num" class="num">
		</div>
		<em>注：最低提现额度为50元，预留20%进入复投积分，预留10%进入消费积分</em>
	</div>
	<div class="present_boxx"></div>
	<div class="present_cont">
		<div class="present_conto">
			<p>可用余额<span>￥{{$users['account']}}</span></p>
		</div>
	</div>


	<div class="present_boxx"></div>
	@foreach($yinhang as $k=>$v)
	<div class="choose_cent">
		<div class="choose_centt">
			<i class="iconfont icon-zhongguonongyeyinhang"></i>
			<p>{{$v['bankname']}}<span>({{$v['number']}} )</span></p>
			
			<i class="present_i iconfont "  data-id="{{$v['number']}}"></i>
		</div>	
	</div>
	@endforeach
	<!-- <div class="choose_cent">
		<div class="choose_centt">
			<i class="iconfont icon-zhongguoyinhang"></i>
			<p>中国银行<span>( ****4456 )</span></p>
			<i class="present_i iconfont"></i>
		</div>	
	</div>
	<div class="choose_cent">
		<div class="choose_centt">
			<i class="iconfont icon-zhongguonongyeyinhang"></i>
			<p>中国农业银行<span>( ****4456 )</span></p>
			<i class="present_i iconfont"></i>
		</div>	
	</div>	 -->
	<div class="present_foot">

	<input type="hidden" name="id" value="2" class="id" >
		<input  type="button" value="确认提现"   id="btn1" class="present_btn true">
	</div>
</div>
<script>



window.onload=function(){
    document.getElementById('btn1').onclick=function(){
        this.disabled=true;
        setTimeout(function (){
            document.getElementById('btn1').disabled=false;
        },5000);
    }
     
}

	$(".choose_centt").on("click", function (){
      $(".choose_centt").find('.present_i').removeClass('icon-duihao');
      $(this).find('.present_i').addClass("icon-duihao");
      var box = $(this);
      var index = goIndex(box);
   });
   function goIndex(it) {
      var big = it.parent();
      for (var i = 0; i < big.children().length; i++) {
          if (big.children().eq(i)[0] == it[0]) {
              return i;
          }
       }
    };
</script>
<script type="text/javascript">
	  $('.true').click(function(){
         
            var num=$('.num').val();
            var id=$('.id').val();
           	var number=$(".icon-duihao").attr("data-id");
           	var type=3;
           	//alert(number);
         
            if(num==""){
            	alert('请输入数量');
            	return false;
            }
         

            var data={
               	'number':number,
                'num':num,
                'id':id,
                'type':type,
               
            }
            var url="{{url('users/editaccount')}}";
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



</body>
</html>