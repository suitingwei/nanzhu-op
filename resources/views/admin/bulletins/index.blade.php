@extends('layouts.admin')

@section('title')
组讯
@stop

@section('content')
<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">组讯</div>
	  <div class="widget-icons pull-right">
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
						<th class="col-md-2">标题</th>
						<th class="col-md-7">内容</th>
						<th class="col-md-1">注册时间</th>
						<th class="col-md-1">操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($bulletins as $bulletin)
					<tr>
						<td>{{$bulletin->FID}}</td>

						<td>{{$bulletin->FNAME}}</td>
						<td>{{$bulletin->FCONTENT}}</td>
						<td>{{$bulletin->FNEWDATE}}</td>
						<td>
							<a href="/admin/bulletins/{{$bulletin->FID}}/edit">审核</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
    </div>

		<div class="widget-foot">
		  <div class="clearfix"></div>
			{!! $bulletins->render() !!}
		</div>
	</div>

</div>
@endsection
