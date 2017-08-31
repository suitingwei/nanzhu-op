@extends('layouts.admin')

@section('title')
	商品编辑
@stop

@section('dropzone_css')
	<link href="/assets/javascripts/dropzone/dropzone.min.css" rel="stylesheet">
@endsection

@section('content')
	<style>
		table td{
			padding:10px 20px;
		}
	</style>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
	<script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
	<script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>

	<div class="widget wgreen">
		<div class="widget-head">
			<div class="pull-left">商品编辑</div>
			<div class="pull-right">
				<a href="javascript:history.go(-1)" class="btn btn-default btn-sm" href="javascript:history.go(-1)">返回</a>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="widget-content">

			<table>
				<tr>
				<td>商品规格</td><td><input type="text" id="newdescription" /></td>
				</tr>
				<tr>
				<td>排序值</td><td><input type="text" id="newsort" /></td>
				</tr>
				<tr><td></td><td><button onclick="edit()" class="btn-primary">确定修改</button></td></tr>
			</table>
		</div>
	</div><!-- end -->
	<script src="/assets/admin/js/jquery.js"></script>
	<script src="/assets/admin/js/changeurl.js">
	</script>
	<script>
		var thisurl=changeurl();

		var address=location.href;
		var id=address.split("/")[5]
		var getdata=address.split("?")[1].split("&");
		var description,sort;
		for(var i=0;i<getdata.length;i++){
			if(getdata[i].split("=")[0]=="desc"){
				description=getdata[i].split("=")[1];
			}
			if(getdata[i].split("=")[0]=="sort"){
				sort=getdata[i].split("=")[1];
			}
		}
		description=decodeURIComponent(description)
		$("#newdescription").val(description)
		$("#newsort").val(sort);
		function edit(){
				var reg=/^\d+$/;
				if($("#newdescription").val()=="" ||  reg.test($("#newsort").val())==false){
					alert("description不能为空并且，sort只能为数字")
				}
				else {
					var newtitle = $("#newdescription").val();
					var newsort = $("#newsort").val();
					console.log(newtitle + "," + newsort)
					$.ajax({
						type: "put",
						url: thisurl+"/api/malls/product-sizes/" + id,
						data: {"desc": newtitle, "sort": newsort},
						success: function (res) {
							history.back()
						}
					})
				}

		}
	</script>
@endsection
