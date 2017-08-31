@extends('layouts.admin')

@section('title')
    用户
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">黑名单列表 总数：{{App\Models\BlackList::count()}}</div>
            <div class="widget-icons pull-right">
                <a href="/admin/black-lists/create" class="btn btn-primary">新建</a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="widget-content">
            <div class="padd form-option">
                <form class="form-inline" action="/admin/black-lists" method="get" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="">电话号码</label>
                        <input type="text" placeholder="请输入电话号码" name="phone" class="form-control">
                    </div>
                    <button class="btn btn-primary" type="submit">搜索</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                        <th class="col-md-2">ID</th>
                        <th class="col-md-2">姓名</th>
                        <th class="col-md-2">电话</th>
                        <th class="col-md-4">备注</th>
                        <th class="col-md-2">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blackLists as $index => $blackList)
                        <tr>
                            <td>{{ $blackList->id}}</td>
                            <td>{{ $blackList->user ? $blackList->user->FNAME :''}}</td>
                            <td>{{ $blackList->phone }}</td>
                            <td>{{ $blackList->note}}</td>
                            <td>
                                <a href="/admin/black-lists/{{ $blackList->id }}/delete" class="btn btn-danger">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
                {!! $blackLists->render() !!}
            </div>
        </div>

    </div>
@endsection
