@extends('layouts.admin')

@section('title')
艺人推荐
@stop

@section('content')
<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">艺人推荐</div>
	  <div class="widget-icons pull-right">
		<a href="/admin/profiles/create">创建</a>
		<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
		<a href="#" class="wclose"><i class="fa fa-times"></i></a>
	  </div>
	  <div class="clearfix"></div>
	</div>


	<div class="widget-content">

	<div class="padd form-option">
			<form class="form-inline" action="/admin/profiles">
			  <div class="form-group">
			    <label for="">姓名</label>
			    <input type="text" name="name" class="form-control" placeholder="请输入标题">
			  </div>
			  <div class="form-group">
				<label for="">是否显示</label>
				  <input type="radio" name="is_show" value="2">否
				  <input type="radio" name="is_show" value="1">是
			  </div>
			  <div class="form-group">
				<label for="">职位分类</label>
				  <input type="radio" name="position" value="2">台前
				  <input type="radio" name="position" value="1">幕后
			  </div>
			  <button type="submit" class="btn btn-primary">搜索</button>
			</form>
		</div>
		<hr>

		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			  <thead>
					<tr>
					  <th class="col-md-1">头像</th>
					  <th class="col-md-1">姓名</th>
					  <th class="col-md-1">分类</th>
					  <th class="col-md-1">身高 </th>
					  <th class="col-md-1">体重</th>
					  <th class="col-md-1">用户</th>
					  <th class="col-md-1">联系方式</th>
					  <th class="col-md-1">顺序</th>
					  <th class="col-md-1">编辑时间</th>
					  <th class="col-md-1">是否显示</th>
					  <th class="col-md-2">操作</th>
					</tr>
			  </thead>
				<tbody>
					@foreach($profiles as $key => $profile)
					<tr>
					<td><img src="{{$profile->avatar}}" style="width:100px;height:100px"/></td>
					<td><a href="https://apiv2.nanzhuxinyu.com/mobile/users/{{$profile->id}}" target="blank">{{$profile->name}}</a></td>
					<td>{{$profile->before_position}}<br/><br/>{{$profile->behind_position}}</td>
					<td>{{$profile->height}}</td>
					<td>{{$profile->weight}}</td>
					<td>{{$profile->user_id}}</td>
					<td>
						{!! GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($profile->email) !!}
					</td>
					<td>{{$profile->sort}}</td>
					<td>{{$profile->updated_at}}</td>
					<td>
						@if($profile->is_show)
							是
						@else
							否
						@endif
					</td>
					<td>

						<p><a href="/admin/profiles/{{$profile->id}}/edit" class="btn btn-primary">编辑</a>
						<a href="/admin/profiles/editpic/{{$profile->id}}/edit" class="btn btn-primary">编辑形象照</a></p>
						<p><a href="/admin/albums?profile_id={{$profile->id}}" class="btn btn-info">添加图片</a>
						<a href="/admin/profilerecords?profile_id={{$profile->id}}" class="btn btn-info">编辑记录</a></p>
						<p><a href="/admin/profiles/{{$profile->id}}/sorts" class="btn btn-danger">置顶</a></p>

						<!--<form action="/admin/profiles/{{$profile->id}}" method="post" accept-charset="utf-8" method="POST">
							{!! csrf_field() !!}
							<input type="hidden" name="_method" value="DELETE">
							<input type="submit" class="btn btn-danger" value="删除">
						</form>-->
					</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="widget-foot">
		  <div class="clearfix"></div>
				{!! $profiles->render() !!}
		</div>
	</div>

</div>
@endsection
