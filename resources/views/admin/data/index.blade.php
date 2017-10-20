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
        <!-- 总销售额 -->
        <div class="test" style="background-color:#73BF00;">
            <div></div>
            <div class="right">
                <span class="font">消费会员总量</span>
                <p>{{$memberz}}人</p>
            </div>
        </div>
        <!-- 总订单数 -->
        <div class="test">
            <div></div>
            <div class="right">
                <span class="font">历史累计收入总额</span>
                <p>{{$lsorder}}元</p>
            </div>
        </div>
          <!-- 排位订单数 -->
        <div class="test" style="background-color:#CC00FF;">
            <div></div>
            <div class="right">
                <span class="font">会员总余额</span>
                <p>{{$useraccount}}元</p>
            </div>
        </div>
        <!-- 总会员数 -->
        <div class="test" style="background-color:#FF44AA;">
            <div></div>
            <div class="right">
                <span class="font">今日新增会员量统计</span>
                <p>{{$memberj}}人</p>
            </div>
        </div>
        <!-- 待发货订单数 -->
        <div class="test" style="background-color:#00E3E3;">
            <div></div>
            <div class="right">
                <span class="font">今日订单统计</span>
                <p>{{$jorder}}单</p>
            </div>
        </div>
        <!-- 待付款订单数 -->
        <div class="test" style="background-color:#CC00FF;">
            <div></div>
            <div class="right">
                <span class="font">已发放提现总额</span>
                <p>{{$withdrawz}}元</p>
            </div>
        </div>
        <!-- 总成交订单数 -->
        <div class="test" style="background-color:#CCBBFF;">
            <div></div>
            <div class="right">
                <span class="font">今日提现总额</span>
                <p>{{$withdraw}}元</p>
            </div>
        </div>

        <!-- 会员总佣金 -->
        <div class="test" style="background-color:#73BF00;">
            <div></div>
            <div class="right">
                <span class="font">未消费会员统计</span>
                <p>{{$wmember}}人</p>
            </div>
        </div>
  
    </div>



<!-- 全局js -->
@include('admin.layouts.fooler')

