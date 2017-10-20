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
            <h5>修改微信底部菜单
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('menu/actEditMenu')}}" enctype="multipart/form-data">
                @if($num==1)
                <div class="form-group">
                    <label class="col-sm-2 control-label">一级菜单名称</label>
                    <div class="col-sm-10">
                        <select class="form-control" type="text" name="name">
                            <option value="{{$res->id}}">{{$res->name}}</option>
                            @foreach ($date as $v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">二级菜单名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="twoName">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @elseif($num==2)
                <div class="form-group">
                    <label class="col-sm-2 control-label">一级菜单名称</label>
                    <div class="col-sm-10">
                        <select class="form-control" type="text" name="name">
                            <option value="{{$name->id}}">{{$name->name}}</option>
                            @foreach ($date as $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">二级菜单名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="twoName"  value="{{$res->name}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @endif
                <div class="form-group">
                    <label class="col-sm-2 control-label">响应类型</label>
                    <div class="col-sm-10">
                        <select class="form-control" type="text" name="type">
                            <option value="{{$res->type}}">{{$res->typeName}}</option>
                            <option value="1">click</option>
                            <option value="2">view</option>
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">key值</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="key" type="text" placeholder="根据选择的响应类型进行填写" value="{{$res->key}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">url地址</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="url" placeholder="根据选择的响应类型进行填写" value="{{$res->url}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <input type="hidden" name="id" value="{{$res->id}}">
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

<script src="/admin/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/admin/js/jquery.min.js"></script>
</body>
</html>
<script>
    $('.close').click(function(){
        $(this).parent().parent().remove();
    })
</script>