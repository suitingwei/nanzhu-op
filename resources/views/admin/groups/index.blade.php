@extends('layouts.admin')

@section('title')
组
@stop

@section('content')

<div class="widget">

				<div class="widget-head">
				  <div class="pull-left">列表</div>
				  <div class="widget-icons pull-right">

					<a href="/admin/groups/create">创建</a>
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
						<th>ID</th>
						<th>Name</th>
						<th>剧</th>
						<th>注册时间</th>
						<th></th>
					</tr>
					@foreach($groups as $group)
					<tr>
						<td>{{$group->FID}}</td>
						<td>{{$group->FNAME}}</td>
						<td>{{$group->FMOVIE}}</td>
						<td>{{$group->FNEWDATE}}</td>
						<td>
							<a href="/admin/group_users?group_id={{$group->FID}}">组成员({{$group->members()->count()}})</a>
						</td>
					</tr>
					@endforeach
				</table>
    </div>
					<div class="widget-foot">
					  <div class="clearfix"></div> 
						{!! $groups->appends($appends)->render() !!}
					</div>
				
				  </div>
				</div>
@endsection
