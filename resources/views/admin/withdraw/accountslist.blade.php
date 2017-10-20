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
                    <h5>转账列表</h5>
                </div>

                <div class="ibox-content">
                    <form action="{{url('withdraw/accountslist')}}" method="get">
                        <div class="input-group">
                            
                            <span style="float: right;margin-left: 10px">转出手机号：
                                <input name="phone" value="" type="text" class="input-sm"
                                       placeholder="请输入转出手机号"/>
                            </span>
                            <span style="float: right;margin-left: 10px">转入手机号：
                                <input name="pphone" value="" type="text" class="input-sm"
                                       placeholder="请输入转入手机号"/>
                            </span>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    搜索
                                </button>
                            </span>
                        </div>
                    </form>

                    <table class="footable table table-stripped" data-page-size="10" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>转出用户名</th>
                            <th>转出用户名头像</th>
                            <th>转出手机号</th>

                            <th>转入用户名</th>
                            <th>转入用户名头像</th>
                            <th>转入手机号</th>
                            <th>金额</th>
                            <th>到账金额</th>

                            <th>时间</th>
  
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($account as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->id}}</td>
                                <td>{{$v->cname}}</td>
                                <td> <img src="{{$v->cpic}}" height="50" width="50"> </td>
                                <td>{{$v->cphone}}</td>
                                <td>{{$v->jname}}</td>
                                <td> <img src="{{$v->jpic}}" height="50" width="50"> </td>
                                <td>{{$v->jphone}}</td>
                      
                                <td>{{$v->money}} 元</td>
                                <td>{{$v->truemoney}} 元</td>
    
                                <td>{{$v->out_biz_no}}</td>
                    
                       
                                <td class="center">{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                           
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td colspan="11">
                                {{ $account->links() }}
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
<script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
{{--@include('admin.layouts.fooler')--}}
<!-- 自定义js -->
<script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
<script src="{{asset('admin/js/plugins/layer/laydate/laydate.js')}}"></script>

</body>
</html>
<script type="text/javascript">
    $('.close').click(function () {
        $(this).parent().parent().remove();
    })
</script>
<script>
    //外部js调用
    laydate({
        elem: '#end', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
        event: 'focus' //响应事件。如果没有传入event，则按照默认的click
    });
    laydate({
        elem: '#start', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
        event: 'focus' //响应事件。如果没有传入event，则按照默认的click
    });
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


    $(function () {
        $('.mallGoodsDel').click(function () {
            var bool = confirm('你确定要驳回该请求吗？将不可恢复');
            if (bool) {
                var id = $(this).parent().parent().find('.did').html();

                // alert(id);
                var data = {
                    'id': id,
                }
                var url = "{{url('withdraw/fell')}}";
                sendAjax(data, url);


            }
        })

        $('.mallGoodsTong').click(function () {
            var bool = confirm('你确定要通过该请求吗？该操作将不可恢复');
            if (bool) {
                var id = $(this).parent().parent().find('.did').html();

                // alert(id);
                var data = {
                    'id': id,
                }
                var url = "{{url('withdraw/pass')}}";
                sendAjax(data, url);

            }
        })
        $('.aliCashTong').click(function(){
            var bool = confirm('你确定要通过该请求吗？该操作将不可恢复');
            if(bool){
                var id = $(this).parent().parent().find('.did').html();
                window.location.href="{{config('home.WEB')}}/withdraw/pass?id="+id;
            }
        })
        function sendAjax(data, url) {
            $.ajax({
                'url': url,
                'data': data,
                'async': true,
                'type': 'post',
                'dataType': 'json',
                success: function (data) {
                    if (data.status) {
                        alert(data.message);
                        if (data.data.flag == 1) {
                            window.location.href = "{{url('users/index')}}";
                        }
                    } else {
                        alert(data.message);
                        window.location.reload();
                    }
                },

            })
        }

    })
</script>

