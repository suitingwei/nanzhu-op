@extends('layouts.admin')

@section('title')
商品品牌
@stop

@section('content')
	<style>
		table th{font-size: 14px}
		.label{font-size: 100%}
	</style>

	<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">商品品牌列表</div>
	  <div class="pull-right">
		<a class="btn btn-primary btn-sm" href="/admin/product-brands/create" id="addgoods">添加商品品牌</a>
	  </div>
	  <div class="clearfix"></div>
	</div>


	<div class="max-table widget-content">

		<hr>
		<div class="panel panel-default">

			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover ">
						<thead>
						<tr class="info">
							<th >#</th>
							<th >品牌名称</th>
							<th >品牌介绍</th>
							<th >创建时间</th>
							<th >排序值</th>
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
		var idnumber=0;
		$.ajax({
			type:"get",
			url:thisurl+"/api/malls/brands",
			success:function(res){
				console.log(res.msg.brands);
				for(var i=0 ;i<res.msg.brands.length;i++){
					var newtr=document.createElement("tr");
					goodsdetail=res.msg.brands[i];
					idnumber++;
					newtr.innerHTML="<tr>" +
									"<td>"+goodsdetail.id+"</td>" +
									"<td>"+goodsdetail.title+"</td>" +
									"<td>"+goodsdetail.introduction+"</td>" +
									"<td>"+goodsdetail.updated_at+"</td>" +
									"<td>"+goodsdetail.sort+"</td>" +
									"<td>" +
									"&nbsp" +
									"<a href='/admin/product-brands/"+goodsdetail.id+"/edit?" +
									"title="+goodsdetail.title+"&sort="+goodsdetail.sort+"&intro="+goodsdetail.introduction+"' class='label label-info ' style='padding:2px 5px'>编 辑</a></td>" +
									"</tr>";
					tbody.appendChild(newtr)
				}
			}
		});
		function deleteThisGood(id){

			$.ajax({
				type:"delete",
				url:thisurl+"/api/malls/brands/"+id
			})
			location.reload()
		};
</script>

@endsection