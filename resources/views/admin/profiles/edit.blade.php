@extends('layouts.admin')

@section('title')
	编辑艺人
@stop

@section('content')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
	<script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
	<script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>
	
	
	<div class="widget wgreen">
		<div class="widget-head">
			编辑艺人
		</div>
		
		<div class="widget-content">
			<div class="padd">
				
				<form class="form-horizontal" action="/admin/profiles/{{$profile->id}}" method="POST"
					  enctype='multipart/form-data'>
					<input type="hidden" name="_method" value="PATCH">
					{!! csrf_field() !!}
					<div class="form-group">
						<label class="col-lg-2 control-label">头像</label>
						<div class="col-lg-8">
							<input name="avatar" type="file" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">名称</label>
						<div class="col-lg-8">
							<input name="name" class="form-control" placeholder="名称" value="{{$profile->name}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">user_id</label>
						<div class="col-lg-8">
							<input name="user_id" class="form-control" placeholder="名称" value="{{$profile->user_id}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">生日</label>
						<div class="col-lg-8">
							<input name="birthday" class="form-control" value="{{$profile->birthday}}">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">性别</label>
						<div class="col-lg-8">
							<div class="radio">
								<label><input type="radio" name="gender" value="男" @if($profile->gender=="男") checked @endif>男</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label><input type="radio" name="gender" value="女" @if($profile->gender=="女") checked @endif>女</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">台前职位</label>
						<div class="col-lg-8">
							<div class="row">
								@foreach(App\Models\Profile::$beforeScenePositions as $before_position)
									<div class="col-lg-3">
										<label class="label label-success">
											<input type="checkbox" name="before_position[]" value="{{$before_position}}"
										   	@if(strpos($profile->before_position, $before_position)!== false) checked="checked" @endif class="beforeposition"/>{{$before_position}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">幕后职位</label>
						<div class="col-lg-8">
							<div class="row">
								@foreach(App\Models\Profile::$behindScenePositions as $behind_position)
									<div class="col-lg-3">
										<label class="label label-info">
											<input type="checkbox" name="behind_position[]" value="{{$behind_position}}"
										   @if(strpos($profile->behind_position, $behind_position)!== false) checked="checked" @endif class="behindposition"/>{{$behind_position}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">职业类型</label>
						<div class="col-lg-8">
							<div class="row">
								@foreach(App\Models\Profile::types() as $type)
									<div class="col-lg-3">
										<label class="label label-warning">
											<input type="checkbox" name="type[]" value="{{$type}}"
										   @if(strpos($profile->type, $type)!== false) checked="checked" @endif />{{$type}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">身高</label>
						<div class="col-lg-8">
							<div class="input-group">
								<input class="form-control" name="height" value="{{$profile->height}}">
								<div class="input-group-addon">cm</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">体重</label>
						<div class="col-lg-8">
							<div class="input-group">
								<input class="form-control" name="weight" value="{{$profile->weight}}">
								<div class="input-group-addon">kg</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"> 语言 </label>
						<div class="col-lg-8">
							<input name="language" class="form-control" value="{{$profile->language}}">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label"> 自我介绍 </label>
						<div class="col-lg-8">
							<div class="bg-white"><textarea id="introduction" name="introduction">{{$profile->introduction}}</textarea></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"> 学校 </label>
						<div class="col-lg-8">
							<input name="college" class="form-control" value="{{$profile->college}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"> 特长 </label>
						<div class="col-lg-8">
							<input name="speciality" class="form-control" value="{{$profile->speciality}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"> 星座 </label>
						<div class="col-lg-8">
							<select name="constellation" class="form-control">
								<option value="">请选择</option>
								@foreach(App\Models\Profile::$constellation_arr as $a)
									<option value="{{$a}}"
											@if($a == $profile->constellation) selected @endif>{{$a}}</option>
								@endforeach
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label"> 血型 </label>
						<div class="col-lg-8">
							<select name="blood_type" class="form-control" id="blood_type">
								<option value="">请选择</option>
								@foreach(App\Models\Profile::$bloodTypes as $a)
									<option value="{{$a}}"
									@if($a == $profile->blood_type) selected @endif>{{$a}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"> 作品简历 </label>
						
						<div class="col-lg-8">
							<div class="bg-white"><textarea id="work_ex" name="work_ex">{{$profile->work_ex}}</textarea></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"> 获奖经历</label>
						
						<div class="col-lg-8">
							<div class="bg-white"><textarea id="prize_ex" name="prize_ex">{{$profile->prize_ex}}</textarea></div>
						</div>
					
					</div>
					
					
					<div class="form-group">
						<label class="col-lg-2 control-label"> 联系方式</label>
						<div class="col-lg-8">
							<div class="bg-white"><textarea id="email" name="email">{{$profile->email}}</textarea></div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label"> 排序 数值越大越在前面</label>
						<div class="col-lg-8">
							<input type="text" name="sort" value="{{$profile->sort}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">是否显示</label>
						<div class="col-lg-8">
							<div class="radio">
								<label><input type="radio" name="is_show" @if($profile->is_show==1) checked @endif value="1">是</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label><input type="radio" name="is_show" @if($profile->is_show==0) checked @endif value="0">否</label>
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-6">
							<button type="submit" class="btn btn-lg btn-primary">保存</button>
						</div>
					</div>
				
				</form>
			</div>
		</div>
		<div class="widget-foot">
			<!-- Footer goes here -->
		</div>
	</div>
	
	<script src="/assets/admin/js/jquery.js"></script>
	<script>
		$(document).ready(function () {
			$('form').submit(function () {
				if ($("input[name='name']").val() == "") {
					alert("请填写名称");
					return false;
				}
				if (typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
					jQuery.data(this, "disabledOnSubmit", {submited: true});
					$('input[type=submit], input[type=button]', this).each(function () {
						$(this).attr("disabled", "disabled");
					});
					return true;
				}
				else {
					return false;
				}
			});
		});
	</script>
	<script type="text/javascript" charset="utf-8">
		var editor = new Editor({element: document.getElementById("prize_ex")});
		
		var editor = new Editor({element: document.getElementById("work_ex")});
		
		var editor = new Editor({element: document.getElementById("introduction")});
		
		var editor = new Editor({element: document.getElementById("email")});

		var behind = document.getElementsByClassName('behindposition');
		var before = document.getElementsByClassName('beforeposition');
		$('.beforeposition').click(function(){
		    for(var i=0;i<behind.length;i++){
		        behind[i].checked=false;
			}
		})
        $('.behindposition').click(function(){
            for(var i=0;i<before.length;i++){
                before[i].checked=false;
            }
        })
	</script>
@endsection



