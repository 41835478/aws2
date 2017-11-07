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
            <h5>修改用户信息
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('member/editinfo')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="name" type="text" value="{{$res->name}}" readonly>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户手机号</label>
                    <div class="col-sm-10">
                      @if($res->phone =='')
                        <input class="form-control" name="phone" readonly type="text" value="">
                       @else
                         <input class="form-control" name="phone" readonly type="text" value="{{$res->phone}}">                                          
                       @endif 
                     
                </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">当前用户余额</label>
                    <div class="col-sm-10">

                        <input class="form-control" name="account" type="number" readonly value="{{$res->account}}">
 
                    </div>
                </div>
                  <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">充值金额</label>
                    <div class="col-sm-10">

                        <input class="form-control" name="chongaccount" type="number" value="{{$res->chongaccount}}">
 
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户推荐人手机号</label>
                    <div class="col-sm-10">
                      @if($ress == '')
                        <input class="form-control" name="pphone" type="text" value="">
                       @else
                         <input class="form-control" name="pphone" type="text" value="{{$ress->phone}}">                                          
                       @endif 
                     
                </div>
                 </div>
               
           
              <div class="hr-line-dashed"></div>
              {{--<div class="form-group">--}}
                {{--<label class="col-sm-2 control-label">启用或禁用</label>--}}
                {{--<div class="col-sm-10">--}}
                  {{--<label class="checkbox-inline">--}}
                    {{--<input value="1" name="locking"  type="radio" @if ($res->locking == 1) checked--}}
                                                                  {{--@else--}}
                                                                   {{----}}
                                                                 {{--@endif >是</label>--}}
                    {{--<label class="checkbox-inline">--}}
                    {{--<input value="0" name="locking"  type="radio"  @if ($res->locking == 0) checked--}}
                                                                  {{--@else--}}
                                                                   {{----}}
                                                                 {{--@endif >否</label></div>--}}
              {{--</div>               --}}
               <!--  <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类图片</label>
                    <div class="col-sm-10">
                        <input type="file" name="pic" value="" id="picFile">
                        @if ($res->pic)
                            <img class="picImg" style="border: 1px dashed #c0c0c0" src="" width="100px" height="100px">
                            @else
                            <img class="picImg" style="border: 1px dashed #c0c0c0" src="{{asset('uploads/goodsDefaultPic/default1.jpg')}}" width="100px" height="100px">
                        @endif
                    </div>
                </div> -->
                <div class="hr-line-dashed"></div>
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$res->id}}">
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                    <input type="hidden" name="id" value="{{$res->id}}">
                        <button class="btn btn-primary" type="submit">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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