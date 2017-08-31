@extends('layouts.admin')

@section('title')
    制作公司
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">列表</div>
            <div class="widget-icons pull-right">
                <a href="/admin/companies/create">创建</a>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class="widget-content">

            <div class="padd form-option">
                <form class="form-inline" method="get" action="/admin/companies">
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
                        <th class="col-md-1">logo</th>
                        <th class="col-md-6">内容</th>
                        <th class="col-md-1">注册时间</th>
                        <th class="col-md-1">编辑时间</th>
                        <th class="col-md-1">操作</th>
                        {{--<th class="col-md-1">操作</th>--}}
                    </tr>
                    </thead>
                    @foreach($companies as $company)
                        <tr>
                            <td class="thisid">{{$company->id}}</td>

                            <td><a class="gotodetail">{{$company->title}}</a></td>
                            <td><img src="{{$company->logo}}" style="width:120px;height:120px"/></td>
                            <td>{{  mb_substr($company->plain_introduction,0,30) }}</td>
                            <td>{{$company->created_at}}</td>
                            <td>{{$company->updated_at}}</td>
                            <td>
                                @if(App\User::where("FID",request()->session()->get('user_id'))->first()->has_role(2))
                                    <p>
                                        <a href="/admin/companies/{{$company->id}}/edit" class="btn btn-primary">编辑</a>
                                    </p>
                                    <p>
                                        <a href="/admin/companies/{{$company->id}}/edit-cooperation-config"
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
            </div>
        </div>

    </div>
    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/assets/admin/js/changeurl.js">
    </script>
    <script>
        var gotodetail = document.getElementsByClassName('gotodetail');
        var thisid = document.getElementsByClassName('thisid');
        var thisurl = changeurl();
        for (var i = 0; i < thisid.length; i++) {
            gotodetail[i].href = thisurl + '/mobile/trade-resources/companies/' + thisid[i].innerHTML
        }
    </script>

@endsection