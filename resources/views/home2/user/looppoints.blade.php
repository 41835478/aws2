
<!DOCTYPE html>
<html>
<head>
<title>爱无尚</title>
 @include('home.public.header')
<style>
	body{
		background-color:#f5f5f5;
	}
</style>
</head>
<body>
<div class="reCastIntegral_top">
	<div class="public_head blue_head">
		<h3>循环积分</h3>
		<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
	</div>
	<div class="rci_content">
		<div class="rci_msg">
			<div class="rci_top">
				<p class="act_p1">总积分</p>
				<p class="act_p2">{{$points}}</p>
			</div>
		</div>
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
		<ul class="CP_income">

			 @foreach ($sintegral as $v)
			 <li class="act_list">
				<img src="http://www.tjzbdkj.com/home/images/act_icon12.png" alt="">
				<div class="act_class">
				<p class="top_p">{{$v['points_info']}}</p>
					<p class="time">{{date('Y-m-d H:i:s',$v['create_at'])}}</p>
				</div>
				<div class="act_money">
					+<span>{{$v['points']}}</span>
				</div>
			</li> 
			@endforeach

		</ul>
	</div>

	<!-- pay -->
	<div class="account_body account_pay" style="display:none">
		<ul class="CP_pay">

			 @foreach ($zintegral as $v)
			 <li class="act_list">
				<img src="http://www.tjzbdkj.com/home/images/act_icon10.png" alt="">
				<div class="act_class">
					<p class="top_p">{{$v['points_info']}}</p>
					<p class="time">{{date('Y-m-d H:i:s',$v['create_at'])}}</p>
				</div>
				<div class="act_money">
					-<span>{{$v['points']}}</span>
				</div>
			</li> 
			@endforeach

		</ul>
	</div>
</div>
<p class="account_p">没有更多内容了... ...</p>
<script>


	$(".account_nav li").click(function() {
		var _index = $(this).index();
		$(".account_nav li").removeClass('li_on');
		$(this).addClass('li_on');

		$(".account_body").css('display','none');
		$(".account_body").eq(_index).fadeIn(400);
	});
</script>
</body>
</html>