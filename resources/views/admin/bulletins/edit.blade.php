@extends('layouts.admin')

@section('title')
审核
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
				<form class="form-horizontal" action="/admin/bulletins/{{$bulletin->FID}}" method="POST" enctype='multipart/form-data' >
                	{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PATCH">
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label"></label>
					<div class="col-sm-10">

					</div>
				  </div>

				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-default">保存</button>
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



