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
                <a class="collapse-link btn btn-outline btn-success" href="{{url('goods/goodsList')}}">
                    返回
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('goods/actEditGoods')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">请选择分类类型</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="type" type="text" id="goodsClassType">
                            <option value="">--请选择--</option>
                            @foreach(config('admin.goodsClassType') as $k=>$v)
                                @if($res->type==$k+1)
                                    <option value="{{$res->type}}" style="color:red" selected>{{$v}}</option>
                                @else
                                    <option value="{{$k+1}}">{{$v}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">一级分类</label>
                    <div class="col-sm-10">
                        <select class="form-control" type="text" id="oneGoodsClass">
                            <option value="{{$data['id']}}">{{$data['name']}}</option>
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">下级分类</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="class_id" type="text" id="nextClass">
                            <option value="{{$res->class_id}}">{{$res->class_name}}</option>
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
                    <label class="col-sm-2 control-label">商品价格</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="price" value="{{$res->price}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品市场价</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="money" value="{{$res->money}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @if($res->type==3)
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品消费积分</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="integral" value="{{$res->integral}}">
                    </div>
                </div>
                @endif
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
    $('#goodsClassType').change(function(){
        var type=$(this).val();
        $(".oneClass").remove();
        if(type){
            $.ajax({
                'url':'{{url("goods/getGoodsClass")}}',
                'data':{'type':type},
                'async':true,
                'type':'get',
                'dataType':'json',
                success:function(data){
                    if(data.status){
                        $.each(data.data,function(index,value){
                            var opt = '<option class="oneClass" value='+value.id+'>' + value.name + '</option>';
                            $('#oneGoodsClass').append(opt);
                        })
                    }else{
                        alert('获取数据失败');
                    }
                },
                error:function(){
                    alert('Ajax响应失败');
                }
            })
            getInputForm(type);
        }
    })
    $('#oneGoodsClass').change(function(){
        var id=$(this).val();
        $(".optionGoodsClass").remove();
        $.ajax({
            'url':"{{url('goods/getGoodsClass')}}",
            'data':{'id':id},
            'async':true,
            'type':'get',
            'dataType':'json',
            success:function(data){
                if(data.status){
                    $.each(data.data,function(index,value){
                        var opt = '<option class="optionGoodsClass" value='+value.id+'>' + value.name + '</option>';
                        $('#nextClass').append(opt);
                    })
                }else{
                    alert('获取数据失败');
                }
            },
            error:function(){
                alert('Ajax响应失败');
            }
        })
    })
    function getInputForm(type){
        $.ajax({
            'url':'{{url("goods/getInputForm")}}',
            'data':{'type':type},
            'async':true,
            'type':'get',
            'dataType':'json',
            success:function(data){
                if(data.status){
                    $('.ppp').html("")
                    $('.ppp').append(data.data)
                }else{
                    alert('获取数据失败');
                }
            },
            error:function(){
                alert('Ajax响应失败');
            }
        })
    }
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