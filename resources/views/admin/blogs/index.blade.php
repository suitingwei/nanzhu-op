@extends('layouts.admin')

@section('title')
    {{App\Models\Blog::type_desc()[$type]}}
@stop

@section('content')
    <div class="widget">


        <div class="widget-head">
            <div class="pull-left">列表</div>
            <div class="widget-icons pull-right">
                <a href="/admin/blogs/create?type={{$type}}">创建</a>
                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class="widget-content">

            <div class="padd form-option">
                <form class="form-inline" method="get" action="/admin/blogs">
                    <input type="hidden" name="type" value="{{$type}}">
                    <div class="form-group">
                        <label for="">标题</label>
                        <input type="text" name="title" class="form-control" placeholder="请输入标题">
                    </div>
                    <div class="form-group">
                        <label for="">类型</label>
                        <select name="type_value" class="form-control">
                            <option value="">请选择</option>
                            @foreach($type_arr as $type)
                                <option value="{{$type}}">{{$type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">审核状态</label>
                        <input type="radio" name="is_approved" value="0">等待审核
                        <input type="radio" name="is_approved" value="1">通过
                        <input type="radio" name="is_approved" value="2">拒绝
                    </div>
                    <div class="form-group">
                        <label for="">注册时间</label>
                        <input name="created_at" class="form-control" placeholder="注册时间">
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
                        <th class="col-md-2">标题</th>
                        <th class="col-md-1">类型</th>
                        <th class="col-md-1">是否审核</th>
                        <th class="col-md-1">注册时间</th>
                        <th class="col-md-1">编辑时间</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>
                    @foreach($blogs as $blog)
                        <tr>
                            <td>{{$blog->id}}</td>
                            <td><a href="https://apiv2.nanzhuxinyu.com/mobile/blogs/{{$blog->id}}"
                                   target="blank">{{$blog->title}}</a></td>
                            <td>{{$blog->type_value}}</td>
                            <td>@if($blog->is_approved==1) <span class="label label-success"> 审核通过</span> @endif
                                @if($blog->is_approved==0) <span class="label label-warning"> 等待审核 </span>@endif
                                @if($blog->is_approved==2) <span class="label label-danger"> 审核未通过</span> @endif
                            </td>
                            <td>{{$blog->created_at}}</td>
                            <td>{{$blog->updated_at}}</td>
                            <td>
                                <a href="/admin/blogs/{{$blog->id}}/edit">审核</a>
                                <form action="/admin/blogs/{{$blog->id}}" method="post" accept-charset="utf-8"
                                      method="POST">
                                    {!! csrf_field() !!}
                                    <p><input type="hidden" name="_method" value="DELETE"></p>
                                    <input type="submit" class="btn btn-danger" value="删除">
                                </form>
                                <a class="btn btn-warning" onclick="clearRedisCache('{{ $blog->id }}')">清除缓存</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
                {!! $blogs->appends($appends)->render() !!}
            </div>
        </div>


    </div>
@endsection
@section('javascript')
    <script>

        function clearRedisCache(blogId) {
            if (confirm('确定要清除缓存吗')) {
                $.get('https://apiv2.nanzhuxinyu.com/api/blogs/' + blogId + '/clear-cache', function (responseData) {
                    window.location.reload();
                });
            }
        }
    </script>
@endsection
