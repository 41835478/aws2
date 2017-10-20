<!DOCTYPE html>
<html>

<head>
    @include('admin.layouts.header')
</head>

<body class="gray-bg">
@include('admin.layouts.box')
<div class="col-sm-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>生成排位订单
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('member/shenginfo')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">选择排位盘类型</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="top"  id="type" type="text">
                            <option  name="money" value="" >--请选择--</option>
                         
                                <option value="1">一百元区</option>
                                <option value="2">三百元区</option>
                                <option value="3">二千元区</option>
                       
                        </select>
                    </div>
                </div>


                  <div class="form-group">
            <!--     <div class="form-group">
                    <label class="col-sm-2 control-label">数量</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="number" value=""  id="number" type="number"  >
                    </div>
                </div> -->
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">可用余额</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="name" value="{{$res['account']}}" readonly type="text">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">用户手机号</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="{{$res['id']}}" id="id">
                        <input class="form-control" name="name" value="{{$res['phone']}}" readonly type="text">
                    </div>
                </div>
          
                {{csrf_field()}}
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary true"  type="button">购买</button><!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-white" type="reset">重置</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/jquery-3.1.1.min.js')}}"></script>
</body>
</html>
<script type="text/javascript">
    $('.close').click(function(){
        $(this).parent().parent().remove();
    })
    $("#picFile").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;
        console.log("objUrl = "+objUrl) ;
        if (objUrl) {
            $("#picImg").attr("src", objUrl) ;
        }
    }) ;
    //建立一個可存取到該file的url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }



	  $('.true').click(function(){
             var bool=confirm('你确定要购买吗？将不可恢复');
                if(bool){

                var id=$('#id').val();

                var type=$('#type').val();
                var number=$('#number').val();
            
            
            if(type==""){
                alert('请选择类型');
                return false;
            }
             if(number==""){
                alert('请输入数量');
                return false;
            }
             var data={
                'id':id,
                'type':type,
                'number':number,
               
            }
            var url="{{url('member/shenginfo')}}";
            $.ajax({
                'url':url,
                'data':data,
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                     if(data.status){ 
                        alert(data.message); 
                     if(data.data.flag==1){
                        window.location.href="{{url('member/index')}}";
                     } 
                                            
                            
                        }else{
                            alert(data.message);
                            window.location.reload();
                        }                  
                },
             
            })


                }
    
        })
    
</script>