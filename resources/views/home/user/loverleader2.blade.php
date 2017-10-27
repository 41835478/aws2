
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



<link rel="stylesheet" href="{{asset('home/css/index.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/swiper.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('home/font/iconfont.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/common.css')}}"/>

<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>

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
	<h3> @if($type==1)  一级领导奖
			@elseif($type==2)	二级领导奖
			@elseif($type==3)	三级领导奖	
			@elseif($type==4) 	四级领导奖
			@elseif($type==5) 	五级领导奖
			@elseif($type==6) 	六级领导奖
			@elseif($type==7) 	七级领导奖
			@elseif($type==8) 	八级领导奖
			@elseif($type==9) 	九级领导奖
			@endif
	</h3>
	<a href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content" style="padding-bottom:0">
	<div class="bonus_box">
		<ul class="bonusList">
		@foreach($data as  $k=>$v)
			<li class="div_clearFloat bonusItem">
				<span>{{$k+1}}</span>
				<div class="bonus_con">
					<p>{{$v['info']}}</p>
					<span> {{$v['created_at']}}</span>
				</div>
				<p>￥{{$v['num']}}</p>
			</li>
		@endforeach

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
	$('.bonusList').html(myTemplate(bonuslist));
</script>


<script type="text/javascript">
	var num = 0;
	var flag = true;
	$('body').on('touchend', function () {
		var doc = $(document),
			win = $(window),
			timer,
			scrollBottom = doc.height() - win.height() - win.scrollTop();
		timer = setInterval(function () {
			var newBot = doc.height() - win.height() - win.scrollTop();
			if (scrollBottom == newBot && flag) {
				clearInterval(timer);
				if (newBot <= 10) { 
					addPage(++num);
					flag = false;
				};
			}
			scrollBottom = newBot;
		}, 100);
	});
	// 拉到底部的事件
	// num拉到底部的次数；
	// ajax执行完毕后将flag改为true以便下次执行，若已无数据可不更改 flag = true;
	function addPage(num){
		console.log('已拉到底部，等待');
		 var data={
                'num':num,               
            }

          
            // var url="{{url('users/bonus_jiandian')}}";

            //    $.ajax({
            //     'url':url,
            //     'data':data,
            //     'async':true,
            //     'type':'post',
            //     'dataType':'json',
            //     success:function(data){
            //     	 if(data.status){                    	
            //                alert(data.message); 
            //                  if(data.data.flag==1)  {
            //                    flag = true;
            //                  }                 
                            
            //             }else{
            //             	alert(data.message);
            //             	flag = true;
            //             }                  
            //     },
             
            // })

	}
</script>
</body>
</html>