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
                              
				<form class="form-horizontal" action="/admin/albums" method="POST" enctype='multipart/form-data' >
                	{!! csrf_field() !!}
<input type="hidden" name="profile_id" value="{{$profile_id}}">

								<div class="form-group">
                                  <label class="col-lg-2 control-label">标题</label>
                                  <div class="col-lg-5">
						<select name="title" class="form-control" >
							<option value="形象照">形象照</option>
							<option value="剧照">剧照</option>
						</select>
									</div>
                                </div>
								<div class="form-group">
                                  <label class="col-lg-2 control-label">背景</label>
                                  <div class="col-lg-5">
                                    <input type="text" name="color" class="form-control" placeholder="背景">
                                  </div>
                                </div>

								@for($i =0 ;$i<9;$i++)
								<div class="form-group">
                                  <label class="col-lg-2 control-label">上传图片</label>
                                  <div class="col-lg-5">
									<input type="file" name="pic_url[]" value=""/>
                                  </div>
                                </div>
								@endfor

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

<script type="text/javascript" charset="utf-8">
var editor = new Editor();
editor.render();
</script>
@endsection



