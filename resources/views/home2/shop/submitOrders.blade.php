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
	.submitAddress>.div_right {
	    width: 75%;
	    float: left;
	    margin-left: 10px;
        margin-top: 2px;
	}
	.submit_consignee>p.div_left {
	    width: 52%;
	    overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
	}
	.icon-iconfontright{
		margin-top: 5px;
		color: #999;
		float: right;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>确认订单</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="content" style="padding-bottom:50px">
	<div class="div_clearFloat submitAddress">
		<p style="font-size:16px;color:#999;float:left">配送至</p>
		<div class="div_right">
			<div class="submit_consignee">
				<p class="div_left">收货人：{{ $address->name }}</p>
				<p class="div_right">{{ $address->phone }}</p>
			</div>
			<p class="submitAddress-con">
				<i class="iconfont icon-dizhi"></i>{{ $address->province }}{{ $address->city }}{{ $address->area }}{{ $address->address }}
			</p>
		</div>
		<i class="iconfont icon-iconfontright"></i>
	</div>
	<div class="submitLine"></div>
	<div class="submitGoods">
		<div class="submitGoods-box">
			@if (!empty($cart))
				@foreach ($cart as $v)
				<div class="div_clearFloat submitGoodscon">
					<img src="{{ asset($v->goods->pic) }}" alt=""/>
					<div class="div_right submitGoodsTitle">
						<p>{{ $v->goods->name }}</p>
						<div class="submitNum">
							<p class="div_left">￥{{ $v->goods->price }}</p>
							<p class="div_right">x {{ $v->num }}</p>
						</div>
					</div>
				</div>
				@endforeach
			@else
				<div class="div_clearFloat submitGoodscon">
					<img src="{{ asset($goods->pic) }}" alt=""/>
					<div class="div_right submitGoodsTitle">
						<p>{{ $goods->name }}</p>
						<div class="submitNum">
							<p class="div_left">￥{{ $goods->price }}</p>
							<p class="div_right">x {{ $goods->paynum }}</p>
						</div>
					</div>
				</div>
			@endif
		</div>
		<div class="submitGoodsamount">
			<p class="div_left">商品总额</p>
			<p class="div_right">￥{{ $all_money }}</p>
		</div>
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
</div>
<footer class="footer">
	<div class="submitOrder">
		<p class="submitPrice">
			<span>订单金额：</span>
			<span style="color:#f79f00;font-size:14px;">￥<em style="font-size:18px;">{{ $all_money }}</em></span>
		</p>
		<button id="submitOrderBtn" type="button" class="submitPay">提交订单</button>
	</div>
</footer>
<script type="text/javascript">
	$('.submitAddress-con').on('click',function(){
		if(confirm('是否更换地址？')){
			window.location.href='/users/shippingaddress?gh=1';
		}
	});
	$('#submitOrderBtn').on('click',function(){
		window.location.href='/home2/shop/payment';

	});
</script>
</body>
</html>