
<!DOCTYPE html>
<html>
<head>
<title>爱无尚</title>
 @include('home.public.header')
<style>
	body{
		background-color:#f5f5f5;
	}
	.addressBox{
		padding:0 3.125%;
		background-color: #fff;
		border-bottom:1px solid #eaeaea;
	}
	.addressBox>.submitAddress{
		padding:12px 0;
		border-bottom:1px solid #eaeaea;
	}
	.submitAddress-con{
		color:#333;
	}
	.default{
		color:#2194eb;
	}
	.addressBox>li:last-child{
		border:0;
	}
</style>
</head>
<body>
<div class="public_head">
	<h3>选择收货地址</h3>
	<a href="javascript:history.go(-1)" class="iconfont icon-fanhui"></a>


	@if($dizhi == 1)
	<span onclick="javascript:window.location.href='/users/manageaddress?gh=1'">管理</span>
@else
	<span onclick="javascript:window.location.href='/users/manageaddress'">管理</span>
@endif

</div>
<div class="content">
<ul class="addressBox">

	@foreach($address as $v)
	<li class="submitAddress" data-id="{{ $v['id'] }}" onclick="addressEdit({{ $v['id'] }})" >
		<div class="submit_consignee">
			<p class="div_left">{{$v['name']}}</p>
			<p class="div_right">{{$v['phone']}}</p>
		</div>
		<p class="submitAddress-con">
			@if($v['default'] ==1)
			<span class="default">[默认地址]</span>
			@elseif($v['default'] ==0)

			@endif

			<span class="con">{{$v['province']}} {{$v['city']}} {{$v['area']}}  {{$v['address']}}</span>
		</p>
	</li>
	@endforeach
	
</ul>
</div>
</body>


<script type="text/javascript">
function addressEdit(id){
	let gh = location.search.split('=')[1];
	if(gh == 1){
		$.ajax({
			url : '/users/addressEdit',
			type : 'post',
			data : {id:id},
			success : function(res){
				self.location=document.referrer;
			}
		})
	}
}
// $('.submitAddress').on('click touchend',function(){
// 	var id = $(this).data('id');

// 	let gh = location.search.split('=')[1];
// 	if(gh == 1){
// 		$.ajax({
// 			url : '/users/addressEdit',
// 			type : 'post',
// 			data : {id:id},
// 			success : function(res){
// 				alert(document.referrer);
// 				return false;
// 				self.location=document.referrer;
// 			}
// 		})
// 	}
// });
// 	// var con = $(this).find('.submitAddress-con .con').text();
// 	// localStorage.setItem('addressCon',con);
// 	// console.log(localStorage.getItem('addressCon'));
	
// 	// window.location.href = ""
// })

 

</script>
<script type="text/javascript">
	//  $(document).ready(function(){
	 
	//          var strName = localStorage.getItem('keyName');
	//          var strPass = localStorage.getItem('keyPass');
	//         if(strName){
	//              $('#username').val(strName);

	//          }
	//          if(strPass){
	//              $('#pwd').val(strPass);
	//          }

	//      });
	 
	// function Save(){
	//      var strName = $('#username').val();
	//      var strPass = $('#pwd').val();
	//      localStorage.setItem('keyName',strName);
	//      //localStorage.setItem('keyPass',strPass);
	//      console.log($('#ck_rmbUser').attr("checked"));
	//     if($('#ck_rmbUser').attr("name") == "1"){
	//          localStorage.setItem('keyPass',strPass);
	//     }else{
	//          localStorage.removeItem('keyPass');
	//      }
	// }



</script>
</html>