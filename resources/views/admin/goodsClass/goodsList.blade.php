<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts.header')
</head>
<body class="gray-bg">
@include('admin.layouts.box')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>商品分类列表</h5>
                </div>

                <div class="ibox-content">
                    <form action="{{url('goodsClass/list')}}" method="get">
                        <div class="input-group">
                            <span  style="float: right;margin-left: 15px;margin-right: 5px">分类类型：
                                <select id="types" name="type" class="input-sm">
                                    <option value="">--请选择--</option>
                                    @foreach(config('admin.goodsClassType') as $k=>$v)
                                        <option value="{{$k+1}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </span>
                            <span  style="float: right;margin-left: 15px">二级分类：
                                <select id="select_opts" name="secondName" class="input-sm">
                                    <option value="">--请选择--</option>
                                </select>
                            </span>
                            <span  style="float: right;">一级分类：
                                <select name="topName" class="input-sm" id="topLevel">
                                    <option value="">--请选择--</option>
                                    @foreach($date as $v))
                                    <option value="{{$v['id']}}">{{$v['name']}}</option>
                                    @endforeach
                                </select>
                            </span>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    搜索
                                </button>
                            </span>
                        </div>
                    </form>
                    <table class="footable table table-stripped" data-page-size="10" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>分类名称</th>
                            <th>分类类型</th>
                            <th>排序</th>
                            <th>是否显示</th>
                            <th>分类图片</th>
                            <th>添加时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v['id']}}</td>
                                <td>{{$v['name']}}</td>
                                @foreach(config('admin.goodsClassType') as $k=>$val)
                                    @if($k+1==$v['type'])
                                    <td>{{$val}}</td>
                                    @endif
                                @endforeach
                                <td><input type="text" class="sort" style="background: #c0c0c0;width:100px;height:30px" value="{{$v['sort']}}"></td>
                                <td>
                                    @if ($v['status']==1)
                                        <b style="color:green">显示</b> | <b style="color:#ccc;cursor:pointer" class="unDisplay">不显示</b>
                                    @else
                                        <b style="color:#ccc;cursor:pointer" class="display">显示</b> | <b style="color:green">不显示</b>
                                    @endif
                                </td>
                                <td class="center">
                                    @if($v['pic'])
                                        <img src="{{asset($v['pic'])}}" width="50px" height="50px">
                                    @else
                                    @endif
                                </td>
                                <td class="center">{{$v['create_at']}}</td>
                                @if($v['update_at'])
                                    <td class="center">{{$v['update_at']}}</td>
                                @else
                                    <td class="center"></td>
                                @endif
                                <td class="center">
                                    <a href="{{url('goodsClass/editClass',['id'=>$v['id']])}}">修改</a> |
                                    <a href="javascript:;" class="goodsClassDel">删除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">共{{$total}}条数据 当前第{{$currentPage}}/{{$page}}页</td>
                            <td colspan="8">
                                {!! $goodsClass->links() !!}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 全局js -->
@include('admin.layouts.fooler')

<!-- 自定义js -->
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
</body>
</html>
<script type="text/javascript">
    $(function(){
        $('.sort').blur(function(){
            var id=$(this).parent().parent().find('.did').html();
            var sort=$(this).val();
            if(sort!=''&&sort!=null){
                $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                });
                $.ajax({
                    'url':'{{url("goodsClass/sort")}}',
                    'data':{'id':id,'sort':sort},
                    'async':true,
                    'type':'post',
                    'dataType':'json',
                    success:function(data){
                        if(data.status){
                            parent.layer.alert(data.message, {
                                icon: 1,
                                skin: 'layer-ext-moon'
                            })
                        }else{
                            alert(data.message);
                        }
                        window.location.reload();
                    },
                    error:function(){
                        alert('Ajax响应失败');
                    }
                })
            }
        })
        $('.goodsClassDel').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var sure=confirm("你确信要删除该条数据吗？删除将无法找回")
            if(sure==true){
                $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                });
                $.ajax({
                    'url':'{{url("goodsClass/goodsClassDel")}}',
                    'data':{'id':id},
                    'async':true,
                    'type':'post',
                    'dataType':'json',
                    success:function(data){
                        if(data.status){
                            parent.layer.msg(data.message);
                            window.location.reload();
                        }else{
                            parent.layer.msg(data.message);
                            window.location.reload();
                        }
                    },
                    error:function(){
                        alert('Ajax响应失败');
                    }
                })
            }
        })
        $('.unDisplay').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var flag=2;
            var data={
                'id':id,
                'flag':flag,
            };
            displayAjax(data)
        })
        $('.display').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var flag=1;
            var data={
                'id':id,
                'flag':flag,
            };
            displayAjax(data)
        })
        function displayAjax(data)
        {
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
            $.ajax({
                'url':'{{url("goodsClass/whetherDisplay")}}',
                'data':data,
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                    if(data.status){
                        parent.layer.alert(data.message, {
                            icon: 1,
                            skin: 'layer-ext-moon'
                        })
                    }else{
                        alert(data.message);
                    }
                    window.location.reload();
                },
                error:function(){
                    alert('Ajax响应失败');
                }
            })
        }
        $('#topLevel').change(function(){
            $(".optionlist").remove();
            var id=$(this).val();
            if(id!=''){
                $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                });
                $.ajax({
                    'url':'{{url("goodsClass/secondClass")}}',
                    'data':{'id':id},
                    'async':true,
                    'type':'post',
                    'dataType':'json',
                    success:function(data){
                        if(data.status==true){
                            $.each(data.data,function(index,value){
                                var opt = '<option class="optionlist" value='+value.id+'>' + value.name + '</option>';
                                $("#select_opts").append(opt);
                            })

                        }else{
                            alert(data.message);
                        }
                    },
                    error:function(){
                        alert('Ajax响应失败');
                    }
                })
            }
        })
    })
</script>