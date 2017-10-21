<!DOCTYPE html>
<html>

<head>
    @include('admin.layouts.header')
</head>

<body class="gray-bg">
@include('admin.layouts.box')
<div class="col-sm-12">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="<?php echo $flag==1?'active':''?>">
                <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                    添加商城商品
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane <?php echo $flag==1?'active':''?>">
                <div class="panel-body">
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{url('admin2/goods/addGoods')}}" enctype="multipart/form-data">
<!--                             <div class="form-group">
                                <label class="col-sm-2 control-label">请选择分类类型</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="type" type="text" id="goodsClassType">
                                        <option value="">--请选择--</option>
                                        @foreach(config('admin.goodsClassType') as $k=>$v)
                                            <option value="{{$k+1}}">{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
<!--                             <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">一级分类</label>
                                <div class="col-sm-10">
                                    <select class="form-control" type="text" id="oneGoodsClass">
                                        <option value="">--请选择--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">下级分类</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="class_id" type="text" id="nextClass">
                                        <option value="">--请选择--</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品名称</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品价格</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="price" type="number">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品描述</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="title" value="">
                                </div>
                            </div>
<!--                             <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">厂家编号</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="factory_code" value="">
                                </div>
                            </div> -->
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品主图</label>
                                <div class="col-sm-10">
                                    <input type="file" name="pic" value="" id="singleFile">
                                    <img id="singleImg" style="border: 1px dashed #c0c0c0" src="{{asset('uploads/goodsDefaultPic/default1.jpg')}}" width="100px" height="100px">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品副图</label>
                                <div class="col-sm-10">
                                    <input id="multiple" type="file" multiple="multiple" name="small_pic[]" value="" onchange="javascript:setImagePreviews();">
                                    <span style="color:red">请上传多张小图</span>
                                    <div id="holder" style=" width:990px;"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed" id="typeInput"></div>
<!--                             <div  class="ppp"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品库存</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="storage" value="">
                                </div>
                            </div> -->
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品销量</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="sale" value="">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
<!--                             <div class="form-group">
                                <label class="col-sm-2 control-label">商品类型</label>
                                <div class="col-sm-10">
                                    @foreach(config('admin.goodsType') as $k=>$v)
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="goodsType[]" value="{{$k+1}}" id="inlineCheckbox1">{{$v}}
                                    </label>
                                    @endforeach
                                </div>
                            </div> -->
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品详情</label>
                                <div class="col-sm-10">
                                    <script id="editor" name="content" type="text/plain" style="width:100%;height:300px;"></script>
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

            <div id="tab-2" class="tab-pane <?php echo $flag==2?'active':''?>">
                <div class="panel-body">
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{url('goods/actGoodsArea')}}" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">请选择专区分类</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="goodsArea" type="text">
                                        <option value="">--请选择--</option>
                                        @foreach(config('admin.specialArea') as $k=>$v)
                                            <option value="{{$k}}">{{$v}} 元区</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品名称</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品描述</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="title" value="">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">厂家编号</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="factory_code" value="">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品主图</label>
                                <div class="col-sm-10">
                                    <input type="file" name="pic" value="" id="areaFile">
                                    <img id="areaImg" style="border: 1px dashed #c0c0c0" src="{{asset('uploads/goodsDefaultPic/default1.jpg')}}" width="100px" height="100px">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品副图</label>
                                <div class="col-sm-10">
                                    <input id="multiple1" type="file" multiple="multiple" name="small_pic[]" value="" onchange="javascript:setImagePreviews1();">
                                    <span style="color:red">请上传多张小图</span>
                                    <div id="holder1" style=" width:990px;"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed" id="typeInput"></div>
                            <div  class="ppp"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品库存</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="storage" value="">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品销量</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="sale" value="">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品详情</label>
                                <div class="col-sm-10">
                                    <script id="editor2" name="content" type="text/plain" style="width:100%;height:300px;"></script>
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
        </div>
    </div>
</div>

</body>
</html>
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.all.js')}}"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="{{asset('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script type="text/javascript">
    var ue =UE.getEditor('editor');
    var ue2 =UE.getEditor('editor2');
