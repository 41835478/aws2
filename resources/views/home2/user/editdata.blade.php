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

<link rel="stylesheet" href="{{asset('home/css/main.css')}}">
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<style>
	body{
		background-color:#f5f5f5;
	}
	::-webkit-input-placeholder { /* WebKit browsers */  
	    color: #333;  
	}  
	:-moz-placeholder { /* Mozilla Firefox 4 to 18 */  
	   color: #333;  
	   opacity:  1;  
	}  
	::-moz-placeholder { /* Mozilla Firefox 19+ */  
	   color: #333;  
	   opacity:  1;  
	}  
	:-ms-input-placeholder { /* Internet Explorer 10+ */  
	   color: #333;  
	}
	iframe{display:none;}
	.layui-upload-icon{display:none;}
	.layui-box{position:absolute;right:4%;width:64px;top:44px;}
	#picname{height:60px;opacity:0;}
</style>
</head>
<body>
<div class="public_head white_head">
	<h3>编辑资料</h3>
	<a href="{{url('users/index')}}" class="iconfont icon-fanhui"></a>
</div>
<!-- 内容区 -->
<div class="content editData_content">
@if($users['pic'] =='')
	<div class="ED_headBox">
		<span class="ED_left">我的头像</span>
		<img id="imgurl" name="imgurl" class="ED_headimg ED_right" src="{{asset('home/images/editData01.png')}}" alt="">
        <input type="file" name="picname" id="picname"/>
        <input type="hidden" name="headimg" id="headimg"/>

	</div>
@else
	<div class="ED_headBox">
		<span class="ED_left">我的头像</span>
		<img id="imgurl" name="imgurl" class="ED_headimg ED_right" src="{{$users['pic']}}" alt="">
        <input type="file" name="picname" id="picname"/>
        <input type="hidden" name="headimg" id="headimg"/>

	</div>

@endif
	<ul class="ED_ul">
		<li class="li1">
			<span class="ED_left">用户名</span>
			<input class="ED_right ED_textInput "  value="{{$users['name']}}"   id="name" type="text" >
		</li>
		<li class="selectSex">
			<span class="ED_left">性别</span>

			<select class="ED_select ED_right sex" name="sex"  id="sex" >
				<option value="1"  @if($users['sex']==1) selected @else  @endif >男</option>
				<option value="2"  @if($users['sex']==2) selected @else  @endif >女</option>
		<!-- 		<option value="3"  @if($users['sex']==3) selected @else  @endif >保密</option> -->
			</select>
		</li>

		<li>
			<span class="ED_left">真实姓名</span>
			<input class="ED_right ED_textInput" type="text"  value="{{$users['login_name']}}" id="login_name" >
		</li>
	</ul>
</div>
<footer class="footer btn_foot">
	<button  class="ED_yesBtn true" id="btn1" type="button">确定</button>
</footer>

<script>
	var arr = ["{{$users['name']}}","{{$users['login_name']}}"];
	$(".ED_ul .ED_textInput").eq(0).focus(function() {
		$(this).prop('placeholder','');
	});
	$(".ED_ul .ED_textInput").eq(0).blur(function() {
		$(this).prop("placeholder", arr[0]);
	});
	$(".ED_ul .ED_textInput").eq(1).focus(function() {
		$(this).prop('placeholder','');
	});
	$(".ED_ul .ED_textInput").eq(1).blur(function() {
		$(this).prop("placeholder", arr[1]);
	});
</script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('lay/layui/layui.js')}}"></script>
<script>
      var head_url = '';
      $(document).ready(function(){
            layui.use('upload', function(){
                layui.upload({
                  elem:'#picname',
                  url: "{{asset('lay/upload.php')}}",
                  success: function(res){
                    if(res.status==0){
                        console.log(res.message);
                    }
                    if(res.status==1){
                    	//console.log(111);
                        $('#imgurl').attr('src',res.url);
                        $('#headimg').attr('value',res.url);
                        head_url = res.url;
                        //console.log(head_url);
                    }
                  }
                });
            });
        });

</script>

<script type="text/javascript">



window.onload=function(){
    document.getElementById('btn1').onclick=function(){
        this.disabled=true;
        setTimeout(function (){
            document.getElementById('btn1').disabled=false;
        },5000);
    }
     
}
	  $('.true').click(function(){
            var name=$('#name').val();
            var sex=$('#sex').val();
            var login_name=$('#login_name').val();
            var pic=head_url;

            if(name==""){
                alert("请输入会员昵称！");
                return false;
            }
            
            if(login_name==""){
            	alert('请输入真实姓名');
            	return false;
            }
            var data={
            	'pic':pic,
                'name':name,
                'sex':sex,
                'login_name':login_name,
            }
            var url="{{url('users/editdatainfo')}}";
        
            $.ajax({
                'url':url,
                'data':data,
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                	 if(data.status){                    	
                            alert(data.message); 
                             if(data.data.flag==1)  {
                                window.location.href="{{url('users/index')}}";
                             }                 
                            
                        }else{
                        	alert(data.message);
                        	window.location.reload();
                        }

                  
                },
             
            })
              })
       

 

</script>

</body>
</html>