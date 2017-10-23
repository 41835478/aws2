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
<link rel="stylesheet" href="/home/css/index.css"/>
<script type="text/javascript" src="/home/js/swiper.min.js"></script>
<script type="text/javascript" src="/home/js/jquery-3.1.1.min.js"></script>
<style>
	body{
		background-color:#f5f5f5;
	}
	.footer{
		height:50px;
		line-height: 50px;
		border-top: 0;
		padding:0;
		width:100%;
		overflow:hidden;
	}
</style>
</head>
<body>
<div class="container" style="z-index:999;padding-top:40%;display:none;position:fixed;top:0;left:0;right:0;width:100%;height:100%;background:rgba(0,0,0,0.8);text-align:center;font-size:18px;color:#fff;">
	请点击右上角，在浏览器中打开。
	<span id="closeCon" style="position:absolute;top:20px;right:20px;display:block;width:20px;height:20px;line-height:20px;text-align:center;border:2px solid #fff;border-radius:50%">X</span>
</div>
<div class="public_head" style="background-color:#fff">
	<h3 style="color:#333">支付</h3>
	<a style="color:#333" href="javascript:history.go(-1);location.reload()" class="iconfont icon-fanhui"></a>
</div>
<div class="content" style="padding-bottom:50px">
	<div class="pay_orderAmount">
		<span>订单金额</span>
		<p class="pay_amount">
			<span>￥</span>
			<em>{{ $order->total_money }}</em>
		</p>
	</div>
	<ul class="paymentList">
		@if (!empty($is_weixin))
		<li class="paymentItem">
			<img src="/home/images/pay01.png" alt=""/>
			<p>微信支付</p>
			<span class="iconfont icon-weixuanzhong icon-xuanzhong"></span>
		</li>
		@endif
		<li name="alipay" class="paymentItem">
			<img src="/home/images/pay02.png" alt=""/>
			<p>支付宝支付</p>
			<span class="iconfont icon-weixuanzhong" id="zfb"></span>
		</li>
		<li class="paymentItem">
			<img src="/home/images/pay03.png" alt=""/>
			<p>余额支付</p>
			<span class="iconfont icon-weixuanzhong"></span>
			<h2>￥{{ $user->account }}</h2>
		</li>
		@if ($order->fx == 1)
			<li class="paymentItem">
				<img src="/home/images/pay04.png" alt=""/>
				<p>复投积分支付</p>
				<span class="iconfont icon-weixuanzhong"></span>
				<h2 style="width:44%">{{ $user->repeat_points }}</h2>
			</li>
		@endif
	</ul>
</div>
<div class="kuang">
	<div class="pay_pwd_1">
		<div class="pay_pwd_2">
			请输入支付密码<!-- <i class="iconfont icon-chuyidong"></i> -->
		</div>
		<div class="pay_pwd_3">
			<input type="password" value="" class="pay_input pay_input1"  maxlength="1"/>
			<input type="password" value="" class="pay_input pay_input2" maxlength="1"/>
			<input type="password" value="" class="pay_input pay_input3" maxlength="1"/>
			<input type="password" value="" class="pay_input pay_input4" maxlength="1"/>
			<input type="password" value="" class="pay_input pay_input5" maxlength="1"/>
			<input type="password" value="" class="pay_input pay_input6" maxlength="1"/>
		</div>
		<div class="pay_button">
			<button class="payBtn-l">取消</button>
			<button class="payBtn-r" ftjf="2">确定</button>
		</div>
		<!-- <div class="pay_pwd_4"><a href="modify_pay.html">忘记密码？</a></div> -->
	</div>
	<div class="pay_pwd_5">
		<div class="pay_pwd_6"><i class="iconfont icon-xialajiantou"></i></div>
		<div class="pay_jp">
			<span>1</span><span>2</span><span>3</span>
			<span>4</span><span>5</span><span>6</span>
			<span>7</span><span>8</span><span>9</span>
			<span></span><span>0</span><span class="iconfont icon-shuzijianpanshanchu"></span>
		</div>
	</div>
</div>
<footer class="footer">
	<button type="button" class="edit_save">立即支付</button>

</footer>
<script type="text/javascript" src="/home/js/js_sdk20170302.js"></script>
<script>
	$('#closeCon').on('touchend',function(){
		$('.container').fadeOut(300);
	})
