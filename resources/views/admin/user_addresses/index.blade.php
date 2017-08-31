@extends('layouts.admin')

@section('content')
    <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">用户地址</div>
            </div>
				<table class="table" border="0">
					<tr>
						<th>id</th>
						<th>姓名</th>
						<th>电话</th>
						<th>区域</th>
						<th>地址</th>
					</tr>
					@foreach($user_addresses as $address)
					<tr>
						<td>{{$address->id}}</td>
						<td>{{$address->name}}</td>
						<td>{{$address->phone}}</td>
						<td>{{$address->area}}</td>
						<td>{{$address->address}}</td>
					</tr>
					@endforeach
				</table>
    </div>
@endsection
