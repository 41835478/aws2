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
	body{background-color:#fff;}
	.footer{padding:0;width:100%;height:50px;}		
    .grayBtn{background-color: #999}
    .integralGoods_descript_con img{
        width:100%;}
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
            @foreach($goods->small_pic as $g)
            <div class="swiper-slide">
            	<a class="a_jump" href="javascript:void(0)">
            		<img class="content-banner" src="/{{$g}}" />
        		</a>
        	</div>
            @endforeach
            {{--<div class="swiper-slide">
            	<a class="a_jump" href="javascript:void(0)">
            		<img class="content-banner" src="/home/images/integralDetail.png" />
        		</a>
        	</div>
        	<div class="swiper-slide">
            	<a class="a_jump" href="javascript:void(0)">
            		<img class="content-banner" src="/home/images/integralDetail.png" />
        		</a>
        	</div>--}}
        </div>
        <!-- 如果需要分页器 -->
        <div class="swiper-pagination lf_page"></div>
    </div>
    <div class="integralDetal">
        <div class="integralGoods">
            <p>{{$goods->name}}</p>
            <p>
                <em>{{$goods->money}}</em><span>积分</span>
            </p>
        </div>
        <div onclick="javascript:window.location.href='/users/toaddress'" class="div_clearFloat integralAddress">
            <p>配送至：</p>
            <div class="integral-address">
                @if(empty($address))
                <p onClick="location.href='/users/toaddress'">请选择收货地址</p>
                    @else
                    <p>{{$address->province}}-{{$address->city}}-{{$address->area}}-{{$address->address}}</p>
                @endif
            </div>
            <!-- 传入地址-赋值 -->
            <!-- <div class="integral-address">
                <div class="div_clearFloat integral_addcon">
                    <p class="div_left">CR 小杀</p>
                    <h3 class="div_right">17300000000</h3>
                </div>
                <div class="div_clearFloat integral_addcon2">
                    <i class="iconfont icon-dizhi"></i>
                    <p>河南省郑州市金水区MOUMOU小区13号楼一单...</p>
                </div>
            </div> -->
            <i class="iconfont icon-you"></i>
        </div>
        <div style="height:12px;background-color:#f5f5f5;border-top:1px solid #e6e6e6;border-bottom:1px solid #e6e6e6"></div>
        <div class="integralGoods_descript">
            <h2>详情描述</h2>
            <div class="integralGoods_descript_con">
                {!! $goods->content !!}
               {{-- <h3>商品详情：</h3>
                <p>5000mAh 小米移动电源就是薄 仅9.9mm薄,可以放入衬衫兜的移动电源,ATL 锂离子聚合物电芯,铝合金金属外壳。</p>
                <h3>兑换流程：</h3>
                <p>1、用户确认符合活动条件后,点击[马上兑换],并填写配送信息。</p>
                <p>2、确认信息无误,提交兑换。</p>
                <h3>注意事项：</h3>
                <p>兑换时请仔细核对收货信息,商品一经兑换,不支持收货地址和(或)收件人信息修改。</p>--}}
            </div>
        </div>
    </div>
</div>    
<footer class="footer">
    <!-- 积分不足 button class="grayBtn" -->
	<button type="button" class="edit_save">兑换</button>
</footer>
<script type="text/javascript" src="/home/js/handlebars-1.0.0.beta.6.js"></script>
<script type="text/javascript" src="/home/js/index.js"></script> 
<script type="text/javascript">
    //$('.grayBtn').text('积分不足');
    $(".edit_save").on("touchend",function(){
        addBox("body");
        outBox("兑换成功后，请静待收货。如有疑问，请咨询客服。", 'javascript: changeBox();');
    });
    function changeBox() {
        var num = "{{$goods->id}}";
        $.ajax({
            url:'/score/exchange',
            data:{'id':num},
            method:'post',
            success:function(res){
                if(res.status==1){
                    $('#out-boxbg').remove();
                    addBox1("body");
                    outBox1("兑换记录可以在个人中心-消费积分-支出明细中查看。",'/score/index');
                }else{
                    $('#out-boxbg').remove();
                    alert(res.msg)
                }
            },
            error:function(){
                alert('网络错误，请刷新重试！');
            }
        })

    }
    //生成半透明遮罩
    function addBox1(out,zi) {
        if (!zi) {
            zi = 10;
        }
        var box = $("<div></div>");
        box.css({
            "width": "100%",
            "min-height": "100vh",
            "position": "fixed",
            "top": "0",
            "left": "0",
            "background": "rgba(0,0,0,0.4)",
            "zIndex": zi
        });
        box.attr("id", "out-boxbg1");
        if ($(out).css("position") === "static") {
            $(out).css("position", "relative");
        }
        box.on("touchstart", function (e) {
            if (e.target === box[0]) {
                e.preventDefault();
            }
        });
        $(out).append(box);
        return "out-boxbg1";
    }

    //生成弹出框
    function outBox1(news, url) {
        if (!news) {
            news = "";
        }
        if (!url) {
            url = " ";
        }
        //盒子
        var box = $("<div></div>");
        box.css({
            "position": "absolute",
            "top": "24vh",
            "left": "7%",
            "width": "86%",
            "background": "#fff",
            "border-radius": "10px",
            "box-sizing": "border-box",
            "padding": "10px 20px"
        });
        //标题
        var title = $("<h4></h4>");
        title.css({
            "text-align": "center",
            "font-size": "16px",
            "color": "#333",
            "line-height": "2.4em",
            "border-bottom": "1px solid #e6e6e6"
        });
        title.html("商品兑换成功！");
        //内容
        var show = $("<p></p>");
        show.css({
            "text-align": "justify",
            "padding": "1.2em 0",
            "font-size": "15px",
            "line-height": "2em",
            "color": "#333"
        });
        //确认取消
        var btnBox = $("<div></div>");
        btnBox.css({
            "width": "100%",
            "overflow": "hidden",
            "padding-bottom": "10px"
        });
        var btnOk = $("<a></a>");
        btnOk.css({
            "width": "90%",
            "height": "2rem",
            "color": "#fff",
            "background": "#2194eb",
            "border-radius": "3px",
            "border": "1px solid #2194eb",
            "text-align": "center",
            "line-height": "2rem",
            "font-size":"16px",
            "margin":"0 auto",
            "display":"block"
        });
        btnOk.html("积分商城");
        btnOk.attr("href", url);
        show.html(news);
        btnBox.append(btnOk);
        box.append(title);
        box.append(show);
        box.append(btnBox);
        $($("#out-boxbg1")).append(box);
    };
</script>
</body>
</html>