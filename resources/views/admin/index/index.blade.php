<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts.header')
</head>

<body class="gray-bg">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-8">
        <h2>后台首页</h2>
        <ol class="breadcrumb">
            <li>
                <a href="JavaScript:;">
                    亲爱的 <font color="red">{{$result->name}}</font> {{$time}}
                </a>
            </li>
        </ol>
        <div style="height:20px"></div>
        <p style="margin-left: 100px;">
            您当前登陆时间：{{date('Y-m-d H:i:s',$result->current_time)}}&nbsp;&nbsp;&nbsp;&nbsp;
            您上次登陆时间：{{date('Y-m-d H:i:s',$result->last_time)}}&nbsp;&nbsp;&nbsp;&nbsp;
            您当前登陆IP：{{$result->current_ip}}&nbsp;&nbsp;&nbsp;&nbsp;
            您上次登陆IP：{{$result->last_ip}}
        <p>
    </div>
</div>
<script src="{{asset('/admin/js/content.js?v=1.0.0')}}"></script>
</body>
</html>
