@extends('layouts.admin')

@section('title')
	艺人资料编辑人员
@stop

@section('content')
<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">艺人资料编辑人员</div>
	  <div class="widget-icons pull-right">
		<a href="/admin/profilerecords/create">创建</a>
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
						<th class="col-md-1">编辑人</th>
						<th class="col-md-1">联系方式</th>
						<th class="col-md-1">编辑时间</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{$user->FNAME}}</td>
						<td>{{$user->FLOGIN}}</td>
						<td>{{$user->created_at}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
    </div>
  </div>

</div>
@endsection
