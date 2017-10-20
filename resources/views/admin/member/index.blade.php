<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts.header')
    <link href="{{asset('layui/css/layui.css')}}" rel="stylesheet">
    <style>
        .did:hover {
            cursor: pointer;
        }

        .userInfo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.8);
            z-index: 90000;
            display: none;
        }

        .userInfo table {
            background: #fff;
        }

        .closeInfo {
            text-align: right;
            padding-right: 5%;
            color: #f00;
            font-family: "微软雅黑";
            font-size: 16px;
            line-height: 40px;
            background: #fff;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }
    </style>
</head>


<body class="gray-bg">
<div class="userInfo">
    <p class="closeInfo">点击关闭</p>
    <table id="nextUser" class="footable table table-stripped " data-page-size="10" data-filter=#filter>
        <thead>
        <tr>
            <th>ID</th>
            <th>会员真实姓名</th>
            <th>会员昵称</th>
            <th>性别</th>
            <th>级别</th>
            <th>会员手机号</th>
            <th>会员余额</th>
        </tr>
        </thead>
        <tbody>
        <tr class="gradeX">
            <td class="did"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="center"></td>
            <td class="center"></td>
        </tr>
        </tbody>
    </table>
</div>
@include('admin.layouts.box')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>会员列表</h5>

                    {{--<h5>--}}
                    {{--<a style="margin-bottom: 10px;background: #fffced;border: 1px solid #ffbe7a;padding: 8px 10px;"--}}
                    {{--href="javascript:;" class="goodsClassDel">重置购买次数--}}
                    {{--</a>--}}
                    {{--</h5>--}}
                </div>


                <form action="{{url('member/index')}}" method="get">
                    <div class="explain-col"
                         style="margin-bottom: 10px;background: #fffced;border: 1px solid #ffbe7a;padding: 8px 10px;">
                        <div class="input-group">
        <span style="float: left;margin-left: 25px">

        <input id="end" name="end" class="laydate-icon" placeholder="请选择结束时间"></span>
                            <span style="float: left;margin-left: 25px">
        <input id="start" name="start" class="form-control layer-date laydate-icon" placeholder="请选择开始时间"
               onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></span>
                            <span style="float: left;margin-left: 5px">用户类型：
                                <select style="border:1px solid #ccc;" name="level" class="input-sm">
                                    <option value="">--请选择用户类型--</option>
                                    <option value="0">游客</option>
                                    <option value="1">批发商</option>
                                </select>
                            </span>
                            <span style="float: left;margin-left: 5px">用户状态：
                                <select style="border:1px solid #ccc;" name="status" class="input-sm">
                                    <option value="">--请选择用户状态--</option>
                                    <option value="1" {{request()->status==1?'selected':''}}>登录</option>
                                    <option value="2" {{request()->status==2?'selected':''}}>未登录</option>
                                </select>
                            </span>
                            <span style="float: left;margin-left: 5px">手机号：<input style="border:1px solid #ccc;"
                                                                                  name="phone"
                                                                                  value="{{request()->phone}}"
                                                                                  placeholder="请输入手机号"
                                                                                  class="input-sm" type="text"></span>
                            <span style="float: left;margin-left: 5px">推荐人手机号：<input style="border:1px solid #ccc;"
                                                                                     name="pphone"
                                                                                     placeholder="请输入推荐人手机号："
                                                                                     value="{{request()->pphone}}"
                                                                                     class="input-sm"
                                                                                     type="text"></span>
                            <span style="float: left;margin-left: 5px">用户名：<input style="border:1px solid #ccc;"
                                                                                  name="name" placeholder="请输入用户名"
                                                                                  class="input-sm" type="text"></span>
                            <span class="input-group-btn" style="float: left;margin-left: 25px">
            <button type="submit" class="btn btn-sm btn-primary">
                搜索
            </button>
        </span>
                        </div>
                    </div>
                </form>
                <table class="footable table table-stripped" data-page-size="10" data-filter=#filter>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>推荐人手机号</th>
                        <th>推荐人ID</th>
                        <th>会员昵称</th>
                        <th>会员头像</th>
                        <th>会员真实姓名</th>
                        <th>级别</th>
                        <th>会员手机号</th>
                        <th>会员当前状态</th>
                        <th>会员注册时间</th>
                        <th>会员登录时间</th>
                        <th>会员余额</th>
                        <th>a盘次数</th>
                        <th>b盘次数</th>
                        <th>c盘次数</th>
                        <th>锁定账号</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($memberclass as $v)
                        <tr class="gradeX">
                            <td class="did">{{$v->id}}</td>
                            <td>{{$v->pphone}}</td>
                            <td>{{$v->pid}}</td>
                            <td>{{$v->name}}</td>
                            <td>
                                @if($v->pic=='') 暂无
                                @else
                                    <img src="{{$v->pic}}" height="50" width="50">
                                @endif
                            </td>
                            <td>{{$v->login_name}}</td>

                            <td>@if ($v->level == 0) 游客
                                @elseif($v->level == 1)
                                    批发商

                                @endif </td>
                            <td>{{$v->phone}} </td>
                            <td>
                                @if($v->status==1)
                                    <font color="red">登录</font>
                                @else
                                    <font color="#ccc">未登录</font>
                                @endif
                            </td>
                            <td class="center">{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                            <td class="center">
                                @if($v->login_at)
                                    {{date('Y-m-d H:i:s',$v->login_at)}}
                                @endif
                            </td>
                            <td class="center">{{$v->account}}</td>
                            <td>{{$v->rob_point_num_a}} </td>
                            <td>{{$v->rob_point_num_b}} </td>
                            <td>{{$v->rob_point_num_c}} </td>
                            <td>
                                @if($v->locking==1)
                                    <font color="#ccc">锁定</font> | <font color="green" style="cursor:pointer"
                                                                         class="unlocking">解锁</font>
                                @elseif($v->locking==2)
                                    <font color="green" style="cursor:pointer" class="locking">锁定</font> | <font
                                            color="#ccc">解锁</font>
                                @endif
                            </td>
                            <td class="center">
                                <a href="{{url('member/edit',['id'=>$v->id])}}">修改</a> |
                                <a href="{{url('member/sheng',['id'=>$v->id])}}">购买</a> |
                                <a href="javascript:;" class="loginPwd">修改登录密码</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>

                        <td colspan="7">共{{$total}}条数据 当前第{{$currentPage}}/{{$page}}页</td>
                        <td colspan="10">
                            {!! $memberclass->appends(['status'=>request()->status,'level'=>request()->level,'phone'=>request()->phone,'pphone'=>request()->pphone])->links() !!}
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

<script src="{{asset('layui/layui.js')}}"></script>
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
    $(function () {
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
        $('.goodsClassDel').click(function () {
            var id = $(this).parent().parent().find('.did').html();
            var sure = confirm("你确信要执行该操作吗？无法找回")
            if (sure == true) {
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                });

                $.ajax({
                    'url': '{{url("crontab/index")}}',
                    // 'data':{'id':id},
                    'async': true,
                    'type': 'get',
                    'dataType': 'json',
                    success: function (data) {
                        if (data.status) {
                            parent.layer.msg(data.message);
                            window.location.reload();
                        } else {
                            parent.layer.msg(data.message);
                            window.location.reload();
                        }
                    },
                    error: function () {
                        alert('Ajax响应失败');
                    }
                })
            }
        })

        // $('.goodsClassDel').click(function(){
        //     var id=$(this).parent().parent().find('.did').html();
        //     var sure=confirm("你确信要删除该条数据吗？删除将无法找回")
        //     if(sure==true){
        //         $.ajaxSetup({
        //             headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        //         });
        //         $.ajax({
        //             'url':'{{url("member/del")}}',
        //             'data':{'id':id},
        //             'async':true,
        //             'type':'post',
        //             'dataType':'json',
        //             success:function(data){
        //                 if(data.status){
        //                     parent.layer.msg(data.message);
        //                     window.location.reload();
        //                 }else{
        //                     parent.layer.msg(data.message);
        //                     window.location.reload();
        //                 }
        //             },
        //             error:function(){
        //                 alert('Ajax响应失败');
        //             }
        //         })
        //     }
        // })
        $('.unDisplay').click(function () {
            var id = $(this).parent().parent().find('.did').html();
            var flag = 2;
            var data = {
                'id': id,
                'flag': flag,
            };
            displayAjax(data)
        })
        $('.display').click(function () {
            var id = $(this).parent().parent().find('.did').html();
            var flag = 1;
            var data = {
                'id': id,
                'flag': flag,
            };
            displayAjax(data)
        })
        function displayAjax(data) {
            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
            });
            $.ajax({
                'url': '{{url("goodsClass/whetherDisplay")}}',
                'data': data,
                'async': true,
                'type': 'post',
                'dataType': 'json',
                success: function (data) {
                    if (data.status) {
                        parent.layer.alert(data.message, {
                            icon: 1,
                            skin: 'layer-ext-moon'
                        })
                    } else {
                        alert(data.message);
                    }
                    window.location.reload();
                },
                error: function () {
                    alert('Ajax响应失败');
                }
            })
        }

        $('#topLevel').change(function () {
            $(".optionlist").remove();
            var id = $(this).val();
            if (id != '') {
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                });
                $.ajax({
                    'url': '{{url("goodsClass/secondClass")}}',
                    'data': {'id': id},
                    'async': true,
                    'type': 'post',
                    'dataType': 'json',
                    success: function (data) {
                        if (data.status == true) {
                            $.each(data.data, function (index, value) {
                                var opt = '<option class="optionlist" value=' + value.id + '>' + value.name + '</option>';
                                $("#select_opts").append(opt);
                            })

                        } else {
                            alert(data.message);
                        }
                    },
                    error: function () {
                        alert('Ajax响应失败');
                    }
                })
            }
        })
    })
