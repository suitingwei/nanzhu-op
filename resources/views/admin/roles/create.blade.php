@extends('layouts.admin')

@section('title')
创建
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
                              
				<form class="form-horizontal" action="/admin/roles/" method="POST" enctype='multipart/form-data' >
                	{!! csrf_field() !!}

								<div class="form-group">
                                  <label class="col-lg-2 control-label">角色名称</label>
                                  <div class="col-lg-5">
                                    <input type="text" name="name" class="form-control" placeholder="角色名称">
                                  </div>
                                </div>
								<div class="form-group">
                                  <label class="col-lg-2 control-label">code</label>
                                  <div class="col-lg-5">
                                    <input type="text" name="code" class="form-control" placeholder="code">
                                  </div>
                                </div>

								<div class="form-group">
                                  <div class="col-lg-offset-2 col-lg-6">
                                    <button type="submit" class="btn btn-sm btn-primary">保存</button>
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



