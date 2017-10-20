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
              <!--   <div class="ibox-title">
                    <h5>订单列表</h5>
                    <div class="ibox-tools">
                        <a href="{{url('order/export')}}" class="btn btn-outline btn-success">导出用户数据</a>
                    </div>

                </div> -->



         <form action="{{url('order/index')}}" method="get">
       <div class="explain-col" style="margin-bottom: 10px;background: #fffced;border: 1px solid #ffbe7a;padding: 8px 10px;">
    <div class="input-group">
        <span  style="float: left;margin-left: 25px">

        <input id="end" name="end" class="laydate-icon" placeholder="请选择结束时间"></span>
        <span  style="float: left;margin-left: 25px">
        <input id="start" name="start" class="form-control layer-date laydate-icon" placeholder="请选择开始时间"  onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></span>


        <span  style="float: left;margin-left: 25px">支付类型：
            <select style="border:1px solid #ccc;" name="type" class="input-sm">
                <option value="">--支付类型--</option>
                <option value="1">微信</option>
                <option value="2">支付宝</option>
                <option value="3">余额</option>
                <option value="4">积分</option>
                <option value="5">银行卡</option> 
                <option value="6">系统</option>      
            </select>
        </span>
         <span  style="float: left;margin-left: 25px">订单状态：
            <select style="border:1px solid #ccc;" name="status" class="input-sm">
                <option value="">--订单状态--</option>
                <option value="1">待付款</option>
                <option value="2">待发货</option>
                <option value="3">已发货</option>
                <option value="4">已收货</option>
                <option value="5">已完成</option>      
            </select>
        </span>
        <span  style="float: left;margin-left: 25px">手机号：<input style="border:1px solid #ccc;" name="phone" placeholder="请输入手机号" class="input-sm" type="text"></span>
         <span  style="float: left;margin-left: 25px">用户名：<input style="border:1px solid #ccc;" name="name" placeholder="请输入用户名" class="input-sm" type="text"></span>       
        <span class="input-group-btn" style="float: left;margin-left: 25px">
            <button type="submit" class="btn btn-sm btn-primary">
                搜索
            </button>
        </span>
    </div>
    </div>
</form>

   <form action="{{url('order/export')}}" method="get">
       <div class="explain-col" style="margin-bottom: 10px;background: #fffced;border: 1px solid #ffbe7a;padding: 8px 10px;">
    <div class="input-group">
       <span  style="float: left;margin-left: 25px">

        <input id="end" name="end" class="laydate-icon" placeholder="请选择结束时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></span>
        <span  style="float: left;margin-left: 25px">
        <input id="start" name="start" class="form-control layer-date laydate-icon" placeholder="请选择开始时间"  onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></span>
     
         <span  style="float: left;margin-left: 25px">订单状态：
            <select style="border:1px solid #ccc;" name="status" class="input-sm">
                <option value="">--订单状态--</option>
                <option value="1">待付款</option>
                <option value="2">待发货</option>
                <option value="3">已发货</option>
                <option value="4">已收货</option>
                <option value="5">已完成</option>      
            </select>
        </span>
      
          
        <span class="input-group-btn" style="float: left;margin-left: 25px">
            <button type="submit" class="btn btn-sm btn-primary">
                导出
            </button>
        </span>
    </div>
    </div>
