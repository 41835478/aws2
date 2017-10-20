
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
<script type="text/javascript" src="{{asset('home/js/fly.js')}}"></script>


<style>
	.public_head{
		background: white;
	}
	.public_head h3{
		color: black;
	}
	.public_head a{
		color: black;
	}
	.account_ka {
		position: relative;
	}
	.account_ka_out {
		width: 100%;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
		background: rgba(0,0,0,0);
		-moz-user-select: -moz-none;
		-moz-user-select: none;
		-o-user-select: none;
		-khtml-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
		user-select: none; 
		-webkit-touch-callout： none;
		-webkit-tap-highlight-color:rgba(0,0,0,0);
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>账户绑定</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content">
	<div class="account_box"></div>
	<ul class="account_main">
		@if($zhifu== '****')
		<li>
			<i class="iconfont icon-zhifubao1"></i>
			<p class="account_po">绑定支付宝</p>
			<p onclick="window.location.href='/users/bindingaliplay'" class="account_pt ">绑定支付宝</p>
			<p class="account_pn"> </p>			
		</li>
		@else
		<li>
			<i class="iconfont icon-zhifubao1"></i>
			<p class="account_po">绑定支付宝</p>
		 	<input type="hidden" name="jie" value="jie" class="jie">
			<p  class="account_pt account_acitve true" >解绑</p>
			<p class="account_pn">{{$zhifu}}</p>			
		</li>
		@endif
		

		<li>
			<i class="iconfont icon-weixin1"></i>
			<p class="account_po">绑定微信</p>
			<p onclick="javascript:window.location.href='/users/bingwx'" class="account_pt">绑定</p>			
		</li>


	</ul>
	<div class="account_box"></div>
	<ul class="account_cont">
	@foreach($yinhang as $k=>$v)
			@if($k==0)
				<li name="1"   value="{{$v['id']}}" class="account_ka yin">
			@elseif($k==1)
			<li name="1"  value="{{$v['id']}}" class="account_ka account_kao yin">
			@elseif($k==2)
			<li name="1" value="{{$v['id']}}" class="account_ka account_kat yin">
			@endif
			<p class="account_pa">{{$v['bankname']}}</p>
			<p class="account_pb">储蓄卡</p>
			<p class="account_pc">{{$v['number']}}</p>
			<div class="account_ka_out"></div>
		</li>
	@endforeach
		
	</ul>
	<p class="account_y">长按删除银行卡</p>

	<input onclick="javascript:window.location.href='/users/addbank'" type="button" value="添加银行卡" class="account_btn"/>
</div>
<script>
	
	 //长按事件
$.fn.longPress = function (fn) {
　　var timeout = undefined;
　　var $this = this;
	var x = 0,
		y = 0;
　　for (var i = 0; i < $this.length; i++) {
	　　$this[i].addEventListener('touchstart', function (event) {
			var e = e || window.event;
	　　	timeout = setTimeout(fn, 800, event);
			x = e.touches[0].pageX;
			y = e.touches[0].pageY;
	　　}, false);
	　　$this[i].addEventListener('touchmove', function (event) {
			var e = e || window.event;
			if (e.touches[0].pageX - x >= 5 || e.touches[0].pageY - y >= 5) {
				clearTimeout(timeout);
			}
	　　}, false);
	　　$this[i].addEventListener('touchend', function (event) {
	　　	clearTimeout(timeout);
	　　}, false);
　　}
}

//阻止浏览器 复制粘贴等事件
var xPage = 0;
$('.account_ka').on('touchstart', function (e) {
	e = e || window.event;
	xPage = e.touches[0].pageX;
	e.preventDefault();
}).on('touchmove', function (e) {
	var x = e.touches[0].pageX - xPage;
	var scrollT = $(window).scrollTop();
	$(window).scrollTop(scrollT + x);
});
//触发事件
var _name;
$(".account_ka_out").longPress(function (e) {
	_name = $(this).attr("name");
	var flag = true;
	var box = $(e.target).parent();
　　addBox("body");
 	outBox("您确定要删除该银行账户吗？", 'javascript: void(0); $(\'#out-boxbg\').remove();');
 	$('#cancle').on("click",function(){
		
 console.log(box);

 		  var yinhang=$('.yin').val();
 		 	var jie='j11';
        // alert(yinhang);
        // return false;
            var data={
                'yinhang':yinhang,
                 'jie':jie,
               
               
            }
            var url="{{url('users/bindingdel')}}";
             $.ajax({
                'url':url,
                'data':data,
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                	 if(data.status){
                       
                        if(data.data.flag==1){
                          //  window.location.href='/users/index';
                        }
                    }else{
                        	alert(data.message);
                        	window.location.reload();
                        }                  
                },
             
            })

 		box.remove();
 	})
});

	 // function eeedAjax(data,url){
  //           $.ajax({
  //               'url':url,
  //               'data':data,
  //               'async':true,
  //               'type':'post',
  //               'dataType':'json',
  //               success:function(data){
  //               	 if(data.status){
                       
  //                       if(data.data.flag==1){
  //                           window.location.href='/users/index';
  //                       }
  //                   }else{
  //                       	alert(data.message);
  //                       	window.location.reload();
  //                       }                  
  //               },
             
  //           })
  //       }

 $('.true').click(function(){
            var jie='jie';
          
	          var data={
                'jie':jie,               
            }
            var url="{{url('users/bindingdel')}}";
         
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
                                // window.location.href="{{url('users/index')}}";
                             }                 
                            
                        }else{
                        	alert(data.message);
                        	window.location.reload();
                        }

                  
                },
             
            })
        })


</script>
</body>
</html>