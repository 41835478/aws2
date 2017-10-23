
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
<link rel="stylesheet" href="{{asset('home/css/index.css')}}"/>
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>

<style>
	body{
		background-color:#f5f5f5;
	}
	.footer{
		width:100%;
		padding:0;
		height:50px;
		line-height: 50px;
		border:0;
	}
	.submit_consignee>p{color:#666;}
</style>
</head>
<body>
<div class="public_head" style="background-color:#fff">
	<h3 style="color:#333">管理收货地址</h3>
	<a style="color:#333" href="javascript:history.go(-1);" class="iconfont icon-fanhui"></a>
</div>
<div class="content">
	<ul class="addressBox">

		@foreach($address as $v)
		<li class="manageAddress">
			<div class="submit_consignee">
				<p class="div_left">{{$v['name']}}</p>
				<p class="div_right">{{$v['phone']}}</p>
			</div>
			<p class="submitAddress-con">
				<span>{{$v['province']}} {{$v['city']}} {{$v['area']}}  {{$v['address']}}</span>
			</p>
			<div class="manageAdd">
				<div class="div_left">
					@if($v['default'] ==1)
					<i class="iconfont icon-not_selected icon-selected" data-id="{{$v['id']}}"></i>
					<span class="defaultColor">默认地址</span>
					@elseif($v['default'] ==0)
					<i class="iconfont icon-not_selected " data-id="{{$v['id']}}" ></i>
					<span>默认地址</span>
					@endif

				</div>
				<div class="div_right delet" >
					<i class="iconfont icon-shanchu" data-id="{{$v['id']}}"></i>
					<span>删除</span>
				</div>
			</div>
		</li>
		@endforeach


	</ul>
</div>
<footer class="footer">
	

    @if($dizhi == 1)
   <button onclick="javascript:window.location.href='/users/toaddress?gh=1'" type="button" class="edit_save">添加收货地址</button>
@else
  <button onclick="javascript:window.location.href='/users/toaddress'" type="button" class="edit_save">添加收货地址</button>
@endif   
</footer>
<script type="text/javascript">
    $(".manageAdd .div_left").on("touchstart", function (){
        $(".manageAdd .div_left").find('i').removeClass('icon-selected');
        $(this).find('i').addClass("icon-selected");
        $(".manageAdd .div_left").find('span').removeClass('defaultColor');
        $(this).find('span').addClass("defaultColor");
        var box = $(this);
        var index = goIndex(box);
        var id = $(this).find('i').attr("data-id");
        var type=1;

       
        $.ajax({
            'url':'{{url("users/addressdefault")}}',
            'data':{id:id,type:type},
            'type':'post',
            'cache':false,
            'dataType':'json',
            success:function(data){
              }
        })
    });
    function goIndex(it) {
        var big = it.parent();
        for (var i = 0; i < big.children().length; i++) {
            if (big.children().eq(i)[0] == it[0]) {
                return i;
            }
       }
    };
    /*delet*/
    $('.delet').on('touchend',function(){
    	$(this).parent().parent().css('display','none');

    	var id = $(this).find('i').attr("data-id");
        var type=2;
  
      	 $.ajax({
            'url':'{{url("users/addressdefault")}}',
            'data':{id:id,type:type},
            'type':'post',
            'cache':false,
            'dataType':'json',
            success:function(data){
              }
        })
        
  


    })



         

</script>
</body>
</html>