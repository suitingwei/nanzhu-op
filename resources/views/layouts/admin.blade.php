<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>南竹通告单管理后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <link href="/assets/admin/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/admin/css/jquery-ui.css">
    @yield('dropzone_css')
    <link href="/assets/admin/css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/assets/admin/js/respond.min.js"></script>
    <script src="js/html5shiv.js"></script>
    <![endif]-->
</head>
<link rel="shortcut icon" href="/assets/admin/img/favicon/favicon.png">
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">南竹通告单管理后台</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav pull-right">
                @if (Session::get('user_id'))
                    <li class="dropdown pull-right">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-user"></i>{{ Session::get("user")->FLOGIN }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/admin/users') }}"><i class="fa fa-user"></i> 用户</a></li>
                            <li><a href="{{ url('/admin/roles') }}"><i class="fa fa-group"></i> 角色</a></li>
                            <li><a href="{{ url('/admin/permissions') }}"><i class="fa fa-cogs"></i> 权限</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa  fa-sign-out"></i> 退出登录</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<div class="content">

    <div class="sidebar">
        <div class="sidebar-dropdown"><a href="#">南竹通告单管理后台</a></div>
        <ul id="nav">
            <li class="open has_sub"><a href="/admin"><i class="fa fa-home"></i>内容</a>
                <ul>
                    <li><a href="/admin/banners">广场banner</a></li>
                    <li><a href="/admin/profiles">艺人推荐</a></li>
                    <li><a href="/admin/blogs?type=juzu">剧组讯息 </a></li>
                    <li><a href="/admin/recruits">业内招聘 </a></li>
                    <li><a href="/admin/blogs?type=news">业内动态</a></li>
                    @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(2))
                        <li><a href="/admin/companies">制作公司</a></li>
                        <li><a href="/admin/basements/items">道具器材</a></li>
                        <li><a href="/admin/scripts">交易剧本</a></li>
                        <li><a href="/admin/basements/basement">影视基地</a></li>
                        <li><a href="/admin/basements/lightEquip">灯光器材</a></li>
                        <li><a href="/admin/basements/photographEquip">摄影器材</a></li>
                        <li><a href="/admin/basements/overseasRecord">海外协拍</a></li>
                        <li><a href="/admin/basements/yinxiaoCompany">营销公司</a></li>
                        <li><a href="/admin/basements/economyCompany">经纪公司</a></li>
                        <li><a href="/admin/basements/lawassist">法律援助</a></li>
                        <li><a href="/admin/basements/pray">仪式祈福</a></li>
                        <li><a href="/admin/basements/specialEffect">后期特效</a></li>
                        <li><a href="/admin/basements/dessert">甜点冷餐</a></li>
                        <li><a href="/admin/basements/uniform">服装服饰</a></li>
                        <li><a href="/admin/basements/studio">casting工作室</a></li>
                        <li><a href="/admin/basements/insurance">保险服务</a></li>
                        <li><a href="/admin/basements/hotel">剧组宾馆</a></li>
                    @endif
                </ul>
            </li>

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(11))
                <li class="open has_sub"><a href="/admin"><i class="fa fa-home"></i>工会组织</a>
                    <ul>
                        <li><a href="/admin/unions/guangdian"><i class="fa fa-picture-o"></i>广电影视联盟</a></li>
                        <li><a href="/admin/unions/nanzhu"><i class="fa fa-picture-o"></i>南竹</a></li>
                    </ul>
                </li
                >
            @endif

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(9))
                <li class="open has_sub"><a href="javascript:;"><i class="fa fa-picture-o"></i> 商品信息</a>
                    <ul>
                        <li><a href="/admin/products">商品录入</a></li>
                        <li><a href="/admin/product-sizes">商品规格</a></li>
                        <li><a href="/admin/product-brands">商品品牌</a></li>
                    </ul>
                </li>
            @endif

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(10))
                <li><a href="{{ url('/admin/orders') }}"><i class="fa fa-list"></i> 订单信息</a></li>
            @endif

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(4))
                <li><a href="{{ url('/admin/social-securities') }}"><i class="fa fa-list"></i> 社保订单</a></li>
            @endif

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(4))
                <li><a href="{{ url('/admin/education-schools/easy-education') }}"><i class="fa fa-list"></i> 容易教育</a></li>
            @endif

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(4))
                <li><a href="{{ url('/admin/investments') }}"><i class="fa fa-list"></i> 客户剧组投资</a></li>
            @endif

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(5))
                <li><a href="{{ url('/admin/shoot_orders') }}"><i class="fa fa-file-o"></i> 拍摄订单</a></li>
            @endif

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(7))
                <li><a href="{{ url('/admin/movies') }}"><i class="fa fa-file-o"></i> 剧</a></li>
            @endif

            <li><a href="{{ url('/admin/groups') }}"><i class="fa fa-file-o"></i> 部门</a></li>

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(8))
                <li><a href="{{ url('/admin/users') }}"><i class="fa fa-tasks"></i> 用户</a></li>
            @endif

            <li><a href="{{ url('/admin/roles') }}"><i class="fa fa-tasks"></i> 角色</a></li>
            <li><a href="/admin/comments"><i class="fa fa-file-o"></i>评论</a></li>
            <li><a href="/admin/advertisements"><i class="fa fa-file-o"></i>广告</a></li>
            <li><a href="/admin/bulletins"><i class="fa fa-file-o"></i>组讯</a></li>
            <li><a href="{{ url('/admin/pictures') }}"><i class="fa fa-file-o"></i> 图片</a></li>
            <li><a href="{{ url('/admin/messages') }}"><i class="fa fa-file-o"></i> 系统通知</a></li>
            <li><a href="{{ url('/admin/sms_records') }}"><i class="fa fa-file-o"></i>验证码记录 </a></li>
            <li><a href="{{ url('/admin/reports') }}"><i class="fa fa-file-o"></i> 举报</a></li>

            @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(12))
                <li><a href="{{ url('/admin/black-lists') }}"><i class="fa fa-file-o"></i>黑名单</a></li>
            @endif
            <li><a href="{{ url('/admin/feedbacks') }}"><i class="fa fa-file-o"></i> 意见反馈</a></li>
        </ul>
    </div><!-- Sidebar ends -->

    <div class="mainbar">

        <div class="page-head">
            <h2><i class="fa fa-list-alt"></i> @yield('title')</h2>
        </div><!-- Page heading ends -->

        <div class="matter">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        @if( Session::get('message'))
                            {{Session::get('message')}}
                        @endif
                        @yield('content')
                    </div>
                </div>

            </div>
        </div><!-- Matter ends -->

    </div><!-- Mainbar ends -->

    <div class="clearfix"></div>

