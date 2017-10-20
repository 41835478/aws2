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
            <h5>网站前台开关设置
            </h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('onOff/editWebOnOff')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        网站开关：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="radio">
                                    <label>
                                        <input value="1" {{$find->on_off==1?'checked':''}} checked id="optionsRadios2" name="on_off" type="radio">开启&nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input value="2" {{$find->on_off==2?'checked':''}} id="optionsRadios2" name="on_off" type="radio">关闭
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        用户是否可以注册：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="radio">
                                    <label>
                                        <input value="1" {{$find->flag==1?'checked':''}} checked id="optionsRadios2" name="flag" type="radio">可以&nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input value="2" {{$find->flag==2?'checked':''}} id="optionsRadios2" name="flag" type="radio">不可以
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        是否允许用户购物：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="radio">
                                    <label>
                                        <input value="1" {{$find->cart_onoff==1?'checked':''}} checked id="optionsRadios2" name="cart_onoff" type="radio">允许&nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input value="2" {{$find->cart_onoff==2?'checked':''}} id="optionsRadios2" name="cart_onoff" type="radio">不允许
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        是否显示用户二维码：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="radio">
                                    <label>
                                        <input value="1" {{$find->qrcode_onoff==1?'checked':''}} checked id="optionsRadios2" name="qrcode_onoff" type="radio">显示&nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input value="2" {{$find->qrcode_onoff==2?'checked':''}} id="optionsRadios2" name="qrcode_onoff" type="radio">不显示
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">限制每次购买商品的数量</label>
                    <div class="col-sm-5">
                        <input class="form-control" name="pay_num" type="text" value="{{$find->pay_num}}">
                        <span style="color:red">这里可以更改每次会员购买商品的数量</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
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

<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
</body>
</html>
<script>
    $('.close').click(function(){
        $(this).parent().parent().remove();
    })
</script>