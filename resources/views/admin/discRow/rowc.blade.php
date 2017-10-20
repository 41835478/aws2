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
                    <h5>C盘点位列表</h5>
                </div>

                <div class="ibox-content">
                    <form action="{{url('discRow/rowc')}}" method="get">
                        <div class="input-group">
                            <span  style="float: right;margin-left: 10px;margin-right: 10px;">请选择点位状态：
                                <select name="status" class="input-sm">
                                    <option value="">--请选择--</option>
                                    <option value="1" {{request()->status==1?'selected':''}}>未出局</option>
                                    <option value="2" {{request()->status==2?'selected':''}}>已出局</option>
                                </select>
                            </span>
                            <span  style="float: right;margin-left: 10px;margin-right: 10px;">请选择等级：
                                <select name="level" class="input-sm">
                                    <option value="">--请选择--</option>
                                    <option value="1" {{request()->level==1?'selected':''}}>1 级</option>
                                    <option value="2" {{request()->level==2?'selected':''}}>2 级</option>
                                    <option value="3" {{request()->level==3?'selected':''}}>3 级</option>
                                    <option value="4" {{request()->level==4?'selected':''}}>4 级</option>
                                    <option value="5" {{request()->level==5?'selected':''}}>5 级</option>
                                    <option value="6" {{request()->level==6?'selected':''}}>6 级</option>
                                    <option value="7" {{request()->level==7?'selected':''}}>7 级</option>
                                    <option value="8" {{request()->level==8?'selected':''}}>8 级</option>
                                </select>
                            </span>
                            <span  style="float: right;margin-left: 10px;margin-right: 10px;">请选择代数：
                                <select name="generate" class="input-sm">
                                    <option value="">--请选择--</option>
                                    <option value="1" {{request()->generate==1?'selected':''}}>1 代</option>
                                    <option value="2" {{request()->generate==2?'selected':''}}>2 代</option>
                                    <option value="3" {{request()->generate==3?'selected':''}}>3 代</option>
                                    <option value="4" {{request()->generate==4?'selected':''}}>4 代</option>
                                    <option value="5" {{request()->generate==5?'selected':''}}>5 代</option>
                                    <option value="6" {{request()->generate==6?'selected':''}}>6 代</option>
                                    <option value="7" {{request()->generate==7?'selected':''}}>7 代</option>
                                    <option value="8" {{request()->generate==8?'selected':''}}>8 代</option>
                                </select>
                            </span>
                            <span  style="float: right;margin-left: 10px">用户手机号：
                                <input name="phone" type="text" value="{{request()->phone}}" class="input-sm" placeholder="请输入用户手机号"/>
                            </span>
                            <span  style="float: right;margin-left: 10px">当前点位：
                                <input name="row" type="text" value="{{request()->row}}" class="input-sm" placeholder="输入当前点位查下级点位"/>
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
                            <th>用户性别</th>
                            <th>用户头像</th>
                            <th>订单ID</th>
                            <th>上面的点位ID</th>
                            <th>当前层级</th>
                            <th>当前等级</th>
                            <th>当前代数</th>
                            <th>点位状态</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->id}}</td>
                                <td>{{$v->login_name}}</td>
                                <td>{{$v->phone}}</td>
                                <td>{{$v->sex==1?'男':'女'}}</td>
                                <td><img src="{{asset($v->pic)}}" width="50px" height="50px"></td>
                                <td>{{$v->order_id}}</td>
                                <td>{{$v->prev_id}}</td>
                                <td>第 {{$v->level}} 层</td>
                                <td>第 {{$v->current_level}} 级</td>
                                <td>第 {{$v->current_generate}} 代</td>
                                <td>{{$v->status==1?'未出局':'已出局'}}</td>
                                <td>{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">共{{$res['total']}}条数据 当前第{{$res['currentPage']}}/{{$res['page']}}页</td>
                            <td colspan="11">
                                {!! $date->appends(['status'=>request()->status,'level'=>request()->level,'generate'=>request()->generate,'phone'=>request()->phone,'row'=>request()->row])->links() !!}
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