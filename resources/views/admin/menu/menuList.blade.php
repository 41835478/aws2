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
                    <h5>微信菜单类表</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" style="color:green" href="{{url('createMenu/customMenu')}}">
                            <button>生成菜单</button>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <table class="footable table table-stripped" data-page-size="10" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>菜单名称</th>
                            <th>type类型</th>
                            <th>key值</th>
                            <th>url</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date as $v)
                        <tr class="gradeX">
                            <td class="did">{{$v['id']}}</td>
                            <td>{{$v['name']}}</td>
                            <td>
                                @if($v['type']==1)
                                click
                                @else
                                view
                                @endif
                            </td>
                            <td>{{$v['key'] or "(无)"}}</td>
                            <td>{{$v['url']}}</td>
                            <td><input type="text" style="width:100px;height:30px;background:#c2c2c2" value="{{$v['sort']}}" class="sort"></td>
                            <td class="center">
                                <a href="{{url('menu/menuEdit',array('id'=>$v['id']))}}">修改</a>
                                | <a href="javascript:;" class="menuDel">删除</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 全局js -->
<script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="{{asset('admin/js/plugins/footable/footable.all.min.js')}}"></script>

<!-- 自定义js -->
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
<script src="{{asset('admin/js/plugins/layer/laydate/laydate.js')}}"></script>
</body>
</html>
<script type="text/javascript">
    $('.sort').blur(function(){
        var id=$(this).parent().parent().find('.did').html();
        var sort=$(this).val();
        if(sort){
            var data={
                'id':id,
                'sort':sort,
                '_token':"{{csrf_token()}}",
            };
            commonSet(data)
        }
    })
    function commonSet(data)
    {
        $.ajax({
            'url':'{{url("menu/sort")}}',
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
    $('.menuDel').click(function(){
        var id=$(this).parent().parent().find('.did').html();
        var sure=confirm("你确定要删除吗？删除会影响功能的正常使用（务必慎重！！！）")
        if(sure){
            $.ajax({
                'url':'{{url("menu/menuDel")}}',
                'data':{'id':id,'_token':"{{csrf_token()}}"},
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
</script>