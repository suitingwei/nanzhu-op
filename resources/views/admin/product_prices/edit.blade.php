@extends('layouts.admin')

@section('title')
	商品编辑
@stop

@section('dropzone_css')
	<link href="/assets/javascripts/dropzone/dropzone.min.css" rel="stylesheet">
@endsection

@section('content')

	<link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
	<script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
	<script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>


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

		var editor = new Editor({ element: document.getElementById("introduction") });
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
@endsection