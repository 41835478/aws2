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
     <div class="ibox-tools">
                <a class="collapse-link btn btn-outline btn-success" href="{{url('data/oneorder')}}">
                   发放前20名业绩奖励，数据量越大响应速度越慢
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('data/configinfo')}}"  enctype="multipart/form-data" enctype="multipart/form-data" onSubmit="return check();">
             
     
    
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">每天提现次数</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="tixanshu" type="text" value="{{$res->tixanshu}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">a盘20代见点</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="zpoint_a" value="{{$res->zpoint_a}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">b盘20代见点</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="zpoint_b" value="{{$res->zpoint_b}}">
                    </div>
                </div>
         
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">c盘20代见点</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="zpoint_c" value="{{$res->zpoint_c}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">互转消费积分手续费</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="xjifen" value="{{$res->xjifen}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
               
                <div class="form-group">
                    <label class="col-sm-2 control-label">互转复投积分手续费</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="fjifen" value="{{$res->fjifen}}">
                    </div>
                </div>
          
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">提现手续费</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="tixian" value="{{$res->tixian}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">转账手续费</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="zhuanzhang" value="{{$res->zhuanzhang}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">二级分销</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="erjifenxiao" value="{{$res->erjifenxiao}}">
                    </div>
                </div>
                 <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">一级分销</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="yijifenxiao" value="{{$res->yijifenxiao}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">业绩前二十名返现比</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="fanxian" value="{{$res->fanxian}}">
                    </div>
                </div>
           
                <div class="hr-line-dashed"></div>
                <input type="hidden" name="id" value="{{$res->id}}">
                
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit" name="dosubmit">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
<script type="text/javascript">


</script>
