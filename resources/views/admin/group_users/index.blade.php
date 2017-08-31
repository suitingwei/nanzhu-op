@extends('layouts.admin')

@section('title')
用户
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

						<th>FID</th>
						<th>Name</th>
						<th>职位</th>
						<th>电话</th>
						<th>注册时间</th>
						<th></th>
					</tr>
					@foreach($group_users as $user)
					<tr>
					<?php $t_user = App\User::where("FID",$user->FUSER)->first();?>
						<td>{{$user->FUSER}}</td>
						<td>{{$t_user->FNAME}}</td>
						<td>{{$user->FREMARK}}</td>
						<td>{{substr($user->FPHONE,0,6)}}*****</td>
						<td>{{$user->FNEWDATE}}</td>
						<td></td>
					</tr>
					@endforeach
				</table>
    </div>
					<div class="widget-foot">
					  <div class="clearfix"></div> 
						{!! $group_users->render() !!}
					</div>
				
				  </div>
				</div>
@endsection
