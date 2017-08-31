@extends('layouts.admin')

@section('title')
    消息
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">消息</div>
            <div class="widget-icons pull-right">
                <a href="/admin/messages/create">创建</a>
                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">ID</th>
                        <th class="col-md-1">类型</th>
                        <th class="col-md-1">标题</th>
                        <th class="col-md-1">来源</th>
                        <th class="col-md-1">内容</th>
                        <th class="col-md-1">类型</th>
                        <th class="col-md-1">创建时间</th>
                        <th class="col-md-1">scope</th>
                        <th class="col-md-1">scope_ids</th>
                        <th class="col-md-1">uri</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{{$message->id}}</td>
                            <td>{{App\Models\Message::types()[$message->type]}}</td>
                            <td><a href="https://apiv2.nanzhuxinyu.com/mobile/messages/{{$message->id}}"
                                   target="blank">{{$message->title}}</a></td>
                            <td>{{$message->from}}</td>
                            <td>{{$message->content}}</td>
                            <td>{{$message->notice}}</td>
                            <td>{{$message->created_at}}</td>
                            <td>{{$message->scope}}</td>
                            <td>{{$message->scope_ids}}</td>
                            <td>{{$message->uri}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
                {!! $messages->render() !!}
            </div>
        </div>

    </div>
@endsection
