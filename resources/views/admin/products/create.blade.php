@extends('layouts.admin')

@section('title')
添加商品
@stop

@section('dropzone_css')
	<link href="/assets/javascripts/dropzone/dropzone.min.css" rel="stylesheet">
@endsection

@section('content')

<link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
<script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
<script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>

<div class="widget wgreen">
	<div class="widget-head">
		<div class="pull-left">添加商品</div>
		<div class="pull-right">
			<a href="javascript:history.go(-1)" class="btn btn-default btn-sm" href="">返回</a>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="widget-content">

		<div class="padd">
			<form class="pro-form form-horizontal" action="" method="POST" enctype='multipart/form-data'>
				<div class="form-group">
				  <label class="col-lg-2 control-label">商品名称</label>
				  <div class="col-lg-8">
					<input name="name" type="text" class="form-control" placeholder="填写商品名称">
				  </div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">排序</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" placeholder="数值越大越在前面" name="sort" value="">
					</div>
				</div>

				<div class="form-group">
				  <label class="col-lg-2 control-label">商品介绍</label>
				  <div class="col-lg-8">
					  <div class="bg-white">
						  <textarea id="introduction" name="introduction" class="form-control"></textarea>
					  </div>
				  </div>
				</div>

			</form>
		</div>

		<div class="widget-foot">
			<div class="col-lg-offset-2">
				<button id="saves" type="submit" class="btn btn-lg btn-success btn-submit" onclick="create()">保存</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:history.go(-1)" class="btn btn-lg btn-default">返回</a>
			</div>
		</div>

	</div>
</div><!-- end -->

<script src="/assets/admin/js/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('form').submit(function() {
            if ($("input[name='name']").val() =="") {
                alert("请填写商品名称");
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
@endsection

@section('dropzone_js')
	<script src="/assets/javascripts/dropzone/dropzone.min.js"></script>
	<script>
		$("#dropzPic").dropzone({
			url: "/upload",
			maxFiles: 9,
			maxFilesize: 5,
			acceptedFiles: ".jpg,.png",
			addRemoveLinks: true,

			init: function() {
				this.on("addedfile", function(file) {

					// Create the remove button
					var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn-tgddel btn btn-danger btn-sm btn-block' data-dz-remove>删除</a>");

					// Capture the Dropzone instance as closure.
					var _this = this;

					// Listen to the click event
					removeButton.addEventListener("click", function(e) {
						// Make sure the button click doesn't submit the form:
						e.preventDefault();
						e.stopPropagation();

						// Remove the file preview.
						_this.removeFile(file);
						// If you want to the delete the file on the server as well,
						// you can do the AJAX request here.
					});

					// Add the button to the file preview element.
					file.previewElement.appendChild(removeButton);
				});
				this.on("processing",function (file) {
					$(".btn-submit").attr("disabled","true")
				});
				this.on('success',function(file,response){

					var newImgInput = "<input type=hidden name='img_url[]' value="+response.data.uploaded_file_url+">";

					$('form').append(newImgInput);
					$(".btn-submit").removeAttr("disabled")
				});
			}
		});
	</script>
	<script src="/assets/admin/js/changeurl.js">
	</script>
	<script>
		var thisurl=changeurl();
		function create(){
			var reg=/^\d+$/;

			if($("input[name='name']").val()=="" ){
				alert("name不能为空")
			}
			else if($("input[name='sort']").val()!=""&& reg.test($("input[name='sort']").val())==false){
				alert("sort只能为数字")
			}
			else{
				var newtitle = $("input[name='name']").val();
				var newsort  = $("input[name='sort']").val();
				var newintroduction= $("#introduction").val();
				console.log(newtitle+","+newsort+","+newintroduction)
				$.ajax({
					type:"post",
					url: thisurl+"/api/malls/products",
					data:{"title":newtitle,"introduction":newintroduction,"sort":newsort},
					success:function(res){
						self.location = document.referrer;
					}
				});

			}

		}
	</script>
@endsection