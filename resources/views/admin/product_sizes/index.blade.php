@extends('layouts.admin')

@section('title')
商品规格
@stop

@section('content')
	<style>
		table th{font-size: 14px}
		.label{font-size: 100%}
	</style>

	<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">商品规格列表</div>
	  <div class="pull-right">
		<a class="btn btn-primary btn-sm" href="/admin/product-sizes/create" id="addgoods">添加商品规格</a>
	  </div>
	  <div class="clearfix"></div>
	</div>


	<div class="max-table widget-content">

		{{--<div class="padd form-option">
			<form class="form-inline" action="/admin/profiles">
			  <div class="form-group">
			    <label for="">商品名称</label>
			    <input type="text" name="name" class="form-control" placeholder="请输入商品名称">
			  </div>
			  <div class="form-group">
				<label for="">是否显示</label>
				  <input type="radio" name="is_show" value="2">否
				  <input type="radio" name="is_show" value="1">是
			  </div>
			  <button type="submit" class="btn btn-primary btn-sm">搜索</button>
			</form>
		</div>--}}
		<hr>
		<div class="panel panel-default">

			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover ">
						<thead>
						<tr class="info">
							<th >#</th>
							<th >商品规格</th>
							<th >创建时间</th>
							<th >排序</th>
							<th >操作</th>
						</tr>
						</thead>
						<tbody id="tbody">

						</tbody>
					</table>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>



		<div class="widget-foot">
		  <div class="clearfix"></div>
		</div>
	</div>

</div>
	<script src="/assets/admin/js/jquery.js"></script>
<script src="/assets/admin/js/changeurl.js">
</script>
<script>
		var thisurl=changeurl();
		var goodsdetail;
		var tbody=document.getElementById("tbody");
		var idnumber=0
		$.ajax({
			type:"get",
			url:thisurl+"/api/malls/product-sizes",
			success:function(res){
				console.log(res)
				for(var i=0 ;i<res.data.produce_sizes.length;i++){
					var newtr=document.createElement("tr");
					goodsdetail=res.data.produce_sizes[i];
					idnumber++;
					newtr.innerHTML="<tr>" +
									"<td>"+goodsdetail.id+"</td>" +
									"<td>"+goodsdetail.desc+"</td>" +
									"<td>"+goodsdetail.created_at+"</td>" +
									"<td>"+goodsdetail.sort+"</td>" +
									"<td>" +
									"&nbsp" +
									"<a href='/admin/product-sizes/"+goodsdetail.id+"/edit?" +
									"desc="+goodsdetail.desc+"&sort="+goodsdetail.sort+"' class='label label-info ' style='padding:2px 5px'>编 辑</a></td>" +
									"</tr>";
					tbody.appendChild(newtr)
				}
			}
		});
		function deleteThisGood(id){

			$.ajax({
				type:"delete",
				url:thisurl+"/api/malls/product-sizes/"+id
			})
			location.reload()
		};
</script>

@endsection