$(".present_centt").on("click", function (){
      $(".present_centt").find('.present_i').removeClass('icon-xuanzhong');
      $(this).find('.present_i').addClass("icon-xuanzhong");
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
     $(function(){  
        $(".present_centt").click(function(){ 
           $(".present_centt").find('.present_i').removeClass('icon-xuanzhong');
           $(this).find('.present_i').addClass("icon-xuanzhong");
            var index=$(".present_centt").index(this);  
            $(".present_final").hide().eq(index).show();  
        });  
    });
     var j = 0;
	var k;
	$(".pay_jp span").click(function() {
		if($(this).index()!=9 && $(this).index()!=11){
			var i = parseInt($(this).text());
			if(j==0){
				$(".pay_input1").val(i);
				j++;
				k = j;
			}else if(j==1){
				$(".pay_input2").val(i);
				j++;
				k = j;
			}else if(j==2){
				$(".pay_input3").val(i);
				j++;
				k = j;
			}else if(j==3){
				$(".pay_input4").val(i);
				j++;
				k = j;
			}else if(j==4){
				$(".pay_input5").val(i);
				j++;
				k = j;
			}else if(j==5){
				$(".pay_input6").val(i);
				k = j + 1;
				//window.location.href="myAccount.html?type=1"
			}
		}
		if($(this).index() == 11){
			if(k==0){
			}else{
				$(".pay_input").eq(k-1).val("");
				k--;
				j = k;
			}	
		};
	});
	var flag = true;
	$(".pay_pwd_6").click(function() {
		if(flag){
			$(".pay_pwd_5").animate({
				bottom: "-180px",
			});
			flag = false;
		}else{
			$(".pay_pwd_5").animate({
				bottom: "0px",
			});
			flag = true;
		}
	});

	$(".payBtn-l").click(function() {
		$(".kuang").hide();
		$(".pay_pwd_5").hide();
	});
	//确认按钮
	$(".payBtn-r").click(function() {
		$(".kuang").hide();
		$(".pay_pwd_5").hide();
		// window.location.href = 'paySuccess.html';
		var password = $('.pay_input1').val()+$('.pay_input2').val()+$('.pay_input3').val()+$('.pay_input4').val()+$('.pay_input5').val()+$('.pay_input6').val();
		// console.log(password);
		if($(this).attr('ftjf') == 2){
			order_pay(password);
		}else if($(this).attr('ftjf') == 1){
			recash_point(password);
		}

	});
	$(".edit_save").click(function(){
		var type = $('.icon-xuanzhong').prev().text();
		if(type == '支付宝支付'){
			var order_id = location.search.split('=')[1];
			if(is_kingkr_obj()){
				$.ajax({
					'url':'{{url("wxAppPay/sendRequest")}}',
					'data':{'id':order_id},
					'async':true,
					'type':'get',
					'dataType':'json',
					success:function(res){
						if(res.status){
							payType(res.data,'ALIPAY','payResult');
						}else{
							alert(res.message);
						}
					}
				})
			}else{
				var judge = "{{ $is_weixin }}";
				if(!judge){
					var url = "{{config('home.WEB')}}"+"/alipay/index?order_id="+order_id
					// return false;
					window.location.href=url;
				}
			}

		}else if(type == '微信支付'){
			var order_id = location.search.split('=')[1];
			if(is_kingkr_obj()){
				$.ajax({
					'url':'{{url("wxAppPay/sendRequest")}}',
					'data':{'id':order_id},
					'async':true,
					'type':'get',
					'dataType':'json',
					success:function(res){
						if(res.status){
							payType(res.data,'WEIXIN','wxPayResult');
						}else{
							alert(res.message);
						}
					}
				})
			}else{
				window.location.href="{{config('home.WEB')}}"+"/wxpay/index?order_id="+order_id;
			}
		}else if(type == '余额支付'){
			$(".kuang").show();
			$(".pay_pwd_1").show();
			$(".pay_pwd_5").show();
			$('.payBtn-r').attr('ftjf','2');
		}else if(type == '复投积分支付'){
			$(".kuang").show();
			$(".pay_pwd_1").show();
			$(".pay_pwd_5").show();
			$('.payBtn-r').attr('ftjf','1');
		}
	});
	//微信app支付回调
	function wxPayResult(r) {
		if(r == 0){
			setTimeout(function(){
				alert('支付成功！');
			}, 2000);
		}else{
			setTimeout(function(){
				alert('支付失败请刷新后再试！');
			}, 2000);
		}
	}

	//支付宝app支付回调
	function payResult(r) {
		if(r == 9000){
			setTimeout(function(){
				alert('支付成功！');
				window.location.href="{{url('users/index')}}";
			}, 1000);
		}else{
			setTimeout(function(){
				alert('支付失败请刷新后再试！');
			}, 2000);
		}
	}
</script>
<script type="text/javascript">
    $(".paymentItem").on("touchstart", function (){
		var x = $(this).attr('name');
		if(x=='alipay'){
			var type = "{{ $is_weixin }}";
			if(type == 1){
				$('.container').fadeIn(300);
			}
		}
        $(".paymentItem").find('span').removeClass('icon-xuanzhong');
        $(this).find('span').addClass("icon-xuanzhong");
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

    function order_pay(password){
    	var order_id = location.search.split('=')[1];
    	$.ajax({
    		url : '/shop/order_pay',
    		type : 'post',
    		data : {
    			order_id : order_id,
    			password : password
    		},
    		success : function(res){
    			if(res == 3){
    				alert('余额不足');
    			}else if(res == 2){
    				alert('密码错误');
    			}else{
    				alert('支付成功');
    				window.location.href = '/shop/paySuccess';
    			}
    		}
    	})
    }

    function recash_point(password)
	{
		var order_id = location.search.split('=')[1];
		$.ajax({
			url:'{{url("/shop/recash_point")}}',
			type:'post',
			data:{'order_id':order_id,'password':password,'_token':"{{csrf_token()}}"},
			success:function(data){
				if(data == 3){
					alert('复投积分只能购买点位');
				}else if(data == 2){
					alert('支付密码错误');
				}else if(data==4){
					alert('复投积分不足');
				}else{
					alert('支付成功');
					window.location.href = '/shop/paySuccess';
				}
			},
			error:function(){
				alert('Ajax响应失败');
			}
		})
	}
</script>
</body>
</html>