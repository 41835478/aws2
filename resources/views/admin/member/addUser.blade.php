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
            <h5>添加会员
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('member/actUser')}}">
                <div class="form-group">
                    <label class="col-sm-2 control-label">推荐人手机号</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="prev_phone" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员手机号</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="phone" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员真实姓名</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="login_name" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                {{csrf_field()}}
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
<script>
    $('.close').click(function(){
        $(this).parent().parent().remove();
    })
</script>