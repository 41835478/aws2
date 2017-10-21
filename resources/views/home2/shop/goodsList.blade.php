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
    .index_goodsDetail{margin-bottom:0;}
</style>
</head>
<body>
<div class="public_head">
    <h3>{{ $title }}</h3>
    <a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="content" style="padding-bottom:12px">
    <div style="height:12px;border-bottom:1px solid #e6e6e6;"></div>
    <!-- goodsDetail -->
    <div class="index_goods">
         <div class="index_goodsDetail">
            <div class="index_goodsBox">
                <ul class="div_displayFlex goods_yin">
                    @foreach ($goods as $k=>$v)
                        <li class="div_borderBox indexgoodsList">
                            <a href="/home2/shop/goodsDetail?id={{ $v->id }}" class="a_jump">
                                <img class="div_borderBox indexGoodsimg" src="{{ asset($v->pic) }}" alt=""/>
                                <div class="index_price">
                                    <p class="index_con">{{ $v->name }}</p>
                                    <p class="index_priceCon">￥{{ $v->price }}</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/home/js/handlebars-1.0.0.beta.6.js"></script>

</body>
</html>