</script>
<script type="text/javascript">
    $('.close').click(function(){
        $(this).parent().parent().remove();
    })
    // $('#goodsClassType').change(function(){
    //     var type=$(this).val();
    //     $(".oneClass").remove();
    //     if(type){
    //         $.ajax({
    //             'url':'{{url("goods/getGoodsClass")}}',
    //             'data':{'type':type},
    //             'async':true,
    //             'type':'get',
    //             'dataType':'json',
    //             success:function(data){
    //                 if(data.status){
    //                     $.each(data.data,function(index,value){
    //                         var opt = '<option class="oneClass" value='+value.id+'>' + value.name + '</option>';
    //                         $('#oneGoodsClass').append(opt);
    //                     })
    //                 }else{
    //                     alert('获取数据失败');
    //                 }
    //             },
    //             error:function(){
    //                 alert('Ajax响应失败');
    //             }
    //         })
    //         getInputForm(type);
    //     }
    // })
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
    //下面用于多图片上传预览功能
    function setImagePreviews(avalue) {
        //获取选择图片的对象
        var docObj = document.getElementById("multiple");
        //后期显示图片区域的对象
        var dd = document.getElementById("holder");
        dd.innerHTML = "";
        //得到所有的图片文件
        var fileList = docObj.files;
        //循环遍历
        for (var i = 0; i < fileList.length; i++) {
            //动态添加html元素
            dd.innerHTML += "<div style='float:left' > <img id='img" + i + "'  /> </div>";
            //获取图片imgi的对象
            var imgObjPreview = document.getElementById("img"+i);

            if (docObj.files && docObj.files[i]) {
                //火狐下，直接设img属性
                imgObjPreview.style.display = 'block';
                imgObjPreview.style.width = '140px';
                imgObjPreview.style.height = '120px';
                //imgObjPreview.src = docObj.files[0].getAsDataURL();
                //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要以下方式
                imgObjPreview.src = window.URL.createObjectURL(docObj.files[i]);   //获取上传图片文件的物理路径
            }
            else {
                //IE下，使用滤镜
                docObj.select();
                var imgSrc = document.selection.createRange().text;
                //alert(imgSrc)
                var localImagId = document.getElementById("img" + i);
                //必须设置初始大小
                localImagId.style.width = "140px";
                localImagId.style.height = "120px";
                //图片异常的捕捉，防止用户修改后缀来伪造图片
                try {
                    localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                    localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
                }
                catch (e) {
                    alert("您上传的图片格式不正确，请重新选择!");
                    return false;
                }
                imgObjPreview.style.display = 'none';
                document.selection.empty();
            }
        }
        return true;
    }
</script>
<script type="text/javascript">
    $('#topAttr').change(function(){
        var id=$(this).val();
        if(id!=''&&id!=null){
            $(".attrValue").remove();
            $.ajax({
                'url':"{:U('goods/getAttrValue')}",
                'data':{'id':id},
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                    if(data.status){
                        $.each(data.data,function(index,value){
                            var opt = '<option class="attrValue" value='+value.id+'>' + value.name + '</option>';
                            $('#attrValueName').append(opt);
                        })
                    }else{
                        alert(data.error_message);
                    }
                },
                error:function(){
                    alert('Ajax响应失败');
                }
            })
        }
    })
</script>
<script type="text/javascript">
    $("#areaFile").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;
        console.log("objUrl = "+objUrl) ;
        if (objUrl) {
            $("#areaImg").attr("src", objUrl) ;
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
    function setImagePreviews1(){
        //获取选择图片的对象
        var docObj = document.getElementById("multiple1");
        //后期显示图片区域的对象
        var dd = document.getElementById("holder1");
        dd.innerHTML = "";
        //得到所有的图片文件
        var fileList = docObj.files;
        //循环遍历
        for (var i = 0; i < fileList.length; i++) {
            //动态添加html元素
            dd.innerHTML += "<div style='float:left' > <img id='img" + i + "'  /> </div>";
            //获取图片imgi的对象
            var imgObjPreview = document.getElementById("img"+i);

            if (docObj.files && docObj.files[i]) {
                //火狐下，直接设img属性
                imgObjPreview.style.display = 'block';
                imgObjPreview.style.width = '140px';
                imgObjPreview.style.height = '120px';
                //imgObjPreview.src = docObj.files[0].getAsDataURL();
                //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要以下方式
                imgObjPreview.src = window.URL.createObjectURL(docObj.files[i]);   //获取上传图片文件的物理路径
            }
            else {
                //IE下，使用滤镜
                docObj.select();
                var imgSrc = document.selection.createRange().text;
                //alert(imgSrc)
                var localImagId = document.getElementById("img" + i);
                //必须设置初始大小
                localImagId.style.width = "140px";
                localImagId.style.height = "120px";
                //图片异常的捕捉，防止用户修改后缀来伪造图片
                try {
                    localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                    localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
                }
                catch (e) {
                    alert("您上传的图片格式不正确，请重新选择!");
                    return false;
                }
                imgObjPreview.style.display = 'none';
                document.selection.empty();
            }
        }
        return true;
    }
</script>