</form>


                    <table class="footable table table-stripped" data-page-size="10" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>用户名</th>
                            <th>收货人手机号</th>
                            <th>支付类型</th>
                            <th>数量</th>
                            <th>订单状态</th>
                            <th>下单时间</th>
                            <th>收货地址</th>
                         
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderclass as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->order_code}}</td>
                                <td>{{$v->name}}</td>
                                 <td>{{$v->phone}}</td>
                                <td>@if ($v->type == 1) 微信
                                    @elseif($v->type == 2)
                                        支付宝
                                    @elseif($v->type == 3)
                                        余额
                                    @elseif($v->type == 5)
                                        银行卡
                                    @elseif($v->type == 6)
                                        系统
                                    @elseif($v->type == 4)
                                    积分
                                    @endif</td>
                                  
                               
                                <td>{{$v->order_num}} </td>
                                <td>@if ($v->status == 1) 待付款
                                    @elseif($v->status == 2)
                                        已付款
                                    @elseif($v->status == 3)
                                        已发货
                                     @elseif($v->status == 4)
                                     已收货
                                      @elseif($v->status == 5)
                                      交易完成
                                    @endif </td>
                                
                                
                                <td class="center">{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                        
                                
                                <td class="center">{{$v->address}}</td>
                                   
                                
                                <td class="center">
                                @if ($v->status == 1) <a style="color:#F00">无法操作</a>
                                    @elseif ($v->status == 2) 
                                       <a href="{{url('order/edit',['id'=>$v->id])}}" style="color:#00F">发货</a>|
                                    @elseif ($v->status != 1 && $v->status != 2) 

                                    @endif
                                    
                                    <a href="{{url('order/orderinfo',['id'=>$v->id])}}">详情</a>  <!-- |
                                    <a href="javascript:;" class="goodsClassDel">删除</a> -->
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                        <tfoot>
                        <tr>

                            <td colspan="4">共{{$total}}条数据 当前第{{$currentPage}}/{{$page}}页</td>
                            <td colspan="8">
                                {!! $orderclass->appends(['type'=>request()->type])->links() !!}
                            </td>
                               
                            </td>
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
<script>
    //日期范围限制
    var start = {
        elem: '#start',
        format: 'YYYY/MM/DD hh:mm:ss',
        min: laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY/MM/DD hh:mm:ss',
        min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
        choose: function (datas) {
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);
</script>
</body>
</html>
<script type="text/javascript">
    $(function(){
        // $('.sort').blur(function(){
        //     var id=$(this).parent().parent().find('.did').html();
        //     var sort=$(this).val();
        //     if(sort!=''&&sort!=null){
        //         $.ajaxSetup({
        //             headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        //         });
        //         $.ajax({
        //             'url':'{{url("goodsClass/sort")}}',
        //             'data':{'id':id,'sort':sort},
        //             'async':true,
        //             'type':'post',
        //             'dataType':'json',
        //             success:function(data){
        //                 if(data.status){
        //                     parent.layer.alert(data.message, {
        //                         icon: 1,
        //                         skin: 'layer-ext-moon'
        //                     })
        //                 }else{
        //                     alert(data.message);
        //                 }
        //                 window.location.reload();
        //             },
        //             error:function(){
        //                 alert('Ajax响应失败');
        //             }
        //         })
        //     }
        // })
        $('.goodsClassDel').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var sure=confirm("你确信要删除该条数据吗？删除将无法找回")
            if(sure==true){
                $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                });
                $.ajax({
                    'url':'{{url("order/del")}}',
                    'data':{'id':id},
                    'async':true,
                    'type':'post',
                    'dataType':'json',
                    success:function(data){
                        if(data.status){
                            parent.layer.msg(data.message);
                            window.location.reload();
                        }else{
                            parent.layer.msg(data.message);
                            window.location.reload();
                        }
                    },
                    error:function(){
                        alert('Ajax响应失败');
                    }
                })
            }
        })
        $('.unDisplay').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var flag=2;
            var data={
                'id':id,
                'flag':flag,
            };
            displayAjax(data)
        })
        $('.display').click(function(){
            var id=$(this).parent().parent().find('.did').html();
            var flag=1;
            var data={
                'id':id,
                'flag':flag,
            };
            displayAjax(data)
        })
        function displayAjax(data)
        {
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
            $.ajax({
                'url':'{{url("goodsClass/whetherDisplay")}}',
                'data':data,
                'async':true,
                'type':'post',
                'dataType':'json',
                success:function(data){
                    if(data.status){
                        parent.layer.alert(data.message, {
                            icon: 1,
                            skin: 'layer-ext-moon'
                        })
                    }else{
                        alert(data.message);
                    }
                    window.location.reload();
                },
                error:function(){
                    alert('Ajax响应失败');
                }
            })
        }
        $('#topLevel').change(function(){
            $(".optionlist").remove();
            var id=$(this).val();
            if(id!=''){
                $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                });
                $.ajax({
                    'url':'{{url("goodsClass/secondClass")}}',
                    'data':{'id':id},
                    'async':true,
                    'type':'post',
                    'dataType':'json',
                    success:function(data){
                        if(data.status==true){
                            $.each(data.data,function(index,value){
                                var opt = '<option class="optionlist" value='+value.id+'>' + value.name + '</option>';
                                $("#select_opts").append(opt);
                            })

                        }else{
                            alert(data.message);
                        }
                    },
                    error:function(){
                        alert('Ajax响应失败');
                    }
                })
            }
        })
    })
</script>