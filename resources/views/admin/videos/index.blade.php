@extends('layouts.admin')

@section('title')
	视频
@stop

@section('content')

<div class="widget">

				<div class="widget-head">
				  <div class="pull-left">列表</div>
				  <div class="widget-icons pull-right">
					<a href="/admin/videos/create">创建</a>
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
							  <th>封面 </th>
							  <th>连接ID</th>
							  <th></th>
							</tr>
						  </thead>

				<tbody>
					@foreach($videos as $video)
					<tr>
						<td><img src="{{$video->cover}}" style="width:100px;height:100px"></td>
						<td>{{$video->url}}</td>
						<td>
							<form action="/admin/feeds" method="post" accept-charset="utf-8" method="POST">
								{!! csrf_field() !!}
								<input type="hidden" name="type" value="VIDEO">
								<input type="hidden" name="type_id" value="{{$video->id}}">
								<input type="submit" class="btn" value="添加到feeds">
							</form>
							<form action="/admin/videos/{{$video->id}}" method="post" accept-charset="utf-8" method="POST">
								{!! csrf_field() !!}
								<input type="hidden" name="_method" value="DELETE">
								<input type="submit" class="btn btn-danger" value="删除">
							</form>
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
