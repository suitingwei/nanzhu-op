@extends('layouts.admin')

@section('title')
	编辑
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

				<form class="form-horizontal" action="/admin/movies/{{$movie[0]->FID}}" method="POST" enctype='multipart/form-data' >
					{!! csrf_field() !!}
					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">MOVIEID</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" value="{{$movie[0]->FID}}"  readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">剧名</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" value="{{$movie[0]->fname}}"  readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">类型</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" value="@if($movie[0]->flabel!=0&&$movie[0]->flabel!=""&&$movie[0]->flabel!=null){{App\Models\Movie::old_types()[$movie[0]->flabel]}}@endif"  readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">是否杀青</label>
						<div class="col-sm-10">
							<input type="radio" name="shootend" value="1" @if($movie[0]->shootend=="1") checked @endif>是
							<input type="radio" name="shootend" value="0" @if($movie[0]->shootend=="0") checked @endif>否
						</div>
					</div>
					{{--<div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">出品方</label>
                        <div class="col-sm-10">
                          <input type="text" name="name" class="form-control" value="{{$movie->FNAME}}"  readonly>
                        </div>
                      </div>--}}
					{{--<div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">制作方</label>
                        <div class="col-sm-10">
                          <input type="text" name="name" class="form-control" value="{{$movie->FNAME}}"  readonly>
                        </div>
                      </div>--}}
					{{--<div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">项目类型</label>
                        <div class="col-sm-10">
                          <input type="text" name="name" class="form-control" value="{{$movie->FNAME}}"  readonly>
                        </div>
                      </div>--}}
					{{--<div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">拍摄周期</label>
                        <div class="col-sm-10">
                          <input type="text" name="name" class="form-control" value="{{$movie->FNAME}}"  readonly>
                        </div>
                      </div>--}}
					{{--<div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">进组密码</label>
                        <div class="col-sm-10">
                          <input type="text" name="name" class="form-control" value="{{$movie->FNAME}}"  readonly>
                        </div>
                      </div>--}}
					{{--<div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">是否允许人员加入</label>
                        <div class="col-sm-10">
                          <input type="text" name="name" class="form-control" value="{{$movie->FISOROPEN}}"  readonly>
                        </div>
                      </div>--}}

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


