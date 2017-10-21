
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
		width:40%;
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
</style>
</head>
<body>
<div class="public_head">
	<h3 style="color:#333">排位订单</h3>
	<a style="color:#333" href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-bottom:0">
	<div class="bonus_box">
		<ul class="bonusList">

		@foreach($roworders as $v)
			@if($v['type'] ==1)
			<li class="div_clearFloat bonusItem">

				<img src="{{asset('home/images/order100.png')}}" alt=""/>
				<div class="bonus_con">
					<p >100元商品区</p>
					<span> {{date('Y-m-d H:i',$v['create_at'])}}</span>
				</div>
					@if($v['status'] ==1)
					<h3 class="colorExchange">未出局</h3>
					@elseif($v['status']==2)
					<h3 >已出局</h3>
					@endif
				<p>+￥{{$v['money']}}</p>
			</li>
			@elseif($v['type']==2 )
				<li class="div_clearFloat bonusItem">

				<img src="{{asset('home/images/order2000.png')}}" alt=""/>
				<div class="bonus_con">
					<p >300元商品区</p>
					<span> {{date('Y-m-d H:i',$v['create_at'])}}</span>
				</div>
					@if($v['status'] ==1)
					<h3 class="colorExchange">未出局</h3>
					@elseif($v['status']==2)
					<h3 >已出局</h3>
					@endif
				<p>+￥{{$v['money']}}</p>
			</li>
			@elseif($v['type']==3 )
					<li class="div_clearFloat bonusItem">

				<img src="{{asset('home/images/order300.png')}}" alt=""/>
				<div class="bonus_con">
					<p >2000元商品区</p>
					<span> {{date('Y-m-d H:i',$v['create_at'])}}</span>
				</div>
					@if($v['status'] ==1)
					<h3 class="colorExchange">未出局</h3>
					@elseif($v['status']==2)
					<h3 >已出局</h3>
					@endif
				<p>+￥{{$v['money']}}</p>
			</li>
			@endif
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