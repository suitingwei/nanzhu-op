@extends('layouts.admin')

@section('title')
列表
@stop

@section('content')

<div class="widget">

				<div class="widget-head">
				  <div class="pull-left">列表</div>
				  <div class="widget-icons pull-right">
					<a href="/admin/albums/create?profile_id={{$profile_id}}">创建</a>
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
								<th>标题</th>
								<th>背景</th>
								<th>图片数量</th>
								<th>注册时间</th>
								<th></th>
							</tr>
						</thead>	
						@foreach($albums as $album)
						<tr>
							<td>{{$album->id}}</td>	
							<td>{{$album->title}}</td>	
							<td>{{$album->color}}</td>	
							<td>{{count($album->pictures())}}</td>	
							<td>{{$album->created_at}}</td>	
							<td>
							<form action="/admin/albums/{{$album->id}}" method="post" accept-charset="utf-8" method="POST">
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
@endsection
