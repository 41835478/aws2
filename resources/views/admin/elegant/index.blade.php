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
                    <h5>贵人币列表</h5>
                    <div class="ibox-tools">
                        <a href="{{url('elegant/export')}}" class="btn btn-outline btn-success">导出数据</a>
                    </div>
                </div>

                <div class="ibox-content">
                    <form action="{{url('elegant/elegantList')}}" method="get">
                        <div class="input-group">
                            <span  style="float: right;margin-left: 10px;margin-right: 10px">经纪人名称：
                                <input name="agent_name" value="{{request()->agent_name}}" type="text" class="input-sm" placeholder="请输入经纪人名称"/>
                            </span>
                            <span  style="float: right;margin-left: 10px">手机号：
                                <input name="mobile" value="{{request()->mobile}}" type="text" class="input-sm" placeholder="请输入手机号"/>
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
                            <th>性别</th>
                            <th>手机号</th>
                            <th>身份证号</th>
                            <th>身份证正面</th>
                            <th>身份证背面</th>
                            <th>手持身份证</th>
                            <th>经纪人</th>
                            <th>用户地址</th>
                            <th>用户所属银行开户行名称</th>
                            <th>用户开户行名称</th>
                            <th>用户银行卡号</th>
                            <th>用户银行卡正面</th>
                            <th>注册时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->id}}</td>
                                <td>{{$v->name}}</td>
                                <td>{{$v->sex}}</td>
                                <td>{{$v->mobile}}</td>
                                <td>{{$v->ID_code}}</td>
                                <td><img src="{{asset($v->identity_front)}}" width="50px" height="50px"></td>
                                <td><img src="{{asset($v->identity_back)}}" width="50px" height="50px"></td>
                                <td><img src="{{asset($v->identity_hold)}}" width="50px" height="50px"></td>
                                <td>{{$v->agent_name}}</td>
                                <td>{{$v->address}}</td>
                                <td>{{$v->bank_name}}</td>
                                <td>{{$v->account_name}}</td>
                                <td>{{$v->bank_code}}</td>
                                <td><img src="{{asset($v->bank_img)}}" width="50px" height="50px"></td>
                                <td>{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3">共{{$res['total']}}条数据 当前第{{$res['currentPage']}}/{{$res['page']}}页</td>
                            <td colspan="12">
                                {!! $date->appends(['agent_name'=>request()->agent_name,'mobile'=>request()->mobile])->links() !!}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
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