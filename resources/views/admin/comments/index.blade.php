@extends('layouts.admin')

@section('title')
评论
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
						<th class="col-md-1">ID</th>
						<th class="col-md-2">标题</th>
						<th class="col-md-1">创建用户</th>
						<th class="col-md-2">注册时间</th>
						<th class="col-md-2">回复时间</th>
						<th class="col-md-3">回复内容</th>
						<th class="col-md-1">操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($comments as $comment)
					<tr>
						<td>{{$comment->FID}}</td>
						<td>{{$comment->FCOMMENT}}</td>
						<td>{{$comment->FNEWUSER}}</td>
						<td>{{$comment->FNEWDATE}}</td>
						<td>{{$comment->FREPLYTIME}}</td>
						<td>{{$comment->FREPLYCONTENT}}</td>
						<td>
							<a href="/admin/comments/{{$comment->FID}}/edit">回复</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="widget-foot">
		  <div class="clearfix"></div>
			{!! $comments->render() !!}
		</div>
  </div>

</div>
@endsection
