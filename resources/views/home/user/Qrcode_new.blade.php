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
        <script type="text/javascript" src="/home/js/swiper.min.js"></script>
        <script type="text/javascript" src="/home/js/jquery-3.1.1.min.js"></script>
    </head>
        <style>
            .public_head{
                background: 0;
                border: none;
            }
            .big-box{
                width: 100%;
                height: 100vh;
                   overflow:hidden;
            }
            #img{ display: none; width: 100%; height: auto; }
        </style>    
    <body>
        <!-- 控制页面大小 -->
        <!-- <img class="img1" src="/home/images/loading.gif" /> -->
        <div class="big-box">
            <div class="public_head">
                <h3></h3>
                <a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
            </div>
            <img src="" id="img" />
        </div>
<script type="text/javascript">
    var data={
        "name":"{{$users['name']}}",
        "image":["{{$users['pic']}}","/home/images/Qrbg2.png","{{url('users/createqrcode1')}}"]
        },imgPath;
        $(".person_c").on("click",function(){
            addBox("body");
            outBoxx("查看个人中心需先下载APP在APP端进行查看，是否现在下载？","personalCenter.html");
         })    
    // $.ajax({
    //     url : 'http://ht.xtwhjy.com/home/user/myScanCode',
    //     dataType:'jsonp',
    //     type:"get",
    //     data:{},
    //     async: false,
    //     jsonpCallback:'jsonpReturn',           
    //     success : function(msg){
    //      // console.log(msg);
    //      if(msg.data.headimg == null){
    //          msg.data.headimg = 'http://xtwhjy.com/xt/images/wy_myHeadImg.png';
    //      }
    //         data.name = msg.data.nickname;
    //         data.image[1] = '/http.php?url='+msg.data.headimg;
    //         data.image[2] ='/http.php?url='+'http://ht.xtwhjy.com'+msg.data.qrcode;      
    //         draw(); 
    //     }            
    // });
</script>
<script>   
function draw(){
    var mycanvas=document.createElement('canvas');
    $(".big-box").append(mycanvas);
    var len=data.image.length;
    mycanvas.width=screen.width;
    mycanvas.height=screen.height;
      // 文字
       var left0 = screen.width * 0.35;
       var right0 = screen.width * 0.35;
       var top0 = screen.height * 0.315;
       // 头像
       var left1 = screen.width * 0.39;
       var top1 = screen.height * 0.142;
       var x1 = screen.width * 0.23;
       var y1 = screen.width * 0.24;
       // 二维码
       var left2 = screen.width * 0.275;
       var top2 = screen.height * 0.452;
       var x2 = screen.width * 0.45;
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

                // 头像
                    img.onload=function(){
                        context.drawImage(img,left1,top1,x1,y1);                       
                        drawing(num+1);
                    }                   
                }else if(num==1){
                     // 背景
                    img.onerror=function(){h=140 }
                    img.onload=function(){

                        context.drawImage(img,0,0,screen.width,screen.height);
                        context.font='18px 宋体';
                        context.fillStyle='#000';
                        context.fillText(data.name,left0,top0,right0); 
                        setTimeout(function () {
                            drawing(num+1);
                        },200);                       
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
draw();
</script>
</body>
</html>



