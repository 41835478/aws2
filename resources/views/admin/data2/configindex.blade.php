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
            <h5>修改参数
            </h5>
        </div>
        <div class="ibox-content">
             
     
    
                @foreach($data as $k=>$v)
                <form method="post" class="form-horizontal" action="{{url('admin2/data/configinfo')}}"  enctype="multipart/form-data" enctype="multipart/form-data" onSubmit="return check();">
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{$v->key}}</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="{{$v->id}}">
                        <input class="form-control" name="{{$v->id}}" type="text" value="{{$v->value}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- <button class="btn btn-white" type="reset">重置</button> -->
                    </div>
                </div>
            </form>
                @endforeach
        </div>
    </div>
</div>

<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
</body>
</html>
<script type="text/javascript">


</script>
