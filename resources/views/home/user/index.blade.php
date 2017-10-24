<!DOCTYPE html>
<html>
<head>
<title>爱无尚</title>

 @include('home.public.header')

<style>
	body{background-color:#f5f5f5;}
	.center_navCon>.a_jump>span.span-new{padding-top:5px;}
	.center_navCon>.a_jump>img.img-new{width:35%;}
</style>
</head>
<body>
<div class="center_head">
	<div class="div_clearFloat center_top">
		@if($users['pic']=='')
			
			<img src="{{asset('home/images/rank05.png')}}" alt=""/>
		@else
		<img src="{{$users['pic']}}" alt=""/>
		@endif
		
		<div class="center_edit">
			<div class="div_clearFloat center_personalData">
				<p>{{$users['name']}} </p>
				<span>@if($users['level'] ==1  ) 批发商
						@elseif($users['level'] == 0) 游客
						@endif
				</span>
				<i onclick="javascript:window.location.href='/users/editdata'" class="iconfont icon-shape"></i>
			</div>
			<p>推荐人：@if($pusers =='') 无
						@elseif($pusers !=''){{$pusers['name']}}  {{$pusers['phone']}}
						@endif
			</p>
		</div>
	</div>
	<div class="div_clearFloat center_bot">
		<div class="center_money">
			<p>￥{{$users['account']}}</p>
			<span>账户余额(元)</span>
		</div>
		<!-- <div class="center_money">
			<p>{{$countt}}</p>
			<span>我的团队(人)</span>
		</div> -->
		<div class="center_money">
			<p>{{$love}}</p>
			<span>我的爱心值</span>
		</div>
	</div>
</div>
<div class="content" style="padding-top:0">
	<div class="center_content">
		<div class="center_nav">
			<div class="div_clearFloat centerMyorder">
				<i class="iconfont icon-dingdan"></i>
				<span>我的订单</span>
			</div>
			<div class="div_displayFlex center_navCon">
				<a href="{{url('users/userorder',['type'=>1])}}" class="a_jump">
					<img src="{{asset('home/images/center01.png')}}" alt=""/>
					<span>待付款</span>
				</a>
				<a href="{{url('users/userorder',['type'=>2])}}" class="a_jump">
					<img src="{{asset('home/images/center02.png')}}" alt=""/>
					<span>待发货</span>
				</a>
				<a href="{{url('users/userorder',['type'=>3])}}" class="a_jump">
					<img src="{{asset('home/images/center03.png')}}" alt=""/>
					<span>待收货</span>
				</a>
				<a href="{{url('users/userorder',['type'=>4])}}" class="a_jump">
					<img src="{{asset('home/images/center04.png')}}" alt=""/>
					<span>已完成</span>
				</a>
			</div>
		</div>
		<div class="center_nav " style="padding:20px 0">
			<div class="div_displayFlex center_navCon">
				<a href="{{url('users/myaccount')}}" class="a_jump">
					<img class="img-new" src="{{asset('home/images/iconh01.png')}}" alt=""/>
					<span class="span-new">我的账户</span>
				</a>
				<a href="{{url('users/myintegral')}}" class="a_jump">
					<img class="img-new" src="{{asset('home/images/iconh02.png')}}" alt=""/>
					<span class="span-new">我的积分</span>
				</a>
				<a href="{{url('users/mybonus')}}" class="a_jump">
					<img class="img-new" src="{{asset('home/images/iconh03.png')}}" alt=""/>
					<span class="span-new">公排奖金</span>
				</a>
				<a href="{{url('users/crowdfunding')}}" class="a_jump">
					<img class="img-new" src="{{asset('home/images/iconh04.png')}}" alt=""/>
					<span class="span-new">众筹奖金</span>
				</a>
			</div>
		</div>
		<ul class="centerList centerList1">
			<li class="centerItem">
				<a href="{{url('users/ranking_orders')}}" class="a_jump">
					<img src="{{asset('home/images/person04.png')}}" alt=""/>
					<span>排位订单</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
		</ul>
		<ul class="centerList centerList2">
			<li class="centerItem">
				<a href="{{url('users/activememberorders')}}" class="a_jump">
					<img src="{{asset('home/images/person05.png')}}" alt=""/>
					<span>激活会员订单</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
			<li class="centerItem">
				<a href="{{url('users/myTeam_new')}}" class="a_jump">
					<img src="{{asset('home/images/person06.png')}}" alt=""/>
					<span>我的团队</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
		</ul>
		<ul class="centerList centerList3">
			<li class="centerItem">
				<a href="{{url('users/accountbinding')}}" class="a_jump">
					<img src="{{asset('home/images/person07.png')}}" alt=""/>
					<span>账户绑定</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
			<li class="centerItem">
				<a href="{{asset('home/images/person08.png')}}" class="a_jump">
					<img src="{{asset('home/images/person08.png')}}" alt=""/>
					<span>收货地址</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
			<li class="centerItem">
				<a href="{{url('info/account_settings')}}" class="a_jump">
					<img src="{{asset('home/images/person10.png')}}" alt=""/>
					<span>账号设置</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
		</ul>
		<!-- person_b -->
		<ul class="centerList centerList2" style="margin-bottom:0">
			<li class="centerItem"> 

		@if($users['level']==1)
		<a href="{{url('users/qrcode')}}" class="a_jump ">
			@else
		<a href="javascript:void(0);" class="a_jump person_b">
		@endif	
					<img src="{{asset('home/images/person09.png')}}" alt=""/>
					<span>二维码</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
			<li class="centerItem">
				<a href="javascript:void(0);" class="a_jump person_aa" >
					<img src="{{asset('home/images/person13.png')}}" alt=""/>
					<span>退出</span>
					<i class="iconfont icon-you"></i>
				</a>
			</li>
		</ul>
	</div>
</div>
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
		<a href="{{url('users/qrcode')}}" class="a_jump ">
			@else
		<a href="javascript:void(0);" class="a_jump person_b">
		@endif
			<img src="{{asset('home/images/icon-3.png')}}" alt=""/>
			<span class="footerlist-cn">二维码</span>
		</a>

	
		<a href="{{url('users/index')}}" class="a_jump footerOn">
			<img src="{{asset('home/images/icon-44.png')}}" alt=""/>
			<span class="footerlist-cn">我的</span>
		</a>
	</div>

</footer>

<script>
	$(".person_b").on("click",function(){
        addBox("body");
        outBox("需要消费成为会员才能查看二维码","{{url('users/qrcode')}}");
     })
	$(".person_aa").on("click",function(){
        addBox("body");
        outBox("确认退出？","{{url('users/logout')}}");
     })


//    $('.true').click(function(){

        {{--var url="{{url('users/mynumcount')}}";--}}

        {{--$.ajax({--}}
            {{--'url':url,--}}
            {{--'async':true,--}}
            {{--'type':'post',--}}
            {{--'dataType':'json',--}}
            {{--success:function(data){--}}
                {{--if(data.status){--}}
                    {{--alert(data.message);--}}


                {{--}else{--}}
                    {{--alert(data.message);--}}
                    {{--window.location.reload();--}}
                {{--}--}}


            {{--},--}}

        {{--})--}}


</script>




</body>
</html>