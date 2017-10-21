
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
	body{background-color: #f5f5f5}
	.footer{width:100%;padding:0;height:50px;}
	.goodsBtns>button:nth-child(1){background: #f5fbff;color:#2194eb;border:1px solid #2194eb;}
</style>
</head>
<body>
<div class="public_head" style="background-color:#fff">
	<h3 style="color:#333">订单详情</h3>
	<a style="color:#333" href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="obligation_box"></div>
<div class="obligation_main" style="padding-bottom:50px;">
		<div class="obligation_main_top">
			<p>订单编号：{{$list['order_code']}} <span> @if($list['status']==1)待付款
														@elseif($list['status']==2)待发货
														@elseif($list['status']==3)待收货
														@elseif($list['status']==4)已完成
														@endif

												</span></p>
		</div>
		<div class="obligation_main_cont">
			<i class="iconfont icon-dizhi"></i>
			<p class="obligation_ps">收件人：{{$list['name']}} <span>电话：{{$list['phone']}}</span></p>
			<p class="obligation_pn">{{$list['province']}}{{$list['city']}}{{$list['area']}}{{$list['address']}}</p>
		</div>
		@foreach($list->info as $v)
		<div class="obligation_main_center">
			<div class="obligation_main_centero">
				<div class="obligation_main_centero_left">
					<img src="/{{$v['pic']}}" alt="">
				</div>
				<div class="obligation_main_centero_right">
					<p class="obligation_po">{{$v['name']}}</p>
					<p class="obligation_pt">¥{{$v['price']}} <span>x{{$v['num']}}</span></p>
				</div>
			</div>
		</div>
		@endforeach
		<div class="obligation_main_bottom" style="margin-bottom:0">
			<p>合计<span>¥{{$list['total_money']}}</span></p>			
		</div>
	<!-- 	<div class="obligation_main_bottom" style="margin-top:0">
			<p>运单编号<span style="color:#999"> 暂无</span></p>	 	
		</div> -->
</div>
<footer class="footer">


 @if($list['status']==1)
		<div class="goodsBtns">
			<input type="hidden" name="type" value="1" class="type">
			<input type="hidden" name="id" value="{{$list['id']}}" class="id">
		<button type="button"  id="btn1" class="jionCar true">取消订单</button>
	    <button type="button" onclick="javascript:window.location.href='/shop/payment?order_id={{$v['order_code']}}'">付款</button>
	    </div>
@elseif($list['status']==2)
			<input type="hidden" name="type" value="2" class="type">
			<input type="hidden" name="id" value="{{$list['id']}}" class="id">
		<button type="button" id="btn1" class="edit_save true">提醒发货</button>
@elseif($list['status']==3)
			<input type="hidden" name="type" value="3" class="type">
			<input type="hidden" name="id" value="{{$list['id']}}" class="id">
		<button type="button" id="btn1" class="edit_save true">确认收货</button>
@elseif($list['status']==4)
		<button onclick="javascript:window.location.href='/shop/index'" type="button" class="edit_save">再来一单</button>
@endif

</footer>
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
            var type=$('.type').val();
          
            var id=$('.id').val();
            var data={
                'type':type,
               
                'id':id,
               
            }
            var url="{{url('users/edituserorder')}}";
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