@extends('layouts.admin')

@section('title')
图片
@stop

@section('content')

<div class="widget">

				<div class="widget-head">
				  <div class="pull-left">列表</div>
				  <div class="widget-icons pull-right">
					@if($profile_id)
					<a href="/admin/albums/create?profile_id={{$profile_id}}">添加</a>
					@else
					<a href="/admin/pictures/create">添加</a>
					@endif
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
						<th>url</th>
						<th>product_id</th>
						<th>album_id</th>
						<th>profile_id</th>
						<th>是否开屏</th>
						<th>跳转地址</th>
						<th></th>
					</tr>
					@foreach($pictures as $picture)
					<tr>
						<td><img src="{{$picture->url}}" style="width:100px;height:100px;"/></td>
						<td>{{$picture->url}}</td>
						<td>{{$picture->product_id}}</td>
						<td>{{$picture->album_id}}</td>
						<td>{{$picture->profile_id}}</td>
						<td>{{$picture->is_startup}}</td>
						<td>{{$picture->jump_url}}</td>
						<td>
							<form action="/admin/pictures/{{$picture->id}}" method="post" accept-charset="utf-8" method="POST">
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
						{!! $pictures->render() !!}
				  </div>
				</div>
@endsection
