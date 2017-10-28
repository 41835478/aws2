<!DOCTYPE html>
<html>
<head>
<title>爱无尚</title>
 @include('home.public.header')
<style>
	body{
		background-color:#f5f5f5;
	}
	.blue_head{
		background: none;
	}
</style>
</head>
<body>
<div class="myAccount_top">
	<div class="header">
		<h3>我的账户</h3>
		<a href="javascript:" onclick="self.location=document.referrer;" class="iconfont icon-fanhui"></a>
	</div>
	<div class="account_msg">
		<img class="account_star1" src="{{asset('home/images/account01.png')}}" alt="">
		<img class="account_img" src="{{asset('home/images/account02.png')}}" alt="">
		<img class="account_star2" src="{{asset('home/images/account01.png')}}" alt="">
		<p class="act_p1">(总金额)</p>
		<p class="act_p2">¥<span>{{$users['account']}}</span></p>
	</div>
</div>

<!-- 内容区 -->
<div class="account_bottom">
	<ul class="account_nav">
		<li class="li_on">
			<i class="iconfont icon-shourulaiyuan"></i>
			<span>收入详情</span>
		</li>
		<li>
			<i class="iconfont icon-handcoins"></i>
			<span>支出详情</span>
		</li>
	</ul>
	
	<!-- income -->
	<div class="account_body account_income">
		<ul>

		  @foreach ($saccount as $v)
			<li class="act_list">
				<img src="{{asset('home/images/act_icon01.png')}}" alt="">
				<div class="act_class">
					<p class="top_p">
					@if( $v['type'] ==1 ) 分销
						@elseif($v['type'] ==2 ) 账户转账
						@elseif($v['type']==3) 见点奖
						@elseif($v['type']==4) 推荐奖
						@elseif($v['type']==5) 升级奖
						@elseif($v['type']==7) 爱心奖转入
						@endif
					</p>
					<p class="time">{{date('Y-m-d H:i:s',$v['create_at'])}}</p>
				</div>
				<div class="act_state">
					
						成功						
				</div>
				<div class="act_money">
					+¥<span>{{$v['money']}}</span>
				</div>
				
			</li>
			@endforeach
			<!-- 新增四个收入 -->
		<!-- <li class="act_list">
			<img src="images/red01.png" alt="">
			<div class="act_class">
				<p class="top_p">十月股东分红</p>
				<p class="time">2017-03-22 12:35</p>
			</div>
			<div class="act_money">
				+¥<span>1000.00</span>
			</div>
		</li>
		<li class="act_list">
			<img src="images/red02.png" alt="">
			<div class="act_class">
				<p class="top_p">爱心奖金</p>
				<p class="time">2017-03-22 12:35</p>
			</div>
			<div class="act_money">
				+¥<span>168.00</span>
			</div>
		</li>
		<li class="act_list">
			<img src="images/red03.png" alt="">
			<div class="act_class">
				<p class="top_p">爱心分销奖</p>
				<p class="time">2017-03-22 12:35</p>
			</div>
			<div class="act_money">
				+¥<span>1000.00</span>
			</div>
		</li>
		<li class="act_list">
			<img src="images/red04.png" alt="">
			<div class="act_class">
				<p class="top_p">爱心领导奖</p>
				<p class="time">2017-03-22 12:35</p>
			</div>
			<div class="act_money">
				+¥<span>10.00</span>
			</div>
		</li> -->
			
		
		</ul>
	</div>

	<!-- pay -->
	<div class="account_body account_pay" style="display:none">
		<ul>
		  @foreach ($zaccount as $v)
			<li class="act_list">
				<img src="{{asset('home/images/act_icon06.png')}}" alt="">
				<div class="act_class">
					<p class="top_p">@if( $v['type'] ==1 ) 分销
						@elseif($v['type'] ==2 ) 账户转账
						@elseif($v['type']==3) 见点奖
						@elseif($v['type']==4) 推荐奖
						@elseif($v['type']==5) 升级奖
						@elseif($v['type']==6) 提现
						@endif</p>
					<p class="time">{{date('Y-m-d H:i:s',$v['create_at'])}}</p>
				</div>
				<div class="act_state">
				成功
					<!-- @if( $v['type'] ==2 && $v['status']==0)  处理中
						@elseif( $v['type'] ==2 && $v['status']==1)  -->

						<!-- @endif -->
				</div>
				<div class="act_money act_money1">
					-¥<span>{{$v['money']}}</span>
				</div>
				<!-- <div class="act_money act_state">
					<span>{{$v['pphone']}}</span>
				</div> -->
			</li>
			@endforeach
			<!-- 支出1箱 -->
			<!-- <li class="act_list">
				<img src="images/red05.png" alt="">
				<div class="act_class">
					<p class="top_p">众筹消费</p>
					<p class="time">2017-03-22 12:35</p>
				</div>
				<div class="act_money">
					-¥<span>2100.00</span>
				</div>
			</li> -->
		</ul>
	</div>
</div>
<p class="account_p">没有更多内容了... ...</p>
<footer class="footer btn_foot account_foot">
	<button value="1" class="tan_btn1 btn1" type="button">去转账</button>
	<button value="2" class="tan_btn2 btn2" type="button">立即提现</button>
</footer>


<!-- <div class="tan_box" style="display:none">
	<div class="tan_body">
		<p class="tan_p1">提示</p>
		<p class="tan_p2">达到要求方可进行提现和好友互转操作。</p>
		<div class="tan_btn_box">
			<button class="tan_btn1" type="button">取消</button>
			<button class="tan_btn2" type="button">确定</button>
		</div>
	</div>
</div> -->
<script>
	$(".account_nav li").click(function() {
		var _index = $(this).index();
		$(".account_nav li").removeClass('li_on');
		$(this).addClass('li_on');

		$(".account_body").css('display','none');
		$(".account_body").eq(_index).fadeIn(600);
	});

	$('.tan_btn1').click(function(){
				window.location.href = "/users/turnaccount";
			})
	$('.tan_btn2').click(function(){
				window.location.href = "/users/withdrawals";
	})
	// $(".account_foot button").click(function() {
	// 	$(".tan_box").fadeIn('fast');
	// 	var val = $(this).val();
	// 	console.log(val);
	// 	if(val == 1){
	// 		$('.tan_btn2').on("click",function(){
	// 			window.location.href = "/users/turnaccount";
	// 		})
	// 	}else if(val == 2){
	// 		$('.tan_btn2').on("click",function(){
	// 			window.location.href = "/users/withdrawals";
	// 		})
	// 	}

	// });

	$(".tan_box").find(".tan_btn1").click(function() {
		$(".tan_box").fadeOut('fast');
	});
	$(".tan_box").find(".tan_btn2").click(function() {
		$(".tan_box").fadeOut('fast');
	});
</script>
</body>
</html>