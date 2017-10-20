
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
<script type="text/javascript" src="{{asset('home/js/fly.js')}}"></script>
<link rel="stylesheet" href="{{asset('home/css/main.css')}}">	
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>

<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>

<style>
	.public_head{
		background: #ff6253;
		border: none;
	}
	.big-box{
		width: 100%;
		height: 100vh;
	}
    canvas{
        display: none;
    }
    #img{ display: block; width: 100%; height: auto; }
</style>



</head>
<body>
<!-- 内容区 -->

<div class="big-box">
    <div class="public_head">
		<h3>二维码</h3>
        <a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
	</div>


    <img src="" id="img" />

<footer class="footer">
    
<div class="footerCon">
        <a href="/" class="a_jump">
            <img src="{{asset('home/images/icon-1.png')}}" alt=""/>
            <span class="footerlist-cn">首页</span>
        </a>
        <a href="{{url('shop/cart')}}" class="a_jump">
            <img src="{{asset('home/images/icon-2.png')}}" alt=""/>
            <span class="footerlist-cn">购物车</span>
        </a>
        @if($users['level']==1)
        <a href="{{url('users/qrcode')}}" class="a_jump footerOn">
            @else
        <a href="javascript:void(0);" class="a_jump  ">
        @endif
            <img src="{{asset('home/images/icon-3.png')}}" alt=""/>
            <span class="footerlist-cn">二维码</span>
        </a>

    
        <a href="{{url('users/index')}}" class="a_jump ">
            <img src="{{asset('home/images/icon-44.png')}}" alt=""/>
            <span class="footerlist-cn">我的</span>
        </a>
    </div>

</footer>
</div>



<script type="text/javascript">
	var data={
	    "name":"{{$users['name']}}",
	    "image":["{{asset('home/images/QRbg.png')}}","{{$users['pic']}}","{{url('users/createqrcode')}}"]
        },imgPath;
    $(".person_c").on("click",function(){
        addBox("body");
        outBoxx("查看个人中心需先下载APP在APP端进行查看，是否现在下载？","personalCenter.html");
     })
</script>
<script>   

function draw(){
    var mycanvas=document.createElement('canvas');
    $(".big-box").append(mycanvas);
    var len=data.image.length;
    mycanvas.width=screen.width;
    mycanvas.height=screen.height;

    // 文字
    var left0 = screen.width * 0.43;
    var top0 = screen.height * 0.247;
    // 头像
    var left1 = screen.width * 0.42;
    var top1 = screen.height * 0.105;
    var x1 = screen.width * 0.17;
    var y1 = screen.width * 0.17;
    // 二维码
    var left2 = screen.width * 0.295;
    var top2 = screen.height * 0.382;
    var x2 = screen.width * 0.41;
    var y2 = screen.height * 0.25;
    // logo
    var left3 = screen.width * 0.47;
    var top3 = screen.height * 0.30;
    var x3 = screen.width * 0.06;
    var y3 = screen.height * 0.03;

    if(mycanvas.getContext){
        var context=mycanvas.getContext('2d');
        drawing(0);
        // 宣传图片
        var h=0;
        function drawing(num){
            // console.log(num);
            if(num<3){
                var img = new Image;
                img.src = data.image[num];
                if(num==0){
                    // 背景
                    img.onerror=function(){
                        h=140;
                    }
                    img.onload=function(){
                        context.drawImage(img,0,0,screen.width,screen.height);
                        setTimeout(function () {
                            drawing(num+1);
                        },200);
                    }
                }else if(num==1){
                    // 头像
                    img.onload=function(){
                        context.drawImage(img,left1,top1,x1,y1);
                        context.font='20px 宋体';
                        context.fillStyle='#fff';
                        context.fillText( data.name,left0,top0); 
                        drawing(num+1);
                    }
                }else if(num==2){
                    img.onload=function(){
                        context.drawImage(img,left2,top2,x2,y2);
                        // alert(num+1);
                        drawing(num+1);
                    }
                }else if(num==3){
                    img.onload=function(){
                        context.drawImage(img,left3,top3,x3,y3);
                        drawing(num+1);
                    }
                } 
            }else{
                imgPath= mycanvas.toDataURL("image/jpeg");
               $('#img').attr('src',imgPath);
            }
        }
    }
}

CanvasRenderingContext2D.prototype.roundRect = function (x, y, w, h, r) {
    var min_size = Math.min(w, h);
    if (r > min_size / 2) r = min_size / 2;
    // 开始绘制
    this.beginPath();
    this.moveTo(x + r, y);
    this.arcTo(x + w, y, x + w, y + h, r);
    this.arcTo(x + w, y + h, x, y + h, r);
    this.arcTo(x, y + h, x, y, r);
    this.arcTo(x, y, x + w, y, r);
    this.closePath();
    return this;
}

function convertCanvasToImage(canvas) {  
    //新Image对象，可以理解为DOM  
    var image = new Image();  
    // canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持  
    // 指定格式 PNG  
    image.src = canvas.toDataURL("image/png");  
    return image;  
} 

draw()
</script>
</body>
</html>