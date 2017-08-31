@extends('layouts.admin')

@section('title')
    联盟
@stop

@section('content')
    <div class="widget">

        <div class="widget-head">
            <div class="pull-left">列表</div>
            <div class="widget-icons pull-right">
                <a href="/admin/unions/{{$type}}/create">添加手机号</a>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class="widget-content">


            <div class="table-responsive">
                <table class="table  table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">联盟</th>
                        <th class="col-md-1">备注</th>
                        <th class="col-md-1">手机号</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>
                    @foreach($allThisUnionUsers as $user)
                        <tr>
                            <td>{{$user->type}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                                <form action="/admin/unions/{{$user->type}}/{{$user->id}}"  accept-charset="utf-8" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" class="btn btn-danger" value="删除">
                                </form>
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