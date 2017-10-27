<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts.header')
</head>


<body class="gray-bg">
@include('admin.layouts.box')



<style>
        .test{float:left;margin:2rem;background-color: #66B3FF;width:18rem;height:8rem;border-radius: .5rem;border:1px solid #66B3FF;}
        /*.test .left{width:40%;margin:left;}*/
        .test .right{width:100%;text-align: center;}
        .test .right .font{color:white;font-size: 1.6rem;margin:1.5rem;line-height: 4rem;}
        .test .right p{color:white;font-size: 2rem;text-align: center;}

    </style>
    <div>
        <div class="test" style="background-color:#73BF00;">
            <div></div>
            <div class="right">
                <span class="font">众筹订单总金额</span>
                <p>{{$orderMoney}}元</p>
            </div>
        </div>
        <!-- 总订单 -->
        <div class="test" style="background-color:#73BF00;">
            <div></div>
            <div class="right">
                <span class="font">众筹订单总量</span>
                <p>{{$orders}}单</p>
            </div>
        </div>

        <div class="test" style="background-color:#73BF00;">
            <div></div>
            <div class="right">
                <span class="font">众筹领导奖</span>
                <p>{{$lingdao}}元</p>
            </div>
        </div>  

        <div class="test" style="background-color:#73BF00;">
            <div></div>
            <div class="right">
                <span class="font">众筹分销奖</span>
                <p>{{$fenxiao}}元</p>
            </div>
        </div>  

        <div class="test" style="background-color:#73BF00;">
            <div></div>
            <div class="right">
                <span class="font">众筹静态分红奖</span>
                <p>{{$static}}元</p>
            </div>
        </div> 
    </div>



<!-- 全局js -->
@include('admin.layouts.fooler')

