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

				<form class="form-horizontal" action="/admin/profiles/editpic/{{$profile->id}}" method="post"
					  enctype='multipart/form-data'>
					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group">
						<label class="col-lg-2 control-label">形象照</label>
						<div class="col-lg-8" id="album1">
							<a onclick="addphoto(1)" class="label label-info form-control">添加一张形象照</a>

						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">剧照</label>
						<div class="col-lg-8" id="album2">
							<a onclick="addphoto(2)" class="label label-info form-control">添加一张剧照</a>

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
		function addphoto(type){
			var input = document.createElement('input');
			input.type= 'file';
			input.className='form-control';
			if(type==1){
				input.name='album1[]';
				album1.appendChild(input);
			}
			if(type==2){
				input.name='album2[]';
				album2.appendChild(input);
			}
		}
	</script>
@endsection



