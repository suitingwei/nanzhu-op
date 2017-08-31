@extends('layouts.admin')

@section('title')
创建通告单
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
 			


<form class="form-horizontal" action="/admin/notices" method="POST" enctype='multipart/form-data' >
                	{!! csrf_field() !!}
<input type="hidden" name="movie_id" value="{{$movie->FID}}">
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">日期</label>
					<div class="col-sm-10">
					  <input type="text" name="name" id="datename" class="form-control" >
					</div>
				  </div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-10">
					<select name="FNOTICEEXCELTYPE">
						<option value="10">每日通告单</option>
						<option value="20">预备通告单</option>
					</select>
					</div>
				  </div>

				  <div class="form-group">
					<label  class="col-sm-2 control-label">A组</label>
					<div class="col-sm-10">
					  <input type="file" name="url[]" class="form-control" >excel，pdf，png，jpg
					</div>
				  </div>
				  <div class="form-group">
					<label  class="col-sm-2 control-label">B组</label>
					<div class="col-sm-10">
					  <input type="file" name="url[]" class="form-control" >excel，pdf，png，jpg
					</div>
				  </div>
				 <div class="form-group">
					<label  class="col-sm-2 control-label">C组</label>
					<div class="col-sm-10">
					  <input type="file" name="url[]" class="form-control" >excel，pdf，png，jpg
					</div>
				  </div>
				  <div class="form-group">
					<label  class="col-sm-2 control-label">D组</label>
					<div class="col-sm-10">
					  <input type="file" name="url[]" class="form-control" >excel，pdf，png，jpg
					</div>
				  </div>
				<div class="form-group">
					<label  class="col-sm-2 control-label">E组</label>
					<div class="col-sm-10">
					  <input type="file" name="url[]" class="form-control" >excel，pdf，png，jpg
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

@section("javascript")
<script type="text/javascript" charset="utf-8">
	$("#datename").datepicker({ dateFormat: 'yy-mm-dd' });
</script>

@endsection


