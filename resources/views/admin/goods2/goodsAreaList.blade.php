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
                    <h5>专区商品列表</h5>
                </div>

                <div class="ibox-content">
                    <form action="{{url('goods/goodsAreaList')}}" method="get">
                        <div class="input-group">
                            <span  style="float: right;margin-left: 10px">专区分类：
                                <select name="areaType" class="input-sm">
                                    <option value="">--请选择--</option>
                                    @foreach(config('admin.specialArea') as $k=>$v)
                                        <option value="{{$k}}">{{$v}} 元专区</option>
                                    @endforeach
                                </select>
                            </span>
                            <span  style="float: right;margin-left: 10px">商品名称：
                                <input name="name" type="text" class="input-sm" placeholder="请输入商品名称"/>
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
                            <th>商品名称</th>
                            <th>厂家编号</th>
                            <th>商品主图</th>
                            <th>商品轮播图</th>
                            <th>价格</th>
                            <th>市场价</th>
                            <th>库存</th>
                            <th>销量</th>
                            <th>状态</th>
                            <th>详情</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->id}}</td>
                                <td>{{$v->name}}</td>
                                <td>{{$v->factory_code}}</td>
                                <td><img src="{{asset($v->pic)}}" width="50px" height="50px"></td>
                                <td>
                                    @if($v->small_pic)
                                    @foreach($v->small_pic as $val)
                                    <img src="{{asset($val)}}" width="50px" height="50px">
                                    @endforeach
                                    @endif
                                </td>
                                <td>{{$v->price}} 元</td>
                                <td>{{$v->money}} 元</td>
                                <td>{{$v->storage}}</td>
                                <td>{{$v->sale}}</td>
                                <td>
                                    @if($v->status==1)
                                        <b style="color:green">上线</b> | <b style="color:#ccc;cursor:pointer" class="down">下线</b>
                                    @else
                                        <b style="color:#ccc;cursor:pointer" class="upPut">上线</b> | <b style="color:green">下线</b>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"  data-num="{{$v->content}}" onclick="getGoodsDate('{{$v->id}}',this)" class="btn btn-primary" data-toggle="modal" data-target="#myModal5">
                                        查看详情
                                    </button>
                                </td>
                                <td class="center">
                                    <a href="{{url('goods/goodsAreaEdit',['id'=>$v->id])}}">修改</a> |
                                    <a href="{{url('goods/smallPicEdit',['id'=>$v->id,'flag'=>2])}}">修改商品轮播图</a> |
                                    <a href="javascript:;" class="areaGoodsDel">删除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">共{{$res['total']}}条数据 当前第{{$res['currentPage']}}/{{$res['page']}}页</td>
                            <td colspan="7">
                                {!! $date->links() !!}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{url('goods/editGoodsInfo')}}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">商品详情</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <script id="editor" name="content" type="text/plain" style="width:100%;height:300px;"></script>
                    </p>
                </div>
                <input class="getid" type="hidden" name="id" value="">
                {{csrf_field()}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- 全局js -->
<script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.all.js')}}"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="{{asset('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
@include('admin.layouts.fooler')
<!-- 自定义js -->
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
</body>
</html>
<script type="text/javascript">
    var ue =UE.getEditor('editor');
</script>
<script>
    function getGoodsDate(id,$this){
        var content=$($this).attr('data-num');
        $('.getid').val(id)
        ue.setContent(content)
    }
</script>
<script type="text/javascript">
    $(function(){
        $('.areaGoodsDel').click(function(){
            var bool=confirm('你确定要删除该商品吗？删除将不可回复');
            if(bool){
                var id=$(this).parent().parent().find('.did').html();
                $.get('{{url("goods/goodsDel")}}',{'id':id},function(data){
                    if(data.status){
                        parent.layer.alert(data.data, {
                            icon: 1,
                            skin: 'layer-ext-moon'
                        })
                    }else{
                        alert('删除失败');
                    }
                })
                window.location.reload();
            }
        })
        $('.down').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var flag=2;
            var mark=1;
            var data={
                'id':id,
                'flag':flag,
                'mark':mark
            };
            commonSet(data)
        })
        $('.upPut').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var flag=1;
            var mark=1;
            var data={
                'id':id,
                'flag':flag,
                'mark':mark
            }
            commonSet(data)
        })
        function commonSet(data)
        {
            $.ajax({
                'url':'{{url("goods/commonSet")}}',
                'data':data,
                'async':true,
                'type':'get',
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