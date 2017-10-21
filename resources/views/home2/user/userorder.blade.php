
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

<link rel="stylesheet" href="{{asset('home/css/main.css')}}">
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<style>
	body{
		background-color:#f5f5f5;
	}
</style>
</head>
<body>
<div class="public_head white_head">
	<h3>我的订单</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content">
	<ul class="myOrder_nav">


		<li class="li_on"><span>待付款</span></li>
		<li><span>待发货</span></li>
		<li><span>待收货</span></li>
		<li><span>已完成</span></li>
	</ul>

	<!-- pay -->
	<div class="myOrder_body">
		<div class="pay_box">
			
		@foreach($order_a as $k=>$v)
			<div class="order_list">
				<div class="order_top">
					<p class="order_num">订单号：<span>{{$v['order_code']}}</span></p>
					<span class="order_state"></span>
				</div>
				@foreach($v->info as $vv)
				<!-- 二次循环 -->
				<div class="order_center">
					<a href="{{url('users/userorderin',['id'=>$v['id']])}}">
						<img class="goodsImg" src="/{{$vv['pic']}}" alt="">
						<p class="goods_tit"></p>
						<p class="goods_msg">
							<span class="price_box">¥<em class="price">{{$vv['price']}}</em></span>
							<span class="num_box">x<em class="num">{{$vv['num']}}</em></span>
						</p>
					</a>
				</div>
				@endforeach

				<div class="order_bottom">
					<p class="all_money">合计：¥<em>{{$v['total_money']}}</em></p>
			
					<a class="pay_btn order_btn" href="/shop/payment?order_id={{$v['id']}}">立即付款</a>
					<button class="cancel_btn order_btn true" id="btn1" type="button">删除订单</button>
 @if($v['status']==1)
			<input type="hidden" name="type" value="1" class="type">
			<input type="hidden" name="id" value="{{$v['id']}}" class="id">
@endif

				</div>
			</div>
		@endforeach	


		</div>
	</div>
	<!-- send -->
	<div class="myOrder_body" style="display:none">
		<div class="send_box">
			
		@foreach($order_b as $v)
			<div class="order_list">
				<div class="order_top">
					<p class="order_num">订单号：<span>{{$v['order_code']}}</span></p>
					<span class="order_state"></span>
				</div>
				@foreach($v->info as $vv)
				<!-- 二次循环 -->
				<div class="order_center">
					<a href="{{url('users/userorderin',['id'=>$v['id']])}}">
						<img class="goodsImg" src="/{{$vv['pic']}}" alt="">
						<p class="goods_tit"></p>
						<p class="goods_msg">
							<span class="price_box">¥<em class="price">{{$vv['price']}}</em></span>
							<span class="num_box">x<em class="num">{{$vv['num']}}</em></span>
						</p>
					</a>
				</div>
				@endforeach

				<div class="order_bottom">
					<p class="all_money">合计：¥<em>{{$v['total_money']}}</em></p>
					<a class="pay_btn order_btn true" id="btn1" href="javascript:void(0);">提醒发货</a>
			 @if($v['status']==2)
			<input type="hidden" name="type" value="2" class="type">
			<input type="hidden" name="id" value="{{$v['id']}}" class="id">
			@endif


				</div>
			</div>
		@endforeach	

		
		</div>
	</div>

	<!-- take -->
	<div class="myOrder_body" style="display:none">
		<div class="take_box">
			@foreach($order_c as $v)
			<div class="order_list">
				<div class="order_top">
					<p class="order_num">订单号：<span>{{$v['order_code']}}</span></p>
					<span class="order_state"></span>
				</div>
				@foreach($v->info as $vv)
				<!-- 二次循环 -->
				<div class="order_center">
					<a href="{{url('users/userorderin',['id'=>$v['id']])}}">
						<img class="goodsImg" src="/{{$vv['pic']}}" alt="">
						<p class="goods_tit"></p>
						<p class="goods_msg">
							<span class="price_box">¥<em class="price">{{$vv['price']}}</em></span>
							<span class="num_box">x<em class="num">{{$vv['num']}}</em></span>
						</p>
					</a>
				</div>
				@endforeach

				<div class="order_bottom">
					<p class="all_money">合计：¥<em>{{$v['total_money']}}</em></p>
					
					<a class="pay_btn order_btn true" id="btn1" href="javascript:void(0);">确认收货</a>
				 @if($v['status']==4)
				<input type="hidden" name="type" value="3" class="type">
				<input type="hidden" name="id" value="{{$v['id']}}" class="id">
				@endif


				</div>
			</div>
		@endforeach	
	
		</div>
	</div>
	<!-- finish -->
	<div class="myOrder_body" style="display:none">
		<div class="finish_box">
				@foreach($order_d as $v)
			<div class="order_list">
				<div class="order_top">
					<p class="order_num">订单号：<span>{{$v['order_code']}}</span></p>
					<span class="order_state"></span>
				</div>
				@foreach($v->info as $vv)
				<!-- 二次循环 -->
				<div class="order_center">
					<a href="{{url('users/userorderin',['id'=>$v['id']])}}">
						<img class="goodsImg" src="{{$vv['pic']}}" alt="">
						<p class="goods_tit"></p>
						<p class="goods_msg">
							<span class="price_box">¥<em class="price">{{$vv['price']}}</em></span>
							<span class="num_box">x<em class="num">{{$vv['num']}}</em></span>
						</p>
					</a>
				</div>
				@endforeach

				<div class="order_bottom">
					<p class="all_money">合计：¥<em>{{$v['total_money']}}</em></p>
					<a class="pay_btn order_btn" href="{{url('shop/index')}}">再来一单</a>
				
				</div>
			</div>
		@endforeach	
		
		</div>
	</div>
</div>

<script>
	$(".myOrder_nav li").click(function() {
		var _index = $(this).index();
		$(".myOrder_nav li").removeClass('li_on');
		$(".myOrder_nav li").eq(_index).addClass('li_on');
		$(".myOrder_body").css('display','none');
		$(".myOrder_body").eq(_index).fadeIn(600);
	});
	// 判断进入状态
        $(function () {
            var list = $('.myOrder_nav li');

            switch((window.location.href).split('/')[5]) {
                case '1':
                    list.eq(0).trigger('click');
                    break;
                case '2':
                    list.eq(1).trigger('click');
                    break;
                case '3':
                    list.eq(2).trigger('click');
                    break;
                case '4':
                    list.eq(3).trigger('click');
                    break;
                default: 
                    break;
            }
        });
</script>


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
            var bool=confirm('你确定要执行该请求吗？将不可恢复');
            if(bool){
            
            var type=$('.type').val();
          
            var id=$('.id').val();
            var data={
                'type':type,
               
                'id':id,
               
            }
            var url="{{url('users/edituserorder')}}";
            sendAjax(data,url)
   
 
            }
        })


	  // $('.true').click(function(){
   //          var type=$('.type').val();
          
   //          var id=$('.id').val();
   //          var data={
   //              'type':type,
               
   //              'id':id,
               
   //          }
   //          var url="{{url('users/edituserorder')}}";
   //          sendAjax(data,url)
   //      })
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
                             	window.location.reload();
                                //window.location.href="{{url('users/index')}}";
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