</script>
<script>
    $(".closeInfo").off().on("click", function () {
        $(".userInfo").fadeOut(400);
    })
    cli()
    function cli() {
        $(".did").off().on("click", function () {
            var id = $(this).text();
            $.ajax({
                'url': '{{url("member/nextUser")}}',
                'data': {'id': id, '_token': "{{csrf_token()}}"},
                'async': true,
                'type': 'post',
                'dataType': 'json',
                success: function (res) {
                    if (res.status == true) {
                        $("#nextUser tbody").html("");
                        var con = ""
                        for (i in res.data) {
                            con += '<tr class="gradeX"> <td class="did">' + res.data[i].id + '</td> <td>' + res.data[i].login_name + '</td> <td>' + res.data[i].name + '</td> <td>' + res.data[i].sex + '</td> <td>' + res.data[i].level + '</td> <td class="center">' + res.data[i].phone + '</td> <td class="center">' + res.data[i].account + '</td></tr>'
                        }
                        $("#nextUser tbody").append(con);
                        $(".userInfo").fadeIn(400);
                        cli()
                    } else {
                        alert(res.message)
                    }
                },
            })
        })
    }
</script>
<script>
    $(function () {
        $('.unlocking').click(function () {
            var id = $(this).parent().parent().find('.did').html();
            var url = "{{url('member/locking')}}";
            var data = {
                'id': id,
                'flag': 2,
                '_token': "{{csrf_token()}}"
            };
            sendAjax(url, data)
        })
        $('.locking').click(function () {
            var id = $(this).parent().parent().find('.did').html();
            var url = "{{url('member/locking')}}";
            var data = {
                'id': id,
                'flag': 1,
                '_token': "{{csrf_token()}}"
            };
            sendAjax(url, data)
        })
        function sendAjax(url, data) {
            $.ajax({
                'url': url,
                'data': data,
                'async': true,
                'type': 'post',
                'dataType': 'json',
                success: function (res) {
                    alert(res.message);
                    window.location.reload();
                },
                error: function () {
                    alert('Ajax响应失败');
                }
            })
        }
    })
</script>
<script>
    $('.loginPwd').click(function () {
        var pwd = prompt("请输入要修改为的登录密码", "")
        if (pwd) {
            if (confirm("你确信要修改该会员的登录密码为：" + pwd + "？")) {
                var id = $(this).parent().parent().find('.did').html();
                $.ajax({
                    'url': '{{url("member/loginPwd")}}',
                    'data': {'id': id, 'pwd': pwd, '_token': "{{csrf_token()}}"},
                    'async': true,
                    'type': "post",
                    'dataType': "json",
                    success: function (res) {
                        alert(res.message);
                        window.location.reload()
                    },
                    error: function () {
                        alert('Ajax响应失败');
                    }
                })
            }
        }
    })
</script>