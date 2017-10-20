<!DOCTYPE html>
<html>

<head>
    @include('admin.layouts.header')
    <style>
        .lightBoxGallery img {
            margin: 5px;
            width: 160px;
        }
    </style>
</head>

<body class="gray-bg">
@include('admin.layouts.box')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        @if($flag==1)
                            <a class="collapse-link btn btn-outline btn-success" href="{{url('goods/goodsList')}}">
                                返回
                            </a>
                        @else
                            <a class="collapse-link btn btn-outline btn-success" href="{{url('goods/goodsAreaList')}}">
                                返回
                            </a>
                        @endif
                    </div>
                </div>
                <div class="ibox-content">

                    <h2>修改商品轮播图</h2>
                    <form method="post" class="form-horizontal" action="{{url('goods/editSmallPic')}}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品轮播图</label>
                            <div class="col-sm-10">
                                <input id="singleFile" name="small_pic" type="file" value="">
                                <img id="singleImg" style="border: 1px dashed #c0c0c0" src="{{asset('uploads/goodsDefaultPic/default1.jpg')}}" width="100px" height="100px">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        {{csrf_field()}}
                        <input type="hidden" value="{{$id}}" name="id" id="goodsId">
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">添加</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-white" type="reset">重置</button>
                            </div>
                        </div>
                    </form>
                    <div class="lightBoxGallery">
                        @foreach($data as $v)
                            <a href="javascript:;" title="图片" class="smallPicDel" _pic="{{$v}}">删除<img src="{{asset($v)}}"></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>

<!-- 自定义js -->
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>

<!-- blueimp gallery -->
<script src="{{asset('admin/js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>
</body>
</html>
<script type="text/javascript">
    $('.close').click(function(){
        $(this).parent().parent().remove();
    })
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
<script type="text/javascript">
    $('.smallPicDel').click(function(){
        var id=$('#goodsId').val();
        var pic=$(this).attr('_pic')
        $.ajax({
            'url':'{{url("goods/delSmallPic")}}',
            'data':{'id':id,'pic':pic},
            'async':true,
            'type':'get',
            'dataType':'json',
            success:function(data){
                if(data.status){
                    parent.layer.msg(data.message);
                }else{
                    parent.layer.msg(data.message);
                }
                window.location.reload();
            },
            error:function(){
                alert('Ajax响应失败');
            }
        })
    })
</script>
