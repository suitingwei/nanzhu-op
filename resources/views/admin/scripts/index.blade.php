@extends('layouts.admin')

@section('title')
    剧本
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">列表</div>
            <div class="widget-icons pull-right">
                <a href="/admin/scripts/create">创建</a>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class="widget-content">

            <div class="padd form-option">
                <form class="form-inline" method="get" action="/admin/scripts">
                    <div class="form-group">
                        <label for="">标题</label>
                        <input type="text" name="title" class="form-control" placeholder="请输入标题">
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
                        <th class="col-md-1">作者</th>
                        <th class="col-md-6">内容</th>
                        <th class="col-md-1">注册时间</th>
                        <th class="col-md-1">编辑时间</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>
                    @foreach($scripts as $script)
                        <tr>
                            <td>{{$script->id}}</td>
                            <td><a href="https://apiv2.nanzhuxinyu.com/mobile/trade-resources/scripts/{{$script->id}}"
                                   target="blank">{{$script->title}}</a></td>
                            <td>{{$script->author}}</td>
                            <td>{{ mb_substr($script->plain_content,0,30)}}</td>
                            <td>{{$script->created_at}}</td>
                            <td>{{$script->updated_at}}</td>
                            <td>
                                @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(2))
                                    <a href="/admin/scripts/{{$script->id}}/edit" class="btn btn-primary">编辑</a>
                                    <form action="/admin/scripts/{{$script->id}}" method="post" accept-charset="utf-8" method="POST" onsubmit="return sumbit_sure()">
                                        {!! csrf_field() !!}
                                        <p><input type="hidden" name="_method" value="DELETE"></p>
                                        <input type="submit" class="btn btn-danger" value="删除">
                                    </form>
                                    <p>
                                        <a href="/admin/scripts/{{$script->id}}/edit-cooperation-config"
                                           class="btn btn-primary">寻求合作</a>
                                    </p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
                {!! $scripts->render() !!}
            </div>
        </div>

    </div>
    <script>
        function sumbit_sure(){
            var gnl=confirm("确定要删除?");
            if (gnl==true){
                return true;
            }else{
                return false;
            }
        }
    </script>
@endsection
