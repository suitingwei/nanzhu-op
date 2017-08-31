@extends('layouts.admin')

@section('title')
    用户
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">用户列表 总数：{{App\User::count()}}</div>
            <div class="widget-icons pull-right">
                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="widget-content">
            <div class="padd form-option">
                <form class="form-inline" action="/admin/users" method="get" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="">姓名</label>
                        <input type="text" name="name" placeholder="请输入姓名" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">电话号码</label>
                        <input type="text" placeholder="请输入电话号码" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">用户ID</label>
                        <input type="text" placeholder="请输入用户ID" name="FID" class="form-control">
                    </div>
                    <button class="btn btn-primary" type="submit">搜索</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                        <th class="col-md-1">ID</th>
                        <th class="col-md-1">姓名</th>
                        <th class="col-md-1">电话</th>
                        <th class="col-md-2">注册时间</th>
                        <th class="col-md-2">角色</th>
                        <th class="col-md-3">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{$user->FID}}</td>
                            @if($user->FID == 0 )
                                <td>系统管理员</td>
                            @else
                                <td>{{$user->FNAME}}</td>
                            @endif
                            <td>{{substr($user->FPHONE,0,6)}}*****</td>
                            <td>{{$user->FNEWDATE}}</td>
                            <td>
                                <ol>
                                    @foreach($user->roles() as $role)
                                        <li>
                                            {{$role->name}}
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                            <td>
                                <a href="/admin/users/{{$user->FID}}">个人信息 </a>
                                <a href="/admin/users/{{$user->FID}}/edit">设置 </a>
                                <a href="/admin/">发布的组讯 </a>
                                <a href="/admin/">发布的招聘 </a>
                                <a href="/admin/">收藏</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
                {!! $users->render() !!}
            </div>
        </div>

    </div>
@endsection
