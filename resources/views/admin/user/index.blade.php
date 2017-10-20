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
            <h5>修改管理员密码
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('user/actEditPwd')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">管理员名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" disabled type="text" value="{{$find['name']}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">管理员账号</label>
                    <div class="col-sm-10">
                        <input class="form-control" disabled type="text" value="{{$find['mobile']}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">旧密码</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="oldPwd" value="" id="oldPwd">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="newPwd" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="newPwd_confirmation" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$find['id']}}" id="id">
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
<script>
    $('.close').click(function(){
        $(this).parent().parent().remove();
    })
    $('#oldPwd').blur(function(){
        var id=$('#id').val();
        var oldPwd=$(this).val();
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        $.ajax({
            'url':'{{url("user/validatePwd")}}',
            'data':{'id':id,'oldPwd':oldPwd},
            'async':true,
            'type':'post',
            'dataType':'json',
            success:function(data){
                if(data.status==false){
                    parent.layer.alert(data.message, {
                        skin: 'layui-layer-lan',
                        shift: 4 //动画类型
                    });
                }else{
                    parent.layer.alert(data.message, {
                        skin: 'layui-layer-molv',//样式类名
                        shift: 4 //动画类型
                    })
                }
            },
            error:function(){
                alert('Ajax响应失败');
            }
        })
    })
</script>
</body>
</html>