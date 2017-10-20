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
            <h5>修改商品
            </h5>
            <div class="ibox-tools">
                <a class="collapse-link btn btn-outline btn-success" href="{{url('goods/goodsAreaList')}}">
                    返回
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('goods/actEditAreaGoods')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">请选择分类类型</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="goodsArea" type="text" id="goodsClassType">
                            <option value="">--请选择--</option>
                            @foreach(config('admin.specialArea') as $k=>$v)
                                @if($res->type==$k)
                                    <option value="{{$res->type}}" style="color:red" selected>{{$v}}</option>
                                @else
                                    <option value="{{$k}}">{{$v}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="name" type="text" value="{{$res->name}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">厂家编号</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="factory_code" value="{{$res->factory_code}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品描述</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="title" value="{{$res->title}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品主图</label>
                    <div class="col-sm-10">
                        <input type="file" name="pic" value="" id="singleFile">
                        <img id="singleImg" style="border: 1px dashed #c0c0c0" src="{{asset($res->pic)}}" width="100px" height="100px">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品库存</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="storage" value="{{$res->storage}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品销量</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="sale" value="{{$res->sale}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <input type="hidden" name="id" value="{{$id}}">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
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
</script>
<script type="text/javascript">
    $("#singleFile").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;
        console.log("objUrl = "+objUrl) ;
        if (objUrl) {
            $("#singleImg").attr("src", objUrl) ;
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