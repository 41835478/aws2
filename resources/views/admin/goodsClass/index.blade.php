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
            <h5>添加商品分类
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('goodsClass/addClass')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">上级分类</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="top" type="text">
                            <option value="">--请选择--</option>
                            @foreach($res as $v)
                                <option value="{{$v['id']}}">{{$v['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="name" type="text">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">请选择分类类型</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="type" type="text">
                            <option value="">--请选择--</option>
                            @foreach(config('admin.goodsClassType') as $k=>$v)
                                <option value="{{$k+1}}">{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类图片</label>
                    <div class="col-sm-10">
                        <input type="file" name="pic" value="" id="picFile">
                        <img id="picImg" style="border: 1px dashed #c0c0c0" src="{{asset('uploads/goodsDefaultPic/default1.jpg')}}" width="100px" height="100px">
                    </div>
                </div>
                {{csrf_field()}}
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">添加</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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