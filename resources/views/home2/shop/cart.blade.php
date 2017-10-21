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
<link rel="stylesheet" href="/home/css/swiper.min.css"/>
<link rel="stylesheet" type="text/css" href="/home/font/iconfont.css"/>
<link rel="stylesheet" href="/home/css/common.css"/>
<link rel="stylesheet" href="/home/css/fly.css">
<script type="text/javascript" src="/home/js/fly.js"></script>
<script type="text/javascript" src="/home/js/swiper.min.js"></script>
<script type="text/javascript" src="/home/js/jquery-3.1.1.min.js"></script>
<style>
	body{
		background-color:#f5f5f5;
	}
	.public_head{
		background: white;
	}
	.public_head h3{
		color: black;
	}
	.public_head span{
		color: black;
	}
	.content{
		padding-bottom: 110px;
	}
	input{
		border:0;
		background: 0
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>购物车</h3>
	<span class="right">编辑</span>
</div>
<!-- 内容区 -->
<div class="content">
   <!--  编辑 -->
	<div class="cart_edit" >
		<div class="cart_single">
			<div class="cart_single_head">
				<i class="cart_cd cart_he cart_i iconfont icon-weixuanzhong"></i>
				<p>排单商品</p>
				<i class="iconfont icon-xiala pai_xl"></i>
				<p class="cart_po"><em class="pai_num">1</em>件</p>
			</div>
			@foreach ($cart as $v)
				@if	($v->type == 1)
			<div class="pai_single">
				<div class="cart_single_cont cart_single_conto" cart_id="{{ $v->id }}">
					<i class="cart_d cart_i cart_f iconfont icon-weixuanzhong"></i>
					<img onclick="javascript:window.location.href='/shop/goodsDetail?id={{ $v->goods_id }}'" src="{{ asset($v->goods->pic) }}" alt="">
					<div class="cart_bj" >
						<div class="cart_single_box">
							<p class="cart_pt">{{ $v->goods->name }}</p>
							<p class="cart_ps"><span>￥</span><em class="cart_univalent">{{ $v->goods->price }}</em></p>
						</div>
						<p class="cart_pn">x<em class="cart_num">{{ $v->num }}</em></p>
					</div>
					<div class="cart_wc" style="display: none;">
						<div class="cart_finish_box">
							<div class="cart_finish_btnbox">
								<input type="button" value="-" class="jian">
								<input type="text" value="{{ $v->num }}" cart_id="{{ $v->id }}" class="cart_ber">
								<input type="button" value="+" class="add">
							</div>
							<p class="cart_ps"><span>￥</span><em class="cart_univalent">{{ $v->goods->price }}</em></p>
						</div>
					</div>
				</div>
			</div>
				@endif
			@endforeach
		</div>
		<div class="cart_single">
			<div class="cart_single_head">
				<i class="cart_cn cart_he cart_i iconfont icon-weixuanzhong"></i>
				<p>普通商品</p>
				<i class="iconfont icon-xiala pu_xl"></i>
				<p class="cart_po"><em class="pu_num">2</em>件</p>
			</div>
			<div class="pu_single">
				@foreach ($cart as $v)
					@if	($v->type == 2)
				<div class="cart_single_cont cart_single_contt" cart_id="{{ $v->id }}">
					<i class="cart_n cart_i cart_f iconfont icon-weixuanzhong"></i>
					<img onclick="javascript:window.location.href='/shop/goodsDetail?id={{ $v->goods_id }}'" src="{{ asset($v->goods->pic) }}" alt="">
					<div class="cart_bj" style="display: block">
						<div class="cart_single_box">
							<p class="cart_pt">{{ $v->goods->name }}</p>
							<p class="cart_ps"><span>￥</span><em class="cart_univalent">{{ $v->goods->price }}</em></p>
						</div>
						<p class="cart_pn">x<em class="cart_num">{{ $v->num }}</em></p>
					</div>
					<div class="cart_wc" style="display: none;">
						<div class="cart_finish_box">
							<div class="cart_finish_btnbox">
								<input type="button" value="-" class="jian">
								<input type="text" value="{{ $v->num }}" cart_id="{{ $v->id }}" class="cart_ber">
								<input type="button" value="+" class="add">
							</div>
							<p class="cart_ps"><span>￥</span><em class="cart_univalent">{{ $v->goods->price }}</em></p>
						</div>
					</div>
				</div>
					@endif
				@endforeach

		</div>
		<div class="cart_foot cart_footo">
			<i class="cart_all iconfont icon-weixuanzhong"></i>
			<p>合计：<span><em>￥</em><i class="cart_mount">0.00</i></span></p>
			<button type="button" onclick="javascript:submitOrders();">结算（<em class="cart_fom">0</em>）</button>
	    </div>
	    <div class="cart_foot cart_foott" style="display: none">
			<i class="cart_all iconfont icon-weixuanzhong"></i>
			<p>全选</p>
			<button type="button" class="cart_del">删除</button>
	    </div>
	</div>	
</div>

<footer class="footer">
	<div class="footerCon">
		<a href="/" class="a_jump">
			<img src="/home/images/icon-1.png" alt=""/>
			<span class="footerlist-cn">首页</span>
		</a>
		<a href="/shop/cart" class="a_jump footerOn">
			<img src="/home/images/icon-22.png" alt=""/>
			<span class="footerlist-cn">购物车</span>
		</a>
		<a class="a_jump person_b" href="{{url('users/qrcode')}}">
			<img src="/home/images/icon-3.png" alt=""/>
			<span class="footerlist-cn">二维码</span>
		</a>
		<a class="a_jump person_c" href="/users/index">
			<img src="/home/images/icon-4.png" alt=""/>
			<span class="footerlist-cn">我的</span>
		</a>
	</div>
</footer>
<script>
    //下拉
    $(".pai_xl").on("click",function(){
    	$(this).toggleClass("icon-shang")
    	$(".pai_single").slideToggle();
    })
    $(".pu_xl").on("click",function(){
    	$(this).toggleClass("icon-shang")
    	$(".pu_single").slideToggle();
    })

	$(document).ready(function(){
		//加的效果
		$(".add").click(function(){
			var n=$(this).prev().val();
			var id = $(this).prev().attr('cart_id');
			var num=parseInt(n)+1;
			if(num==0){ return;}
			if(num > 5){ return;}
			$(this).prev().val(num);
			$(this).parent().parent().parent().siblings().children().find(".cart_num").html(num);
			cartEdit(id,num);
		});
		//减的效果
		$(".jian").click(function(){
			var n=$(this).next().val();
            var id = $(this).next().attr('cart_id');
			var num=parseInt(n)-1;
			if(num==0){ return}
			$(this).next().val(num);
			$("cart_num").html(10);
            cartEdit(id,num);
		});
	})
    function cartEdit(id,num){
        $.ajax({
			url : '/shop/cartEdit',
			type : 'get',
			data : {
			    id : id,
				num : num
			},
			success:function(res){
				if(res==501){
					alert('该专区商品每天只能限购10次');
				}
			}
		})
	}
	var oPai=$(".cart_single_conto").length;
	var oPu=$(".cart_single_contt").length;
	$(".pai_num").html(oPai);
	$(".pu_num").html(oPu);
	//删除
	$(".cart_del").on("click",function(){
	    var xz = $(".icon-selected:not(.cart_he)").parent();
	    if(xz.length <= 0){
	        return false;
		}
	    var xz_arr = '';
	    for(var i = 0;i < xz.length;i++){
	        xz_arr += ','+xz[i].attributes[1].value;
		}
        $.ajax({
            url : '/shop/cartDel',
            type : 'get',
            data : {
                xz_arr : xz_arr,
            },
			success : function(res){
//                console.log(res);
                if(res > 0){
                    $(".icon-selected:not(.cart_he)").parent().remove();
                    var oPai=$(".cart_single_conto").length;
                    var oPu=$(".cart_single_contt").length;
                    $(".pai_num").html(oPai);
                    $(".pu_num").html(oPu);
				}
			}
        })

	})

	function submitOrders(){
        var xz = $(".icon-selected:not(.cart_he)").parent();
        if(xz.length <= 0){
            return false;
        }
        var xz_arr = '';
        for(var i = 0;i < xz.length;i++){
            xz_arr += ','+xz[i].attributes[1].value;
        }
        xz_arr = xz_arr.substr(1);

		$.ajax({
			'url':"{{url('shop/judgeLimitPay')}}",
			'data':{'cart_id':xz_arr},
			'type':'get',
			'async':true,
			'dataType':'html',
			success:function(res){
				if(res==501){
					alert('该专区商品每天只能限购10次');
				}else{
					location.href="/shop/submitOrders?cart_id="+xz_arr;
				}
			}
		})

        location.href="/shop/submitOrders?cart_id="+xz_arr;
	}
	 //编辑
    $(".right").click(function(){ 
      	  $(".cart_i").removeClass("icon-selected");  
      	  $(".cart_mount").html("0.00");
		  $(".cart_fom").html("0"); 
	      if($(".right").text()=="编辑"){   
	          $(".right").text("完成");
	          $(".cart_bj").hide();
	          $(".cart_wc").show();
	          $(".cart_footo").hide();
	          $(".cart_foott").show();
	      }else if($(".right").text()=="完成"){
	          $(".right").text("编辑");
	          $(".cart_wc").hide();
	          $(".cart_bj").show();
	          $(".cart_foott").hide();
	          $(".cart_footo").show();
	          window.location.reload();
	      }
    })
    //单选
    $(".cart_i").on("click",function(){
    	$(this).toggleClass("icon-selected");
    	if ($('.cart_i').length == $('.icon-selected').length) {
	        $('.cart_all').addClass('icon-xuanzhong');
	    } else {
	        $('.cart_all').removeClass('icon-xuanzhong');
	    };
	    var zh=[];var number=[];var mon=[];
        var zj=$(".icon-selected:not(.cart_he)").map(function(){
	          var dj=$(this).siblings().children().find(".cart_univalent").html();
	          var num=$(this).siblings().children().find(".cart_num").html();
	          var count=dj * num;
	          zh.push(dj)
	          number.push(num);
	          mon.push(count)
       })
       var counts=eval(mon.join('+'));
       var len=$(".icon-selected:not(.cart_he)").length;
       if (!counts) {
          counts = "0.00";
       } else {
        counts=counts.toFixed(2);
       }
       $(".cart_mount").html(counts);
	   $(".cart_fom").html(len);    
	   
    })
    $(".cart_d").on("click",function(){
    	if ($('.cart_d').length == $('.icon-selected').length) {
	        $('.cart_cd').addClass('icon-xuanzhong');
	    } else {
	        $('.cart_cd').removeClass('icon-xuanzhong');
	    };
    })
    $(".cart_n").on("click",function(){
    	if ($('.cart_n').length == $('.icon-selected').length) {
	        $('.cart_cn').addClass('icon-xuanzhong');
	    } else {
	        $('.cart_cn').removeClass('icon-xuanzhong');
	    };
    })
    //全选
    $(".cart_all").on("click",function(){
    	$(this).toggleClass("icon-xuanzhong");
    	if($(this).hasClass("icon-xuanzhong")){
    		$(".cart_i").addClass("icon-selected");
    		var len=$(".icon-selected:not(.cart_he)").length;
    		$(".cart_fom").html(len);
    		var zh=[];var number=[];var mon=[];
	        var zj=$(".icon-selected:not(.cart_he)").map(function(){
		          var dj=$(this).siblings().children().find(".cart_univalent").html();
		          var num=$(this).siblings().children().find(".cart_num").html();
		          var count=dj * num;
		          zh.push(dj)
		          number.push(num);
		          mon.push(count)
	       })
	       var counts=eval(mon.join('+'));
	       counts=counts.toFixed(2);
	       $(".cart_mount").html(counts);
    	}else{
    		$(".cart_i").removeClass("icon-selected");
    		$(".cart_fom").html("0");
    		$(".cart_mount").html("0.00");
    	}
    	
    })
    //排单全选
    $(".cart_cd").on("click",function(){
    	if($(this).hasClass("icon-selected")){
    		$(".cart_d").addClass("icon-selected");
    		var len=$(".icon-selected:not(.cart_he)").length;
    		$(".cart_fom").html(len);
    		var zh=[];var number=[];var mon=[];
	        var zj=$(".icon-selected:not(.cart_he)").map(function(){
		          var dj=$(this).siblings().children().find(".cart_univalent").html();
		          var num=$(this).siblings().children().find(".cart_num").html();
		          var count=dj * num;
		          zh.push(dj)
		          number.push(num);
		          mon.push(count)
	       })
	       var counts=eval(mon.join('+'));
	       counts=counts.toFixed(2);
	       $(".cart_mount").html(counts);
    	}else{
    		$(".cart_d").removeClass("icon-selected");
    		var len=$(".icon-selected:not(.cart_he)").length;
    		$(".cart_fom").html(len);
    		var zh=[];var number=[];var mon=[];
	        var zj=$(".icon-selected:not(.cart_he)").map(function(){
		          var dj=$(this).siblings().children().find(".cart_univalent").html();
		          var num=$(this).siblings().children().find(".cart_num").html();
		          var count=dj * num;
		          zh.push(dj)
		          number.push(num);
		          mon.push(count)
	       })
	       var counts=eval(mon.join('+'));
	       if (!counts) {
	          counts = "0.00";
	       } else {
	        counts=counts.toFixed(2);
	       }
	       $(".cart_mount").html(counts);
    	}
    	if ($('.cart_i').length == $('.icon-selected:not(.cart_he)').length) {
	        $('.cart_all').addClass('icon-xuanzhong');
	    } else {
	        $('.cart_all').removeClass('icon-xuanzhong');
	    };
    })
    //普通全选
     $(".cart_cn").on("click",function(){
    	if($(this).hasClass("icon-selected")){
    		$(".cart_n").addClass("icon-selected");
    		var len=$(".icon-selected:not(.cart_he)").length;
    		$(".cart_fom").html(len);
    		var zh=[];var number=[];var mon=[];
	        var zj=$(".icon-selected:not(.cart_he)").map(function(){
		          var dj=$(this).siblings().children().find(".cart_univalent").html();
		          var num=$(this).siblings().children().find(".cart_num").html();
		          var count=dj * num;
		          zh.push(dj)
		          number.push(num);
		          mon.push(count)
	       })
	       var counts=eval(mon.join('+'));
	       counts=counts.toFixed(2);
	       $(".cart_mount").html(counts);
    	}else{
    		$(".cart_n").removeClass("icon-selected");
    		var len=$(".icon-selected:not(.cart_he)").length;
    		$(".cart_fom").html(len);
    		var zh=[];var number=[];var mon=[];
	        var zj=$(".icon-selected:not(.cart_he)").map(function(){
		          var dj=$(this).siblings().children().find(".cart_univalent").html();
		          var num=$(this).siblings().children().find(".cart_num").html();
		          var count=dj * num;
		          zh.push(dj)
		          number.push(num);
		          mon.push(count)
	       })
	       var counts=eval(mon.join('+'));
	       if (!counts) {
	          counts = "0.00";
	       } else {
	        counts=counts.toFixed(2);
	       }
	       $(".cart_mount").html(counts);
    	}
    	if ($('.cart_i').length == $('.icon-selected:not(.cart_he)').length) {
	        $('.cart_all').addClass('icon-xuanzhong');
	    } else {
	        $('.cart_all').removeClass('icon-xuanzhong');
	    };
    })
     $(".cart_ber").on('input propertychange',function(){
     	var num = $(this).val();
     	$(this).parent().parent().parent().siblings().children().find(".cart_num").html(num);
     });

</script>
</body>
</html>