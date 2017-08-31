@extends('layouts.admin')

@section('title')
    {{$type}}
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">列表</div>
            <div class="widget-icons pull-right">
                <a href="/admin/basements/{{$type}}/create">创建</a>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class="widget-content">

            <div class="padd form-option">
                <form class="form-inline" method="get" action="/admin/{{$type}}">
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
                <table class="table  table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">ID</th>
                        <th class="col-md-1">标题</th>
                        <th class="col-md-1">logo</th>
                        <th class="col-md-4">内容</th>
                        <th class="col-md-2">注册时间</th>
                        <th class="col-md-2">编辑时间</th>
                        <th class="col-md-1">操作</th>
                        {{--<th class="col-md-1">操作</th>--}}
                    </tr>
                    </thead>
                    @foreach($basements as $basement)
                        <tr>
                            <td class="thisid">{{$basement->id}}</td>
                            <td><a class="gotodetail">{{$basement->title}}</a></td>
                            <td><img src="{{$basement->cover}}" style='width:100px;height:80px' /></td>
                            <td>{{  mb_substr($basement->introduction,0,30) }}</td>
                            <td>{{$basement->created_at}}</td>
                            <td>{{$basement->updated_at}}</td>
                            <td>

                                <a href="/admin/basements/{{$type}}/{{$basement->id}}" class="btn btn-primary">编辑</a>
                                <form action="/admin/basements/{{$type}}/{{$basement->id}}"  accept-charset="utf-8" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" class="btn btn-danger" value="删除">
                                </form>
                                <p>
                                    <a href="/admin/basement/{{$basement->id}}/edit-cooperation-config"
                                       class="btn btn-primary">寻求合作</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="widget-foot">
                <div class="clearfix"></div>
            </div>
        </div>

    </div>
    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/assets/admin/js/changeurl.js">
    </script>
    <script>
        var gotodetail=document.getElementsByClassName('gotodetail');
        var thisid=document.getElementsByClassName('thisid');
        var thisurl=changeurl();
        for(var i=0;i<thisid.length;i++){
            gotodetail[i].href=thisurl+'/mobile/trade-resources/basements/'+thisid[i].innerHTML
        }


    </script>
@endsection