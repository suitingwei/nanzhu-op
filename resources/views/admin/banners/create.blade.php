@extends('layouts.admin')

@section('title')
创建banner
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
                              
				<form class="form-horizontal" action="/admin/banners" method="POST" enctype='multipart/form-data' >
			                	{!! csrf_field() !!}
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">封面</label>
                                  <div class="col-lg-5">
                                    <input type="file" class="form-control" name="cover" placeholder="封面">
                                  </div>
                                </div>

								<div class="form-group">
                                  <label class="col-lg-2 control-label">url</label>
                                  <div class="col-lg-5">
                                    <input type="text" name="url" class="form-control" placeholder="url">
                                  </div>
                                </div>

								<div class="form-group">
                                  <label class="col-lg-2 control-label">标题</label>
                                  <div class="col-lg-5">
                                    <input type="text" name="title" class="form-control" placeholder="标题">
                                  </div>
                                </div>

								<div class="form-group">
                                  <label class="col-lg-2 control-label">内容</label>
                                  <div class="col-lg-5">
                                    <input type="text" name="content" class="form-control" placeholder="内容">
                                  </div>
                                </div>

								<div class="form-group">
                                  <label class="col-lg-2 control-label">sort</label>
                                  <div class="col-lg-5">
                                    <input type="number" name="sort" class="form-control" placeholder="1">
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



