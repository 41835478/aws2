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
<link rel="stylesheet" href="{{asset('home/css/fly.css">
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
</head>
<body>
<div class="public_head">
    <h3>大转盘</h3>
    <a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
     <i class="iconfont icon-edit"></i><!-- 如果是iconfon用这行代码 -->
</div>
<div class="draw-bg">
    <p class="draw-hint">今日有<b class="draw-hint_num" id="draw-hint_num">1</b>次抽奖机会</p>
    <div class="draw-show">
        <div class="draw-change_box" id="draw-box"></div>
        <div class="draw-change" id="draw-change"></div>
    </div>
    <div class="draw-btn" id="draw-btn"></div>
</div>
<div class="draw_kuang" style="display: none;">
    <img src="images/fly_1.png" alt="">
    <p>您抽到了“<em class="draw_money">2元</em>”现金奖励将直接转入余额账户中</p>
    <input type="button" value="确定" class="draw_sure">
</div>
<div class="draw_yh" style="display: none;">
    <img src="images/fly_3.png" alt="">
    <p>什么都没有抽到明天继续加油</p>
    <input type="button" value="确定" class="draw_sure">
</div>
<script type="text/javascript">
    // 转盘函数
    function drawAll(obj) {
        // 参数信息:obj对象值:num:抽奖机会次数;prizes:抽奖奖品的名字(数组对象);prizesNum:抽奖奖品量，默认为6种;
        //ele:添加信息的盒子(必须);odds:抽到每项的几率(整数表示);doEle:指针元素;inChange:内定选中项
        if (!obj.ele) return '没有找到元素';
        else this.ele = obj.ele;
        obj.num % 1 || Math.abs(obj.num) != obj.num ? this.num = 0 : this.num = Number(obj.num);//this.num:抽奖次数
        this.prizes = obj.prizes;//this.prizes奖品内容
        obj.prizesNum % 1 || Math.abs(obj.prizesNum) != obj.prizesNum ? this.prizesNum = 6 : this.prizesNum = Number(obj.prizesNum);//this.prizesNum:奖品分类量
        this.odds = obj.odds;//this.odds:抽到每项的几率
        (function () {//验证总几率是否为1
            var x = 0;
            for (var i = 0; i < obj.odds.length; i++) {
                x += parseFloat(obj.odds[i]);
            }
            if (x < 100) {
                console.error('总几率小于1');
            } else if (x > 100) {
                console.error('总几率大于1');
            }
        })();
        while(this.prizes.length < this.prizesNum) {
            this.prizes.push(this.prizes[0]);
        };
        this.deg = 360 / this.prizesNum;//每个商品旋转的角度
        this.inChange = obj.inChange;//内定选中项
        (function (drawIn) {//添加元素
            for (var i = 0; i < drawIn.prizesNum; i++) {
                var pNode = document.createElement('p');
                var inNode = document.createElement('span');
                var txtNode = document.createTextNode(drawIn.prizes[i]);
                pNode.className = 'draw-show_p';
                inNode.className = 'draw-show_span';
                inNode.appendChild(txtNode);
                pNode.appendChild(inNode);
                var thisDeg = drawIn.deg * i;
                pNode.style.cssText = '-ms-transform:rotate(' + thisDeg + 'deg);-moz-transform:rotate(' + thisDeg + 'deg);-webkit-transform:rotate(' + thisDeg + 'deg);-o-transform:rotate(' + thisDeg + 'deg);'
                if (thisDeg > 90 && thisDeg < 270) inNode.className = 'draw-show_spanno';;
                drawIn.ele.appendChild(pNode);
            }
        })(this);
        this.allArr = [];//创建随机数组
        this.flagNum = 0;//创建判定值
        for (var i = 0; i < this.odds.length; i++) {
            for (var j = 0; j < this.odds[i]; j++) {
                this.allArr.push(i);
            }
        }
        for (var i = 0; i < 5; i++) {
            this.allArr = this.allArr.concat(this.allArr);
        }
        this.allArr.length = 1000;
        this.doEle = obj.doEle;
        this.storeDeg = 120;//储存角度
        this.change = function () {//点击事件
            var ranNum = Math.floor(Math.random() * 1000);//随机出选中项
            var change = this.allArr[ranNum];//选中项
            if (this.inChange) change = this.inChange;//选中项
            var changeDeg = this.storeDeg + change * this.deg + 10 * 360;
            this.doEle.style.cssText = '-ms-transform:rotate(' + changeDeg + 'deg);-moz-transform:rotate(' + changeDeg + 'deg);-webkit-transform:rotate(' + changeDeg + 'deg);-o-transform:rotate(' + changeDeg + 'deg);';
            this.storeDeg = parseInt(changeDeg / 360) * 360 + 120;
            // console.log(change);
            return change;
        }
    }




    var draw = new drawAll({
        num: '1',//抽奖次数
        prizes: [//抽奖奖品
            '4元',
            '5元',
            '6元',
            '明天再来',
            '2元',
            '3元',
        ],
        ele: document.getElementById('draw-box'),//展示奖品的父级元素
        odds: [5,10,5,65,5,10],//奖品对应的抽奖几率
        doEle: document.getElementById('draw-change'),//旋转元素
        // inChange: 1//内定选中元素，可不填，不填则根据几率抽奖
    });

    var timer = 0;
    document.getElementById('draw-btn').addEventListener('click', function () {//点击事件
        
        if (draw.num <= 0 || timer != 0) {
            return false;
        }
        timer = 1;
        setTimeout(function () {
            timer = 0;
            
            if(draw.num <= 0){
                $(".draw-btn").css("background-image","url('images/fly_2.png')")
            }
            if(index == 3){
                $(".draw_yh").show();
            }else{
                $(".draw_kuang").show();
            }
        }, 5000);
        var index = draw.change();
        $(".draw_money").html(draw.prizes[index])
        
        draw.num--;
        document.getElementById('draw-hint_num').innerHTML = draw.num;
    });
    $(".draw_sure").on("click",function(){
        $(".draw_kuang").hide();
        $(".draw_yh").hide();
    })
</script>

</body>
</html>
