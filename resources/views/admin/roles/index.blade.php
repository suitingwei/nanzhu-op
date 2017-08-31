@extends('layouts.admin')

@section('title')
角色
@stop

@section('content')

<div class="widget">

				<div class="widget-head">
				  <div class="pull-left">列表</div>
				  <div class="widget-icons pull-right">
					<a href="/admin/roles/create">创建</a>
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
								<th>code</th>
								<th>操作</th>
							</tr>
							</thead>
			
						<tbody>
					@foreach($roles as $role)
					<tr>
						<td>{{$role->id}}</td>
						<td>{{$role->name}}</td>
						<td>{{$role->code}}</td>
						<td><a href="/admin/roles/{{$role->id}}/edit">修改</a>|<a onclick="return del_one()" href='/admin/roles/delete?id={{$role->id}}'>删除</a></td>
					</tr>
					@endforeach
				</table>
    </div>
					<div class="widget-foot">
					  <div class="clearfix"></div> 
					</div>
				
				  </div>
				</div>
		<script>
			function del_one(){
				var gnl=confirm("你真的确定要删除吗?");
				if (gnl==true){
					return true;
				}
				else{
					return false;
				}
			}
		</script>
@endsection

					
