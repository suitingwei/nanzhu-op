@extends('layouts.admin')

@section('title')
查看
@stop

@section('content')

<div class="widget wgreen">
                <div class="widget-head">
                  <div class="pull-left">Forms</div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                  <div class="padd">

                    <br />
                    <!-- Form starts.  -->
 			


<form class="form-horizontal" action="/admin/users/{{$user->FID}}" method="POST" enctype='multipart/form-data' >
                	{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">姓名</label>
					<div class="col-sm-10">
					  <input type="text" name="name" class="form-control" value="{{$user->FNAME}}"  readonly>
					</div>
				  </div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">电话</label>
					<div class="col-sm-10">
					  <input type="text" name="FPHONE" class="form-control" value="{{$user->FPHONE}}"  readonly>
					</div>
				  </div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">性别</label>
					<div class="col-sm-10">
					  <input type="text" name="FSEX" class="form-control" value="{{$user->sex_desc()}}"  readonly>
					</div>
				  </div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">角色</label>
					<div class="col-sm-10">
						<input type="text" name="role" class="form-control" value="
							@foreach($user->roles() as $role)
								{{$role->name}},
								@endforeach
								"  readonly>
					</div>
				</div>

					
				</form>
        </div>
                </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
              </div>  

            </div>

        </div>
@endsection



