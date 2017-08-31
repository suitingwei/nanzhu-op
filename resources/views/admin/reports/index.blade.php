@extends('layouts.admin')

@section('title')
举报
@stop

@section('content')

<div class="widget">

				<div class="widget-head">
				  <div class="pull-left">列表</div>
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
								<th>ID</th>
								<th>名称</th>
								<th>内容</th>
								<th>联系方式</th>
								<th></th>
							</tr>
							</thead>
			
						<tbody>
					@foreach($reports as $report)
					<tr>
						<td>{{$report->id}}</td>

						<td>{{$report->title}}</td>

						<td>{{$report->content}}</td>

						<td>{{$report->contact}}</td>
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

					