</div><!-- Content ends -->


<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Copyright info -->
                <p class="copy">Copyright &copy; 2016 | 南竹通告单</p>
            </div>
        </div>
    </div>
</footer><!-- Footer ends -->


<span class="totop">
	<a href="#"><i class="fa fa-chevron-up"></i></a>
</span><!-- Scroll to top -->


<!-- JS -->
<script src="/assets/admin/js/jquery.js"></script>
<script src="/assets/admin/js/bootstrap.min.js"></script>
<script src="/assets/admin/js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        $(".has_sub > a").click(function (e) {
            e.preventDefault();
            var menu_li = $(this).parent("li");
            var menu_ul = $(this).next("ul");

            if (menu_li.hasClass("open")) {
                menu_ul.slideUp(350);
                menu_li.removeClass("open")
            }
            else {
                $("#nav > li > ul").slideUp(350);
                $("#nav > li").removeClass("open");
                menu_ul.slideDown(350);
                menu_li.addClass("open");
            }
        });

        $(".sidebar-dropdown a").on('click', function (e) {
            e.preventDefault();

            if (!$(this).hasClass("open")) {
                // open our new menu and add the open class
                $(".sidebar #nav").slideDown(350);
                $(this).addClass("open");
            }

            else {
                $(".sidebar #nav").slideUp(350);
                $(this).removeClass("open");
            }
        });
    });
</script>
@yield('javascript')
@yield('ueditor')
@yield('dropzone_js')
</body>
</html>
