@extends('layouts.admin')

@section('title')
列表
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
								<th>拍摄时间</th>
								<th>地点</th>
								<th>联系人</th>
								<th>手机</th>
								<th>备注</th>
								<th>是否支付</th>
								<th>支付时间</th>
								<th></th>
							</tr>
						</thead>	
						<tbody>
						@foreach($shoot_orders as $shoot_order)
						<tr>
							<td>{{$shoot_order->id}}</td>
							<td>{{$shoot_order->start_date}}</td>
							<td>{{$shoot_order->address}}</td>
							<td>{{$shoot_order->contact}}</td>
							<td>{{$shoot_order->phone}}</td>
							<td>{{$shoot_order->note}}</td>
							<td>@if($shoot_order->is_payed) 是 @endif</td>
							<td>@if($shoot_order->is_payed) {{$shoot_order->payed_at}} @endif</td>
							<td></td>
						</tr>
						@endforeach
						</tbody>
				</table>
    </div>
					<div class="widget-foot">
					  <div class="clearfix"></div> 
						{!! $shoot_orders->render() !!}
					</div>
				
				  </div>
				</div>
@endsection
