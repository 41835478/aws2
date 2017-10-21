
<!DOCTYPE html>
<html>
<head>
<title>爱无尚</title>
 @include('home.public.header')
<style>
	body{background-color:#f5f5f5;}
	.public_head{background: #fff;}
	.bonusItem>img {
	    display: block;
	    float: left;
	    width: 35px;
	    height: 35px;
	    border-radius: 50%;
	    margin-top:8px;
	}
	.bonus_con{
		width:32%;
		margin-left:1%;
		padding-left: 0%;
	}
	@media screen and (min-width:350px){
	    .bonus_con{
			width:32%;
			margin-left:8%;
			padding-left: 0%;
		}
	}
	.bonus_con>p{
		line-height: 42px;
		height:34px;
	}
	.bonusItem>span{
		max-width:10%;
	}
	.bonusItem>p{
		float:right;
		line-height: 50px;
		width:35%;
		text-align: right;
		padding-left:0;
	}
	.bonusItem>h3.colorExchange{color:#03a9f4;}
	.dianwei{float:left;font-size:14px;}
	.dianwei p{line-height: 46px;font-size: 16px;margin-left: 5px;}
	.fly_pan{float: right;}
	.fly_pan p{font-size: 16px;line-height: 36px;}
	.dianwei span{font-size: 12px;}
	.aimDianwei{font-size: 14px !important}
	.fly_po{width: 96px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
</style>
</head>
<body>
<div class="public_head">
	<h3 style="color:#333">积分升级</h3>
	<a style="color:#333" href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-bottom:0">
	<div class="bonus_box">
		<ul class="bonusList">

		@foreach($roworders as $v)
		
			<li class="div_clearFloat bonusItem">

				<!-- <img src="{{asset('home/images/order100.png')}}" alt=""/> -->
				
				<div class="dianwei">
					<p class="fly_po">{{$v['info']}}</p>
					<span> {{date('Y-m-d H:i',$v['create_at'])}}</span>
				</div>	
				<div class="bonus_con">
					<p  class="aimDianwei">当前级别：{{$v['current_level']}}</p> 
					<p class="aimDianwei">目标点位：<span>{{$v['to_row_id']}}</span></p>
					
				</div>				
				<div class="fly_pan">	
				<p  > @if($v['mark'] ==1)+ @elseif($v['mark']==2)-	@endif {{$v['promote_fee']}}</p>
					@if($v['flag'] ==1)
					<p >A盘</p>
					@elseif($v['flag']==2)
					<p >B盘</p>
					@elseif($v['flag']==3)
					<p >C盘</p>
					@endif
				</div>
					
			</li>
		
		@endforeach
			
		</ul>
	</div>
</div>
<script src="https://cdn.bootcss.com/handlebars.js/4.0.10/handlebars.min.js"></script>

<script type="text/javascript">

	var handleHelper = Handlebars.registerHelper("addOne",function(index){
         return index+1;
    });
	var myTemplate = Handlebars.compile($("#bonus").html());
    Handlebars.registerHelper("transformat",function(value){
          if(value=='0'){
	             return '';
		  }else if(value=='1'){
	            return "colorExchange";
	      }
	});
	$('.bonusList').html(myTemplate(bonuslist));
</script>
</body>
</html>