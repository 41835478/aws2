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
                    <h5>幸运转盘列表</h5>
                </div>

                <div class="ibox-content">
                    <form action="{{url('adminWheel/wheelList')}}" method="get">
                        <div class="input-group">
                            <span  style="float: right;margin-left: 10px;margin-right: 10px;">请选择奖品：
                                <select name="prize" class="input-sm">
                                    <option value="">--请选择--</option>
                                    @if($wheel)
                                        <option value="{{$wheel->prize_1}}" {{request()->prize==$wheel->prize_1?'selected':''}}>{{$wheel->prize_1}}</option>
                                        <option value="{{$wheel->prize_2}}" {{request()->prize==$wheel->prize_2?'selected':''}}>{{$wheel->prize_2}}</option>
                                        <option value="{{$wheel->prize_3}}" {{request()->prize==$wheel->prize_3?'selected':''}}>{{$wheel->prize_3}}</option>
                                        <option value="{{$wheel->prize_4}}" {{request()->prize==$wheel->prize_4?'selected':''}}>{{$wheel->prize_4}}</option>
                                        <option value="{{$wheel->prize_5}}" {{request()->prize==$wheel->prize_5?'selected':''}}>{{$wheel->prize_5}}</option>
                                        <option value="{{$wheel->prize_6}}" {{request()->prize==$wheel->prize_6?'selected':''}}>{{$wheel->prize_6}}</option>
                                    @endif
                                </select>
                            </span>
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
                            <th>用户性别</th>
                            <th>用户头像</th>
                            <th>抽奖次数</th>
                            <th>抽中的奖品</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date as $v)
                            <tr class="gradeX">
                                <td class="did">{{$v->id}}</td>
                                <td>{{$v->login_name or ''}}</td>
                                <td>{{$v->phone}}</td>
                                <td>{{$v->sex==1?'男':'女'}}</td>
                                <td><img src="{{asset($v->pic)}}" width="50px" height="50px"></td>
                                <td>{{$v->lucky}}</td>
                                <td>{{$v->prize}}</td>
                                <td>{{date('Y-m-d H:i:s',$v->create_at)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">共{{$res['total']}}条数据 当前第{{$res['currentPage']}}/{{$res['page']}}页</td>
                            <td colspan="11">
                                {!! $date->appends(['phone'=>request()->phone,'prize'=>request()->prize])->links() !!}
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