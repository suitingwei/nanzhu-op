@extends('layouts.admin')

@section('title')
banners
@stop

@section('content')
<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">广场banner</div>
	  <div class="widget-icons pull-right">
		<a href="/admin/banners/create">创建</a>
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
						<th class="col-md-2">封面</th>
						<th class="col-md-4">地址</th>
						<th class="col-md-1">类型</th>
						<th class="col-md-1">注册时间</th>
						<th class="col-md-1">排序</th>
						<th class="col-md-1">当前状态</th>
						<th class="col-md-1">操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($banners as $banner)
					<tr>
						<td>{{$banner->id}}</td>
						<td>
							<a href="{{$banner->cover}}" target="blank"><img src="{{$banner->cover}}" style="width:100px;height:100px;"/></a>
						</td>
						<td>{{$banner->url}}</td>
						<td>{{$banner->type}}</td>
						<td>{{$banner->created_at}}</td>
						<td>{{$banner->sort}}</td>
						<td>
							@if($banner->isShow())
								<span class="label label-info">上架</span>
							@else
								<span class="label label-danger">已下架</span>
							@endif
						</td>
						<td>
							<p><a href="/admin/banners/{{$banner->id}}/show" class="label label-info">上架</a></p>
							<p><a href="/admin/banners/{{$banner->id}}/notshow" class="label label-danger">下架</a></p>
							<p><a href="/admin/banners/{{$banner->id}}/edit" class="label label-primary">编辑</a></p>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="widget-foot">
		  <div class="clearfix"></div>
		</div>
	</div>

</div>
@endsection
