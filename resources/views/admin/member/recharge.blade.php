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
                    <h5>用户充值记录表</h5>
                </div>

                <div class="ibox-content">
                    <form action="{{url('member/recharge')}}" method="get">
                        <div class="input-group">
                        <!--     <span  style="float: right;margin-left: 10px;margin-right: 10px;">请选择盘符：
                                <select name="disc" class="input-sm">
                                    <option value="">--请选择--</option>
                                    <option value="1" {{request()->disc==1?'selected':''}}>A盘</option>
                                    <option value="2" {{request()->disc==2?'selected':''}}>B盘</option>
                                    <option value="3" {{request()->disc==3?'selected':''}}>C盘</option>
                                </select>
                            </span> -->
                            <span  style="float: right;margin-left: 10px">用户手机号：
                                <input name="phone" type="text" class="input-sm" value="{{request()->phone}}" placeholder="请输入用户手机号"/>
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
                            <th>用户名称</th>
                            <th>用户手机号</th>
                            <th>用户头像</th>
                            <th>充值金额</th>
                            <th>添加/减少</th>
                          <!--   <th>用户充值前余额</th> -->
                            <th>充值时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->id}}</td>
                                <td>{{$v->login_name}}</td>
                                <td>{{$v->phone}}</td>
                                <td><img src="{{asset($v->pic)}}" width="50px" height="50px"></td>
                                <td>{{$v->money}} 元</td>
                                <td> @if($v->status == 1) 增加
                                		@elseif($v->status == 2) 减少
                                		@else 未知
                                		@endif
                                </td>
                                
                               <!--  <td>{{$v->account}} 元</td> -->
                                <td>{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">共{{$res['total']}}条数据 当前第{{$res['currentPage']}}/{{$res['page']}}页</td>
                            <td colspan="11">
                                {!! $date->appends(['disc'=>request()->disc,'phone'=>request()->phone])->links() !!}
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
</body>
</html>