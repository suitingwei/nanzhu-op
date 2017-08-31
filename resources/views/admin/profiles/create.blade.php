@extends('layouts.admin')

@section('title')
创建艺人
@stop

@section('content')

<link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
<script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
<script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>

<div class="widget wgreen">
	<div class="widget-head">
		创建艺人
	</div>

	<div class="widget-content">
	  <div class="padd">

			<form class="form-horizontal" action="/admin/profiles" method="POST" enctype='multipart/form-data' >
			{!! csrf_field() !!}
			<div class="form-group">
			  <label class="col-lg-2 control-label">头像</label>
			  <div class="col-lg-8">
				<input name="avatar"  type="file" class="form-control" >
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-lg-2 control-label">名称</label>
			  <div class="col-lg-8">
				<input name="name" class="form-control" placeholder="名称">
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label">性别</label>
			  <div class="col-lg-8">
				  <div class="radio">
					  <label><input name="gender" type="radio" value="男">男</label>
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <label><input name="gender" type="radio" value="女">女</label>
				  </div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label">生日</label>
			  <div class="col-lg-8">
				<input name="birthday" class="form-control" placeholder="名称">
			  </div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">台前职位</label>
				<div class="col-lg-8">
					<div class="row">
						@foreach(App\Models\Profile::$beforeScenePositions as $before_position)
							<div class="col-lg-3">
								<label class="label label-success">
									<input type="checkbox" name="before_position[]" value="{{$before_position}}" class="beforeposition"/>{{$before_position}}
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
									<input type="checkbox" name="behind_position[]" value="{{$behind_position}}" class="behindposition"/>{{$behind_position}}
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
						  <div class="col-lg-2">
							  <label class="label label-warning">
								  <input type="checkbox" name="type[]" value="{{$type}}" />{{$type}}
							  </label>
						  </div>
					  @endforeach
				  </div>
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-lg-2 control-label">身高 </label>
			  <div class="col-lg-8">
				  <div class="input-group">
					  <input class="form-control" name="height" placeholder="">
					  <div class="input-group-addon">cm</div>
				  </div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label"> 体重  </label>
			  <div class="col-lg-8">
				  <div class="input-group">
					  <input class="form-control" name="weight" placeholder="">
					  <div class="input-group-addon">kg</div>
				  </div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label"> 语言  </label>
			  <div class="col-lg-8">
				<input name="language" class="form-control" >
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-lg-2 control-label">自我介绍</label>
			  <div class="col-lg-8">
				<div class="bg-white"><textarea id="introduction" name="introduction" class="form-control" ></textarea></div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label"> 学校  </label>
			  <div class="col-lg-8">
				<input name="college" class="form-control" >
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label"> 特长  </label>
			  <div class="col-lg-8">
				<input name="speciality" class="form-control" >
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label"> 星座 </label>
			  <div class="col-lg-8">
				<select name="constellation" class="form-control">
					<option value="">请选择</option>
					<option value="水瓶座">水瓶座</option>
					<option value="双鱼座">双鱼座</option>
					<option value="白羊座">白羊座</option>
					<option value="金牛座">金牛座</option>
					<option value="双子座">双子座</option>
					<option value="巨蟹座">巨蟹座</option>
					<option value="狮子座">狮子座</option>
					<option value="处女座">处女座</option>
					<option value="天秤座">天秤座</option>
					<option value="天蝎座">天蝎座</option>
					<option value="射手座">射手座</option>
					<option value="魔蝎座">魔蝎座</option>
				</select>
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-lg-2 control-label"> 血型  </label>
			  <div class="col-lg-8">
					<select name="blood_type" class="form-control" id="blood_type">
						<option value="">请选择</option>
						<option value="A">A</option>
						<option value="AB">AB</option>
						<option value="B">B</option>
						<option value="O">O</option>
					</select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label"> 作品简历 </label>
			  <div class="col-lg-8">
				  <div class="bg-white"><textarea name="work_ex" id="work_ex" class="form-control" ></textarea></div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-lg-2 control-label"> 获奖经历</label>
			  <div class="col-lg-8">
				  <div class="bg-white"><textarea id="prize_ex" name="prize_ex" class="form-control" ></textarea></div>
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-lg-2 control-label">联系方式</label>
			  <div class="col-lg-8">
				  <div class="bg-white"><textarea id="email"  name="email" ></textarea></div>
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-lg-2 control-label"> 排序 数值越大越在前面</label>
			  <div class="col-lg-8">
					<input type="text" name="sort" value="">
			  </div>
			</div>

			<div class="form-group" >
			  <label class="col-lg-2 control-label">是否显示</label>
			  <div class="col-lg-8">
				  <div class="radio">
					  <label><input type="radio" name="is_show" value="1">是</label>
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <label><input type="radio" name="is_show" value="0">否</label>
				  </div>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-lg-offset-2 col-lg-6">
				<button id="saves" type="submit" class="btn btn-lg btn-primary" onclick="button_disabled()">保存</button>
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
    $(document).ready(function() {
        $('form').submit(function() {
            if ($("input[name='name']").val() =="") {
                alert("请填写名称");
                return false;
            }
            if(typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
                jQuery.data(this, "disabledOnSubmit", { submited: true });
                $('input[type=submit], input[type=button]', this).each(function() {
                    $(this).attr("disabled", "disabled");
                });
                return true;
            }
            else
            {
                return false;
            }
        });
    });
</script>
<script type="text/javascript" charset="utf-8">
var editor = new Editor({ element: document.getElementById("prize_ex") });

var editor = new Editor({ element: document.getElementById("work_ex") });

var editor = new Editor({ element: document.getElementById("introduction") });

var editor = new Editor({ element: document.getElementById("email") });
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