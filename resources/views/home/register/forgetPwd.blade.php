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

    <link rel="stylesheet" href="{{asset('home/css/main.css')}}">
    <script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
    <style>
        /* body{
            background-color:#f5f5f5;
        } */
    </style>
</head>
<body>
<div class="login_top">
    <a href="javascript:history.go(-1);" class="findPwd_a iconfont icon-fanhui"></a>
    <img class="logo" src="{{asset('home/images/login_logo.png')}}" alt="">
    <ul class="login_nav findPwd_nav">
        <li class="nav_li">
            <span>忘记密码</span>
            <img class="jiao" src="{{asset('home/images/login_jiao.png')}}" alt="">
        </li>
    </ul>
</div>

<div class="btm_box register_box">
    <div class="login_bottom">
        <div class="list_div">
            <img class="iconfont icon-zhanghao" src="{{asset('home/images/login_icon01.png')}}" alt="">
            <input class="input phone" name="phone" type="text" placeholder="请输入手机号">
        </div>
        <div class="list_div">
            <img class="iconfont icon-mima" src="{{asset('home/images/login_icon02.png')}}" alt="">
            <input class="input newpwd" name="newpwd" type="password" placeholder="请输入新密码">
        </div>
        <div class="list_div">
            <img class="iconfont icon-mima" src="{{asset('home/images/login_icon02.png')}}" alt="">
            <input class="input newpwd_confirmation" name="newpwd_confirmation" type="password" placeholder="请确认新密码">
        </div>
        <div class="list_div">
            <img class="iconfont icon-mima" src="{{asset('home/images/login_icon03.png')}}" alt="">
            <input class="yz_input input code" name="code" type="text" placeholder="输入验证码">

            <input id="register" class="register_yzBtn" type="button" value="获取验证码">
        </div>

        <button class="register_btn" type="button">确认</button>
    </div>
</div>
<script>

</script>
</body>
</html>
<script type="text/javascript">
var wait = 0;
function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled");
        o.value="获取验证码";
        wait = 60;
    } else {
        o.setAttribute("disabled", true);
        o.value="重新发送(" + wait + ")";
        wait--;
        setTimeout(function() {time(o)}, 1000)
    }
}
    $(function(){
        $('.register_yzBtn').click(function(){
            var phone=$('.phone').val();
            if(phone==""){
                alert("请输入您的手机号码！");
                return false;
            }
            if(!phone.match(/^1[34578]\d{9}$/)){
                alert('手机号不符合规则！');
                return false;
            }
            var data={
                'phone':phone,
            };
            var url="{{url('register/sendCode')}}";
            time(register);
            sendAjax(data,url)
        })
        $('.register_btn').click(function(){
            var phone=$('.phone').val();
            var newpwd=$('.newpwd').val();
            var newpwd_confirmation=$('.newpwd_confirmation').val();
            var code=$('.code').val();
            if(phone==""){
                alert("请输入您的手机号码！");
                return false;
            }
            if(!phone.match(/^1[34578]\d{9}$/)){
                alert('手机号不符合规则！');
                return false;
            }
            if(newpwd==''){
                alert("请输入您的新密码！");
                return false;
            }
            if(newpwd_confirmation==''){
                alert("请输入您的确认密码！");
                return false;
            }
            if(newpwd!=newpwd_confirmation){
                alert('两次密码输入不一致');
                return false;
            }
            if(code==''){
                alert('验证码不能为空');
                return false;
            }
            var data={
                'phone':phone,
                'newpwd':newpwd,
                'newpwd_confirmation':newpwd_confirmation,
                'code':code,
                '_token':'{{csrf_token()}}',
            };
            var url="{{url('forget/editPwd')}}";
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
                        if(data.data.flag==1){
                            window.location.href="{{url('register/index')}}";
                        }else if(data.data.flag==3){
                            //var wait=10;
                            time(register)
                        }else if(data.data.flag==4){
                            window.location.href="{{url('forget/forgetPwd')}}";
                        }
                    }else{
                        alert(data.message);
                    }
                },
                error:function(msg){
                    var json=JSON.parse(msg.responseText);
                    alert(Object.values(json)[0].toString());
                }
            })
        }
        
    })
</script>