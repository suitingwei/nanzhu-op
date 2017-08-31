@extends('layouts.admin')

@section('title')
招聘信息
@stop

@section('content')
<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">业内招聘</div>
	  <div class="widget-icons pull-right">
		<a href="/admin/recruits/create">创建</a>
		<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
		<a href="#" class="wclose"><i class="fa fa-times"></i></a>
	  </div>
	  <div class="clearfix"></div>
	</div>


	<div class="widget-content">

		<div class="padd form-option">
			<form class="form-inline" method="get" action="/admin/recruits">
			  <div class="form-group">
			    <label for="">标题</label>
			    <input type="text" name="title" class="form-control" placeholder="请输入标题">
			  </div>
			  <div class="form-group">
			    <label for="">类型</label>
				<select name="type" class="form-control">
			        <option value="">请选择</option>
			        <option value="公司">公司</option>
			        <option value="个人">个人</option>
				</select>
			  </div>
			<div class="form-group">
			    <label for="">审核状态</label>
				<input type="radio" name="is_approved" value="0">等待审核
				<input type="radio" name="is_approved" value="1">通过
				<input type="radio" name="is_approved" value="2">拒绝
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
					<th class="col-md-1">类型</th>
					<th class="col-md-5">内容</th>
					<th class="col-md-1">是否审核</th>
					<th class="col-md-1">创建时间</th>
					<th class="col-md-1">操作</th>
				</tr>
				</thead>
				@foreach($recruits as $recruit)
				<tr>
					<td>{{$recruit->id}}</td>
					<td><a href="https://apiv2.nanzhuxinyu.com/mobile/recruits/{{$recruit->id}}" target="blank">{{$recruit->title}}</a></td>
					<td>{{$recruit->type}}</td>
					<td>{{$recruit->content}}</td>
<td>@if($recruit->is_approved==1) <span class="label label-success"> 审核通过</span> @endif
@if($recruit->is_approved==0) <span class="label label-warning"> 等待审核 </span>@endif
@if($recruit->is_approved==2) <span class="label label-danger"> 审核未通过</span> @endif
</td>

					<td>{{$recruit->created_at}}</td>
					<td>
						<p><a href="/admin/recruits/{{$recruit->id}}/edit">审核</a></p>
						<form action="/admin/recruits/{{$recruit->id}}" method="post" accept-charset="utf-8" method="POST">
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
			{!! $recruits->render() !!}
		</div>
	</div>


</div>
@endsection
