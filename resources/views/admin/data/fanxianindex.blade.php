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
      <!--       <div class="ibox-tools">
                <a class="collapse-link btn btn-outline btn-success" href="{{url('goods/goodsList')}}">
                    返回
                </a>
            </div> -->
        </div>
        <div class="ibox-content">
          
             
     
    
             
                
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit" name="dosubmit">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      
                    </div>
                </div>
            
        </div>
    </div>
</div>

<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
</body>
</html>
<script type="text/javascript">


</script>
