@extends('layouts.admin')

@section('title')
广告
@stop

@section('content')
<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">广告</div>
	  <div class="widget-icons pull-right">
		<a href="/admin/advertisements/create">创建</a>
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
						<th class="col-md-1">图片</th>
						<th class="col-md-2">标题</th>
						<th class="col-md-4">url</th>
						<th class="col-md-1">序号</th>
						<th class="col-md-2">修改时间</th>
						<th class="col-md-1">操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($advertisements as $advertisement)
					<tr>
						<td>{{$advertisement->FID}}</td>
						<td><img src="{{$advertisement->FPICURL}}" style="width:100px;height:100px;"/></td>
						<td>{{$advertisement->FNAME}}</td>
						<td>{{$advertisement->FLINK}}</td>
						<td>{{$advertisement->FPOS}}</td>
						<td>{{$advertisement->FEDITDATE}}</td>
						<td>
							<p><a href="/admin/advertisements/{{$advertisement->FID}}/edit">编辑</a></p>
							<form action="/admin/advertisements/{{$advertisement->FID}}" method="post" accept-charset="utf-8" method="POST">
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
			{!! $advertisements->render() !!}
		</div>
  </div>

</div>
@endsection
