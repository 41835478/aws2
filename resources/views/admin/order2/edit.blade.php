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
            <h5>确认发货
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('admin2/order/editinfo')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">订单编号</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="order_code" type="text" value="{{$res->order_code}}" readonly>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">收货人姓名</label>
                    <div class="col-sm-10">

                        <input class="form-control" name="name" type="text" value="{{$res->name}}">
 
                    </div>
                </div>
                  <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">收货人电话</label>
                    <div class="col-sm-10">

                        <input class="form-control" name="phone" type="text" value="{{$res->phone}}">
 
                    </div>
                </div>
                  <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">物流名称</label>
                    <div class="col-sm-10">

                        <input class="form-control" name="wu" type="text" value="{{$res->wu}}">
 
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">物流电话</label>
                    <div class="col-sm-10">
                     
                        <input class="form-control" name="wuphone" type="text" value="{{$res->wuphone}}">
                    
                     
                </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">快递单号</label>
                    <div class="col-sm-10">
                     
                        <input class="form-control" name="numbers" type="text" value="{{$res->numbers}}">
                    
                     
                </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详细地址</label>
                    <div class="col-sm-10">
                     
                        <input class="form-control" name="address" type="text" value="{{$res->address}}">
                    
                     
                </div>
                </div>
            
                <div class="hr-line-dashed"></div>
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$res->id}}">
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                    <input type="hidden" name="id" value="{{$res->id}}">
                        <button class="btn btn-primary" type="submit">提交</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-white" type="reset">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
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
</script>