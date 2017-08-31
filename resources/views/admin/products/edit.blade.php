@extends('layouts.admin')

@section('title')
	商品编辑
@stop

@section('dropzone_css')
	<link href="/assets/javascripts/dropzone/dropzone.min.css" rel="stylesheet">
@endsection

@section('content')
	<head>
		<meta http-equiv="Cache-Control" content="no-cache">
	</head>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
	<script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
	<script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>
	<style>

	</style>
	<div class="widget wgreen">
		<div class="widget-head">
			<div class="pull-left">商品编辑</div>
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
						<label class="col-lg-2 control-label">商品规格</label>
						<div class="col-lg-8">
							<div class="row">
								<div class="col-lg-4" >
									<table id="product-size" class="table table-hover" >
										<thead>
										<tr class="info">
											<th>
												#
											</th>
											<th >
												商品规格
											</th>
											<th >
												销售价
											</th>
										</tr>
										</thead>

									</table>
								</div>

							</div>
						</div>
					</div>

					<div class="form-group" >
						<label class="col-lg-2 control-label">商品状态</label>
						<div class="col-lg-8">
							<div class="radio">
								<label>
									<input checked type="radio" name="blankRadio" class="blankRadio" value="1">已上架
								</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label>
									<input type="radio" name="blankRadio" class="blankRadio" value="0">未上架
								</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label>
									<input type="radio" name="blankRadio" class="blankRadio" value="2">已下架
								</label>
							</div>
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

					<div class="form-group">
						<label class="col-lg-2 control-label">商品图片</label>
						<div class="col-lg-8">
							<div id="dropzPic" class="dropzone">
								<div class="dz-message">
									点击上传或将文件拖至此处或.<br />
									<span class="help-block">图片上传格式 jpg, png <span class="h4 text-danger">主文件名中不能带 "."</span></span>
								</div>
							</div>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">banner</label>
						<div class="col-lg-8">
							<div id="dropzban" class="dropzone">
								<div class="dz-message">
									点击上传或将文件拖至此处或.<br />
									<span class="help-block">图片上传格式 jpg, png <span class="h4 text-danger">主文件名中不能带 "."</span></span>
								</div>
							</div>
						</div>

					</div>
					{{--快递单号不用
					<div class="form-group">
						<label class="col-lg-2 control-label">快递单号</label>
						<div class="col-lg-8">
							<input name="postid" type="text" class="form-control" placeholder="请输入快递单号">
						</div>
					</div>--}}
				</form>
			</div>
		</div>
		<div class="widget-foot">
			<div class="col-lg-offset-2">
				<button id="saves" type="submit" class="btn btn-lg btn-success btn-submit" onclick="edit()">保存</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:history.go(-1)" class="btn btn-lg btn-default">返回</a>
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
	<script src="/assets/admin/js/changeurl.js">
	</script>
	<script>
		var thisurl=changeurl();
		Array.prototype.indexOf = function(val) {
			for (var i = 0; i < this.length; i++) {
				if (this[i] == val) return i;
			}
			return -1;
		};
		Array.prototype.remove = function(val) {
			var index = this.indexOf(val);
			if (index > -1) {
				this.splice(index, 1);
			}
		};
		var imgurlarr=[];
		var banurlarr=[];
		$("#dropzPic").dropzone({
			url: thisurl+"/api/pictures",
			cachecontrol:false,
			method:"post",
			acceptedFiles: ".jpg,.png",
			paramName:"file",
			addRemoveLinks: true,
			init: function() {
				this.on("addedfile", function(file) {
					if (file.name.split('.').length - 1 != 1) {
						alert('您上传的文档主文件名中含有英文标点“.”请修改后再次上传，否则手机上无法正常打开。例如“12.10”改成“12月10日”。谢谢您的理解和配合！');
						this.removeFile(file);
					}
					// Create the remove button
					var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn-tgddel btn btn-danger btn-sm btn-block' data-dz-remove>删除</a>");

					// Capture the Dropzone instance as closure.
					var _this = this;

					// Listen to the click event
					removeButton.addEventListener("click", function(e) {
						// Make sure the button click doesn't submit the form:
						e.preventDefault();
						e.stopPropagation();
						var wasteurl=eval("("+file.xhr.responseText+")").data.url;
						imgurlarr.remove(wasteurl);
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

					console.log(response);
					imgurlarr.push(response.data.url);
					$(".btn-submit").removeAttr("disabled")
				});
			}
		});
		$("#dropzban").dropzone({
			url: thisurl+"/api/pictures",
			cachecontrol:false,
			method:"post",
			acceptedFiles: ".jpg,.png",
			paramName:"file",
			addRemoveLinks: true,
			init: function() {
				this.on("addedfile", function(file) {
					if (file.name.split('.').length - 1 != 1) {
						alert('您上传的文档主文件名中含有英文标点“.”请修改后再次上传，否则手机上无法正常打开。例如“12.10”改成“12月10日”。谢谢您的理解和配合！');
						this.removeFile(file);
					}
					// Create the remove button
					var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn-tgddel btn btn-danger btn-sm btn-block' data-dz-remove>删除</a>");

					// Capture the Dropzone instance as closure.
					var _this = this;

					// Listen to the click event
					removeButton.addEventListener("click", function(e) {
						// Make sure the button click doesn't submit the form:
						e.preventDefault();
						e.stopPropagation();
						var wasteurl=eval("("+file.xhr.responseText+")").data.url
						banurlarr.remove(wasteurl)
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

					console.log(response)
					banurlarr.push(response.data.url)
					$(".btn-submit").removeAttr("disabled")
				});
			}
		});
		var address=location.href;
		var id=address.split("/")[5];
		var title,sort,introduction;
		var productsizedesc=[];
		var isShow=document.getElementsByClassName("blankRadio");
		$.ajax({
			type:"get",
			url :thisurl+"/api/malls/products/"+id,
			success:function(res){
				title=res.data.product.title;
				sort=res.data.product.sort;
				introduction=res.data.product.introduction;
				$("input[name='name']").val(title);
				$("input[name='sort']").val(sort);
				$("#introduction").val(introduction);
				productsizedesc=res.data.product.size_prices;
				productisshow=res.data.product.is_show;
				for(var i=0;i<isShow.length;i++){
					if(isShow[i].value==productisshow){
						isShow[i].checked=true
					}
				}
				for(var i=0;i<productsizedesc.length;i++){
					var tr=document.createElement("tr");
					tr.className="active";
					var num=i+1;
					tr.innerHTML="<td>"+num+"</td><td>"+productsizedesc[i].desc+"</td><td>"+productsizedesc[i].price+"</td>"
					$("#product-size").append(tr)
				}

				/*$.ajax({
					type:"get",
					url: thisurl+"/api/malls/product-sizes",
					success:function(res){
						var productsize=res.data.produce_sizes;

						for(var i=0;i<productsize.length;i++){
							var ul=document.createElement("ul");
							ul.className="pro-option list-unstyled";
							ul.innerHTML=
									"<li><div class='checkbox'>" +
									"<label><input  class='selection' type='checkbox' disabled=true value='"+productsize[i].desc+"' /><span >"+productsize[i].desc+"</span></label>" +
									"<input type='hidden' class='productsizeid' value='"+productsize[i].id+"'/ >" +
									"<li><div class='input-group'>" +
									"<input type='form-control' type='text' readonly=true  placeholder='销售价' class='price'/>" +
									"<div class='input-group-addon'>￥</div></div></li>"
							$("#product-size").append(ul)

						}
						var lens=document.getElementsByClassName('selection');

						var price=document.getElementsByClassName('price');
						//显示那个规格是否被选中
						for(var i=0;i<lens.length;i++){
							for(var j=0;j<productsizedesc.length;j++){
								if(productsizedesc[j].desc==lens[i].value){
									lens[i].checked=true;
									price[i].value=productsizedesc[j].price;

								}
							}
						}
					}
				});*/
			}
		});

		/*var price=[];
		var productsizeid=[];

		function isSelected(index){
			var	select=document.getElementsByClassName("selection")[index];
			var forthisprice=document.getElementsByClassName("price")[index];
			var thisprice=forthisprice.value;
			var thissizeid=document.getElementsByClassName("productsizeid")[index].value;
			if(select.checked) {
				price.push(thisprice);
				productsizeid.push(thissizeid);
				forthisprice.readOnly=true
			}
			else{
				price.remove(thisprice,1)
				productsizeid.remove(thissizeid,1)
				forthisprice.readOnly=false
			}
			console.log(price);
			console.log(productsizeid)
		}
*/

		function edit(){
			var newtitle = $("input[name='name']").val();
			var newsort  = $("input[name='sort']").val();
			var newintroduction= $("#introduction").val();
			//var postid=$("input[name='postid']").val();
			var imgallurl=imgurlarr.join(',');
			var banallurl=banurlarr.join(',');
			//console.log(imgallurl)
			//console.log( price + "," + productsizeid);
			var reg=/^\d+$/;
			var isShownum;
			for(var i=0;i<isShow.length;i++){
				if(isShow[i].checked){
					isShownum=isShow[i].value
				}
			}
			if($("input[name='name']").val()=="" ){
				alert("name不能为空")
			}
			else if($("input[name='sort']").val()!=""&& reg.test($("input[name='sort']").val())==false){
				alert("sort只能为数字")
			}
			else if(imgallurl=="" && banallurl=="" ){
					$.ajax({
						 type:"put",
						 url: thisurl+"/api/malls/products/"+id,
						 data:{"title":newtitle,"introduction":newintroduction,"sort":newsort,"is_show":isShownum},
						 success:function(res){
						 console.log(res);
						 self.location = document.referrer;
					 }
					 });
			}
			else if(imgallurl=="" && banallurl!="" ){
				$.ajax({
					type:"put",
					url: thisurl+"/api/malls/products/"+id,
					data:{"title":newtitle,"introduction":newintroduction,"sort":newsort,"is_show":isShownum,"banners":banallurl},
					success:function(res){
						console.log(res);
						self.location = document.referrer;
					}
				});
			}
			else if(imgallurl!="" && banallurl=="" ){
				$.ajax({
					type:"put",
					url: thisurl+"/api/malls/products/"+id,
					data:{"title":newtitle,"introduction":newintroduction,"sort":newsort,"is_show":isShownum,"img_url":imgallurl},
					success:function(res){
						console.log(res);
						self.location = document.referrer;
					}
				});
			}
			else if(imgallurl!="" && banallurl!="" ){
				$.ajax({
					type:"put",
					url: thisurl+"/api/malls/products/"+id,
					data:{"title":newtitle,"introduction":newintroduction,"sort":newsort,"is_show":isShownum,"img_url":imgallurl,"banners":banallurl},
					success:function(res){
						console.log(res);
						self.location = document.referrer;
					}
				});
			}
		}
	</script>

@endsection