<!DOCTYPE html>
<html>

<head>
    @include('admin.layouts.header')
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        @if (Session::has('pic'))
                                            <img src="{{Session::get('pic')}}" style="border-radius:40px" width="80px"
                                                 height="80px">
                                        @else
                                            <img src="{{asset('admin/img/a6.jpg')}}" style="border-radius:40px"
                                                 width="80px" height="80px">
                                        @endif
                                    </span>
                                </span>
                        </a>
                    </div>
                    <div class="logo-element">网站后台
                    </div>
                </li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a class="J_menuItem" href="{{url('index/index')}}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">首页</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-television"></i>
                        <span class="nav-label">网站开关设置</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('onOff/webOnOff')}}">网站前台开关设置</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span class="nav-label">管理员管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('user/index')}}">修改管理员密码</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{url('user/editInfo')}}">修改管理员信息</a>
                        </li>
                    </ul>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">众筹专区</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">商品管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('admin2/goods/index')}}">添加商品</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('admin2/goods/goodsList')}}">众筹商品列表</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">订单管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('admin2/order/index')}}">订单列表</a>
                    </ul>

                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">众筹管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('admin2/investments')}}">众筹列表</a>
                        <li><a class="J_menuItem" href="{{url('admin2/data/index')}}">数据统计</a>
                        <li><a class="J_menuItem" href="{{url('admin2/data/configindex')}}">参数配置</a>
                    </ul>

                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">用户管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('admin2/users/index')}}">用户列表</a>
                    </ul>

                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">用户专区</span>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span class="nav-label">会员管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('member/index')}}">会员列表</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{url('member/addUser')}}">添加会员</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{url('member/recharge')}}">会员充值记录列表</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="nav-label">数据统计</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('data/index')}}">数据统计</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-user-plus"></i>
                        <span class="nav-label">贵人币管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('elegant/elegantList')}}">贵人币列表</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-flask"></i>
                        <span class="nav-label">项目参数</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('data/configindex')}}">参数设置</a>
                        </li>

                    </ul>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>

                <li>
                    <a href="javaScript:;">
                        <i class="fa fa-envelope"></i>
                        <span class="nav-label">首页配置</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('banner/index')}}">轮播图列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('banner/noticeindex')}}">系统公告</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('banner/briefindex')}}">网站简介列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('banner/novvveindex')}}">新手必看</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="javaScript:;">
                        <i class="fa fa-soccer-ball-o"></i>
                        <span class="nav-label">幸运转盘管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('adminWheel/index')}}">大转盘配置</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('adminWheel/wheelList')}}">幸运转盘列表</a>
                        </li>
                    </ul>
                </li>

                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">商品分类管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('goodsClass/index')}}">添加商品分类</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('goodsClass/list')}}">商品分类列表</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">商品管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('goods/index')}}">添加商品</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('goods/goodsList')}}">商城商品列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('goods/goodsAreaList')}}">专区商品列表</a>
                        </li>
                    </ul>
                </li>

                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">订单管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('order/index')}}">订单列表</a>
                    </ul>

                </li>
                <li>
                    <a href="javascript:;"><i class="fa fa-envelope"></i> <span class="nav-label">提现管理 </span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('withdraw/cashList')}}">提现列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('withdraw/accountslist')}}">转账列表</a>
                        </li>
                    </ul>
                </li>

                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">分销(消费)管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('sale/index')}}">分销列表</a>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('sale/account')}}">用户账户记录列表</a>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;"><i class="fa fa-envelope"></i> <span class="nav-label">公排管理 </span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('row/index')}}">点位升级列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('row/point')}}">见点奖列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('row/recommend')}}">推荐奖列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('row/promote')}}">升级奖列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('row/rowOrder')}}">排位订单记录列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('row/promoteInfo')}}">升级信息记录列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('row/integral')}}">积分列表</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">三网公排管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('discRow/index')}}">A盘公排列表</a>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('discRow/rowb')}}">B盘公排列表</a>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('discRow/rowc')}}">C盘公排列表</a>
                    </ul>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bars"></i> <span class="nav-label">微信底部菜单管理</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('menu/index')}}">添加微信一级菜单</a>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('menu/editFirstNav')}}">修改微信一级菜单</a>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('menu/nav')}}">添加微信底部菜单</a>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('menu/menuList')}}">微信菜单列表</a>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-info "
                                              href="javascript:;"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a href="{{url('login/layout')}}">
                            <i class="fa fa-power-off">退出</i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe id="J_iframe" width="100%" height="100%" src="{{url('index/index')}}" frameborder="0"
                    data-id="{{url('index/header')}}" seamless></iframe>
        </div>
    </div>
    <!--右侧部分结束-->
</div>

<!-- 全局js -->
@include('admin.layouts.fooler');

<!-- 自定义js -->
<script src="{{asset('admin/js/hAdmin.js?v=4.1.0')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/index.js')}}"></script>
<!-- 第三方插件 -->
<script src="{{asset('admin/js/plugins/pace/pace.min.js')}}"></script>
</body>
</html>
