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
            <h5>修改幸运转盘配置
            </h5>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            <div class="form-group" style="color:red">
                注意事项：(每块的奖项配置中只能填纯数字或者纯汉字，否则出现错误将造成重大混乱，请务必慎重！！！)
            </div>
            <form method="post" class="form-horizontal" action="{{url('adminWheel/editWheel')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        第一块奖项配置：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <input placeholder="请填写奖项，如：50（代表50元）" name="prize_1" value="{{$find->prize_1 or ''}}" class="form-control" type="text">
                            </div>
                            <label class="col-sm-2 control-label">
                                第一块抽中比率配置：
                            </label>
                            <div class="col-md-4">
                                <input  onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" placeholder="请填写该奖项抽中的比率，如：5（代表抽中比率为5%）" name="angel_1" value="{{$find->angel_1 or ''}}" class="form-control rate-config" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        第二块奖项配置：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <input placeholder="请填写奖项，如：5（代表5元）" name="prize_2" value="{{$find->prize_2 or ''}}" class="form-control" type="text">
                            </div>
                            <label class="col-sm-2 control-label">
                                第二块抽中比率配置：
                            </label>
                            <div class="col-md-4">
                                <input  onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" placeholder="请填写该奖项抽中的比率，如：10（代表抽中比率为10%）" name="angel_2" value="{{$find->angel_2 or ''}}" class="form-control rate-config" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        第三块奖项配置：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <input placeholder="请填写奖项，如：500（代表500元）" name="prize_3" value="{{$find->prize_3 or ''}}" class="form-control" type="text">
                            </div>
                            <label class="col-sm-2 control-label">
                                第三块抽中比率配置：
                            </label>
                            <div class="col-md-4">
                                <input  onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" placeholder="请填写该奖项抽中的比率，如：1（代表抽中比率为1%）" name="angel_3" value="{{$find->angel_3 or ''}}" class="form-control rate-config" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        第四块奖项配置：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <input placeholder="请填写奖项，如：明日再来" name="prize_4" value="{{$find->prize_4 or ''}}" class="form-control" type="text">
                            </div>
                            <label class="col-sm-2 control-label">
                                第四块抽中比率配置：
                            </label>
                            <div class="col-md-4">
                                <input  onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" placeholder="请填写该奖项抽中的比率，如：80（代表抽中比率为80%）" name="angel_4" value="{{$find->angel_4 or ''}}" class="form-control rate-config" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        第五块奖项配置：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <input placeholder="请填写奖项，如：3（代表3元）" name="prize_5" value="{{$find->prize_5 or ''}}" class="form-control" type="text">
                            </div>
                            <label class="col-sm-2 control-label">
                                第五块抽中比率配置：
                            </label>
                            <div class="col-md-4">
                                <input  onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" placeholder="请填写该奖项抽中的比率，如：2（代表抽中比率为2%）" name="angel_5" value="{{$find->angel_5 or ''}}" class="form-control rate-config" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        第六块奖项配置：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <input placeholder="请填写奖项，如：3（代表3元）" name="prize_6" value="{{$find->prize_6 or ''}}" class="form-control" type="text">
                            </div>
                            <label class="col-sm-2 control-label">
                                第六块抽中比率配置：
                            </label>
                            <div class="col-md-4">
                                <input  onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" placeholder="请填写该奖项抽中的比率，如：2（代表抽中比率为2%）" name="angel_6" value="{{$find->angel_6 or ''}}" class=" form-control rate-config" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <label class="col-sm-2 control-label">总的比率：</label>
                            <div class="col-sm-3">
                                <input  id="sum123" placeholder="六块比率总和（总和必须等于100%）" disabled class="form-control" value="{{$total}}%" type="text">
                                <span style="color:red">六块比率总和（总和必须等于100%）</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        转盘开关：
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="radio">
                                    <label>
                                        <input value="1" {{$find->on_off==1?'checked':''}} checked id="optionsRadios2" name="on_off" type="radio">开&nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input value="2" {{$find->on_off==2?'checked':''}} id="optionsRadios2" name="on_off" type="radio">关
                                    </label>
                                </div>
                            </div>
                        </div>
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
    $(function(){
        var len = $(".rate-config").length;
        $(".rate-config").focus(function () {
            $(this).blur(function () {
                var sum = parseInt($(".rate-config").eq(0).val()) + parseInt($(".rate-config").eq(1).val()) + parseInt($(".rate-config").eq(2).val()) + parseInt($(".rate-config").eq(3).val()) +  parseInt($(".rate-config").eq(4).val()) +  parseInt($(".rate-config").eq(5).val());

            $("#sum123").val(sum + "%")
                console.log(sum)
            })
        })

    })
</script>