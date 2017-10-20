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
                    <h5>升级信息记录列表</h5>
                </div>

                <div class="ibox-content">
                    <form action="{{url('row/promoteInfo')}}" method="get">
                        <div class="input-group">
                            <span  style="float: right;margin-left: 10px;margin-right: 10px;">请选择盘符：
                                <select name="disc" class="input-sm">
                                    <option value="">--请选择--</option>
                                    <option value="1" {{request()->disc==1?'selected':''}}>A盘</option>
                                    <option value="2" {{request()->disc==2?'selected':''}}>B盘</option>
                                    <option value="3" {{request()->disc==3?'selected':''}}>C盘</option>
                                </select>
                            </span>
                            <span  style="float: right;margin-left: 10px">当前级别：
                                <input name="current_level" type="text" class="input-sm" value="{{request()->current_level}}" placeholder="请输入当前级别"/>
                            </span>
                            <span  style="float: right;margin-left: 10px">点位ID：
                                <input name="row" type="text" class="input-sm" value="{{request()->row}}" placeholder="请输入点位ID"/>
                            </span>
                            <span  style="float: right;margin-left: 10px">用户手机号：
                                <input name="phone" type="text" value="{{request()->phone}}" class="input-sm" placeholder="请输入目标用户手机号"/>
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
                            <th>用户昵称</th>
                            <th>用户手机号</th>
                            <th>用户性别</th>
                            <th>用户头像</th>
                            <th>点位ID</th>
                            <th>来源点位ID</th>
                            <th>盘类型</th>
                            <th>当前级别</th>
                            <th>升级详细信息记录</th>
                            <th>金额</th>
                            <th>收入支出</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->id}}</td>
                                <td>{{$v->login_name}}</td>
                                <td>{{$v->nickname}}</td>
                                <td>{{$v->phone}}</td>
                                <td>{{$v->sex==1?'男':'女'}}</td>
                                <td><img src="{{asset($v->pic)}}" width="50px" height="50px"></td>
                                <td>{{$v->to_row_id==0?'平台':$v->to_row_id}}</td>
                                <td>{{$v->row_id}}</td>
                                <td>
                                    @if($v->flag==1)
                                        A盘
                                    @elseif($v->flag==2)
                                        B盘
                                    @elseif($v->flag==3)
                                        C盘
                                    @endif
                                </td>
                                <td>{{$v->current_level}}</td>
                                <td>{{$v->info}}</td>
                                <td>
                                    @if($v->mark==1)
                                        +{{$v->promote_fee}}
                                    @else
                                        -{{$v->promote_fee}}
                                    @endif

                                </td>
                                <td>
                                    @if($v->mark==1)
                                        <font color="green">收入</font>
                                    @else
                                        <font color="red">支出</font>
                                    @endif
                                </td>
                                <td>{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">共{{$res['total']}}条数据 当前第{{$res['currentPage']}}/{{$res['page']}}页</td>
                            <td colspan="11">
                                {!! $date->appends(['disc' =>request()->disc,'current_level'=>request()->current_level,'row'=>request()->row,'phone'=>request()->phone])->links() !!}
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