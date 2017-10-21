
<!DOCTYPE html>
<html>
<head>
<title>爱无尚</title>
 @include('home.public.header')
<style>
	body{background-color:#f5f5f5;}
	.public_head{
		background: -webkit-linear-gradient(left, #1d93ec , #0188ed); 
        background: -o-linear-gradient(right, #1d93ec, #0188ed); 
        background: -moz-linear-gradient(right, #1d93ec, #0188ed); 
        background: linear-gradient(to right, #1d93ec , #0188ed); 
        border:0;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>我的团队</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-top:48px;padding-bottom:0">
	<div class="bonus">
		<h2>
			<em>{{$count}}</em>
		</h2>
		<p>团队人数</p>
	</div>
	<div class="bonus_box">
		<ul class="teamList">
	@if($team =='') 
		<li class="teamItem">
				<div class="team_con">
					<p>您还未有团队</p>
				</div>
			</li>
	@else
	@foreach($team as $k=>$v)
			<li class="teamItem">
				<span>{{$k+1}}</span>
					@if($v['pic']=='')
			
						<img src="{{asset('home/images/rank05.png')}}" alt=""/>
					@else
					<img src="{{$v['pic']}}" alt=""/>
					@endif
				<div class="team_con">
					
					@if($v['name']=='')
			
						<p>{{$v['name']}}</p>
					@else
						<p>爱无尚{{$v['phone']}}用户</p>
					@endif

					<span>{{$v['phone']}}</span>
				</div>
				<div class="team_identity">
					<p class="team_shenfen">
						<i class="iconfont icon-dengji"></i>
						<span>@if($v['level'] ==0) 游客
								@elseif($v['level']==1)批发商
								
								@endif
						</span>
					</p>
					<p class="team_time">{{date('Y-m-d' ,$v['create_at'])}}</p>
				</div>
			</li>
			@endforeach

	@endif
		
		</ul>
	</div>
</div>
<script src="https://cdn.bootcss.com/handlebars.js/4.0.10/handlebars.min.js"></script>
<script id="bonus" type="text/x-handlebars-template">

</script>
<script type="text/javascript">

	var handleHelper = Handlebars.registerHelper("addOne",function(index){
         return index+1;
    });
	var myTemplate = Handlebars.compile($("#bonus").html());
	$('.teamList').html(myTemplate(bonuslist));
</script>
</body>
</html>