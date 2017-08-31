@extends('layouts.admin')

@section('title')
编辑通告单
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
 			


<form class="form-horizontal" action="/admin/notices/{{$notice->FID}}" method="POST" enctype='multipart/form-data' >
                	{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">日期</label>
					<div class="col-sm-10">
					  <input type="text" name="name" class="form-control" value="{{$notice->FNAME}}"  readonly>
					</div>
				  </div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-10">
					<select name="FNOTICEEXCELTYPE">
						<option value="10" @if($notice->FNOTICEEXCELTYPE == 10) selected  @endif>每日通告单</option>
						<option value="20" @if($notice->FNOTICEEXCELTYPE == 20) selected  @endif>预备通告单</option>
					</select>
					</div>
				  </div>

					<?php $arr = ["A","B","C","D","E"] ?>	
					@foreach($notice->excels() as $key => $excel)
					  <div class="form-group">
						<label  class="col-sm-2 control-label">{{$arr[$key]}}组</label>
						<div class="col-sm-10">
						<a href="{{$excel->FFILEADD}}">	{{$excel->FFILEADD}}</a>
						</div>
					  </div>
					@endforeach

					@foreach($arr as $key => $a)
					  <div class="form-group">
						<label  class="col-sm-2 control-label">{{$a}}组</label>
						<div class="col-sm-10">
						  <input type="file" name="new_url[]" class="form-control" >excel，pdf，png，jpg
						</div>
					  </div>
					@endforeach


					
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



