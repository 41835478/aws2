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
<script type="text/javascript" src="/home/js/zepto.js"></script>
<style>
	body{background-color:#f5f5f5;}
	.footer{padding:0;width:100%;height:50px;}	
    .goodsDetail-img{overflow:hidden;}
	.goodsDetail-img img{display:block;max-width:100%;margin:0 auto;}
</style>
</head>
<body>
<div class="public_head" style="background-color:#fff">
    <h3 style="color:#333">商品详情</h3>
    <a style="color:#333" href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="content" style="padding-bottom:50px;">
	<!-- banner -->
	 <div class="swiper-container index-banner">
        <div class="swiper-wrapper">
            @foreach ($goods->small_pic as $v)
            <div class="swiper-slide">
            	<a class="a_jump" href="javascript:void(0)">
            		<img class="content-banner" src="{{ asset($v) }}" />
        		</a>
        	</div>
            @endforeach
        </div>
        <!-- 如果需要分页器 -->
        <div class="swiper-pagination lf_page"></div>
    </div>
    <div class="goodsDetail">
        <div class="goodsProperty">
            <p class="goodsPrice">
                <em>￥</em><span>{{ $goods->price }}</span>
            </p>
            <div class="goodsNum">
                <p>件数：</p>
                <div class="goodsNumselect">
                    <i class="iconfont icon-jianshao"></i>
                    <span id="goods_num">1</span>
                    <i class="iconfont icon-jia"></i>
                </div>
                
            </div>
        </div>
        <div class="goodsDescript">
           <p>{{ $goods->title }}</p>
        </div>
    </div>
    <div class="goodsDetailcon">
        <h2 class="goodsDetailtitle">商品详情</h2>
        <div class="goodsDetail-img">
            {!! $goods->content !!}
            {{--<img src="/home/images/detail.png" alt=""/>--}}
        </div>
    </div>
</div>
<div class="goodsCarSuccess">
    <img src="/home/images/icon_duihao.png" alt=""/>
    <h2>添加购物车成功！</h2>
</div>
<footer class="footer">
	<div class="goodsBtns">
        <button type="button" class="jionCar">加入购物车</button>
        <button id="purchase" type="button">立即购买</button>
    </div>
</footer>
<script type="text/javascript" src="/home/js/handlebars-1.0.0.beta.6.js"></script>
<script type="text/javascript" src="/home/js/index.js"></script> 
<script type="text/javascript">
    /*加入购物车*/
    $('.jionCar').on("touchstart",function(){
        var goods_id = "{{ $goods->id }}"
        var num = $('#goods_num').text();
        $.ajax({
            url : '/shop/addCart',
            type : 'get',
            data : {
                goods_id : goods_id,
                num : num
            },
            success : function(res){
                console.log(res);
                if(res == 1){
                    $('.goodsCarSuccess').fadeIn(300,function(){
                        if(confirm("是否前往购物车？")){
                            setTimeout(function(){
                                $('.goodsCarSuccess').fadeOut(300);
                                window.location.href = '/shop/cart';
                            },1000);
                        }else{
                            setTimeout(function(){
                                $('.goodsCarSuccess').fadeOut(300);
                            },1000);
                        }
                    });
                }else if(res==501){
                    alert('该专区商品每天只能限购10次');
                }else if(res==503){
                    alert('请先去登录平台，才能购物');
                    location.href='/register/index';
                }else{
                    alert('加入购物车失败');
                }
            }
        });
    });
    //加减
    $('.goodsNumselect').find('.icon-jia').on('click',function(){
        var a = parseInt($(this).siblings('span').text());
        if(a >= 5){ return;}
        a++;
        $(this).siblings('span').text(a);
    });
    $('.goodsNumselect').find('.icon-jianshao').on('click',function(){
        var b = parseInt($(this).siblings('span').text());
        if(b>1){
            b--;
            $(this).siblings('span').text(b);
        }else{
            $(this).parent().find('span').text('1');
        }
        
    });
    //拍单商品vs普通商品
    $('#purchase').on('click',function(){
        var goods_id = {{ $goods->id }}
        var num = $('#goods_num').text();
        $.ajax({
            'url':"{{url('shop/judgeLimitPay')}}",
            'data':{'num':num,'goods_id':goods_id},
            'type':'get',
            'async':true,
            'dataType':'html',
            success:function(res){
                if(res==501){
                    alert('该专区商品每天只能限购10次');
                }else{
                    window.location.href='/shop/submitOrders?goods_id='+goods_id+'&num='+num;
                }
            }
        })
        window.location.href='/shop/submitOrders?goods_id='+goods_id+'&num='+num;
    })
</script>
</body>
</html>