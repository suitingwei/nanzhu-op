@extends('layouts.admin')

@section('title')
创建图片
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



<form class="form-horizontal" action="/admin/pictures" method="POST" enctype='multipart/form-data' >
                	{!! csrf_field() !!}
				  <div class="form-group">
					<label  class="col-sm-2 control-label">图片</label>
					<div class="col-sm-10">
					  <input type="file" name="url" class="form-control" >
					</div>
				  </div>

				<div class="form-group">
					<label  class="col-sm-2 control-label">是否是启动图片</label>
					<div class="col-sm-10">
							<select name="is_startup" >
								<option value="0">否</option>
								<option value="1">是</option>
							</select>
					</div>
				  </div>
				<div class="form-group">
					<label  class="col-sm-2 control-label">跳转地址</label>
					<div class="col-sm-10">
						<input type="text" name="jump_url" class="form-control" >
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



