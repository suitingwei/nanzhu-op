@extends('layouts.admin')

@section('title')
通告单
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
									<th>标题</th>
									<th>时间</th>
									<th>类型</th>
									<th>是否发送</th>
									<th>编辑时间</th>
									<th>创建时间</th>
									<th></th>
								</tr>
							</thead>
						<tbody>
							@foreach($notices as $notice)
								<tr>
									<th>{{$notice->FID}}</th>
									<th>{{$notice->FNAME}}</th>
									<th>{{$notice->FDATE}}</th>
									<th>{{$notice->type_desc()}}</th>
									<th>{{$notice->FRECEIVEDETAIL}}</th>
									<th>{{$notice->FEDITDATE}}</th>
									<th>{{$notice->FNEWDATE}}</th>

									<th>
										<a href="/admin/notices/{{$notice->FID}}/edit" class="btn btn-sm">编辑</a>
										<form action="/admin/notices/{{$notice->FID}}" style="display:inline;" method="post" accept-charset="utf-8" method="POST">
											{!! csrf_field() !!}
											<input type="hidden" name="_method" value="DELETE">
											<input type="submit" class="btn btn-danger" value="删除">
										</form>
									</th>
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
