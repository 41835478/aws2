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
                    <h5> <a   href="javascript:history.go(-1)" class="btn  btn-success">返回</a></h5>
                   

                </div>
      
                    <table class="footable table table-stripped" data-page-size="10" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>商品名</th>
                            <th>类型</th>
                            <th>数量</th>
                            <th>价格</th>
                            <th>商品图片</th>
                      
                        </tr>
                        </thead>
                        <tbody>
                           
                            <tr class="gradeX">

                                @foreach($info as $v)
                                <td>{{$v['name']}}</td>
                               
                                <td>   @if($v['type'] ==1) 普通商城
                                        @elseif($v['type']==2)积分商城
                                         @elseif($v['type']==3)合作商城
                                          @elseif($v['type']==4)100专区
                                           @elseif($v['type']==5)300专区
                                            @elseif($v['type']==6)2000专区

                                        @endif </td>
                                 <td>{{$v['num']}}</td>
                                 <td>{{$v['price']}}</td>
                                <td><img src="/{{$v['pic']}}" height="50" width="50"></td>
                               
                                <td class="center">
                                @endforeach

                                </td>
                            </tr>
                      
                        </tbody>
                        <tfoot>
                        <tr>

                          
                            
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 全局js -->
@include('admin.layouts.fooler')

<!-- 自定义js -->
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>


<!-- 自定义js -->
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
<script src="{{asset('admin/js/plugins/layer/laydate/laydate.js')}}"></script>

</body>
</html>
