@extends('layouts.admin')

@section('title')
    报名
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">用户列表 总数：{{App\Models\EducationSchoolApply::count()}}</div>
            <div class="widget-icons pull-right">
                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                        <th class="col-md-1">id</th>
                        <th class="col-md-1">姓名</th>
                        <th class="col-md-1">性别</th>
                        <th class="col-md-2">课程</th>
                        <th class="col-md-2">电话</th>
                        <th class="col-md-2">创建时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applies as $apply)
                        <tr>
                            <td>{{ $apply->id }}</td>
                            <td>{{ $apply->name}}</td>
                            <td>{{ $apply->gender}}</td>
                            <td>{{ $apply->course}}</td>
                            <td>{{ $apply->phone}}</td>
                            <td>{{ $apply->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
                {!! $applies->render() !!}
            </div>
        </div>

    </div>
@endsection
