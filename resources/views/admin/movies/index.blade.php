@extends('layouts.admin')

@section('title')
    剧组
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">列表 总数：{{App\Models\Movie::count()}}</div>
            <div class="clearfix"></div>
        </div>

        <div class="widget-content">
            <div class="padd form-option">
                <form class="form-inline" method="get" action="/admin/movies">
                    <div class="form-group">
                        <label for="">剧名</label>
                        <input type="text" name="name" class="form-control" placeholder="请输入剧名">
                    </div>
                    <div class="form-group">
                        <label for="">类型</label>
                        <select name="type" class="form-control">
                            <option value="">请选择</option>
                            @foreach(App\Models\Movie::old_types() as $key=> $type)
                                <option value="{{$key}}">{{$type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">是否杀青</label>
                        <input type="radio" name="shootend" value="1">已杀青
                        <input type="radio" name="shootend" value="0">未杀青
                    </div>
                    <button type="submit" class="btn btn-primary">搜索</button>
                </form>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">ID</th>
                        <th class="col-md-3">剧名</th>
                        <th class="col-md-1">建剧人</th>
                        <th class="col-md-2">建剧时间</th>
                        <th class="col-md-2">总人数</th>
                        <th class="col-md-1">杀青</th>
                        <th class="col-md-2">操作</th>
                    </tr>
                    </thead>
                    @foreach($movies as $movie)
                        <tbody>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr class="bg-gray">
                            <td>{{$movie->FID}}</td>
                            <td>{{$movie->FNAME}}</td>
                            <td>{{App\User::where("FID",$movie->FNEWUSER)->first()->FNAME}}</td>
                            <td>{{$movie->FNEWDATE}}</td>
                            <td>{{$movie->allMembersCount()}}</td>
                            <td>
                                @if($movie->shootend=="1") 是 @else 否 @endif
                            </td>
                            <td>
                                <p><a href="/admin/movies/{{$movie->FID}}/edit">杀青</a></p>
                                @if($movie->hadLocked())
                                    <p><a class="btn btn-danger" href="/admin/movies/{{$movie->FID}}/unlock-name">解除锁定</a></p>
                                @else
                                    <p><a class="btn btn-success" href="/admin/movies/{{$movie->FID}}/lock-name">锁定</a></p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <a class="btn btn-sm btn-default" href="/admin/notices?movie_id={{$movie->FID}}">通告单</a>
                                <a class="btn btn-sm btn-default"
                                   href="/admin/movies/{{$movie->FID}}/users?type=public">公开电话</a>
                                <a class="btn btn-sm btn-default"
                                   href="/admin/movies/{{$movie->FID}}/users?type=private">通联表</a>
                                <a class="btn btn-sm btn-default" href="#">拍摄进度</a>
                                <a class="btn btn-sm btn-default" href="/admin/groups?movie_id={{$movie->FID}}">剧组管理</a>
                                <a class="btn btn-sm btn-default" href="/admin/movies/{{$movie->FID}}">剧组信息</a>
                                <a class="btn btn-sm btn-default" href="/admin/groups?movie_id={{$movie->FID}}">部门列表</a>
                                <a class="btn btn-sm btn-default" href="/admin/permissions?movie_id={{$movie->FID}}">权限管理</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
                {!! $movies->render() !!}
            </div>
        </div>

    </div>
@endsection
