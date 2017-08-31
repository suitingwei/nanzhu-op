@extends('layouts.admin')

@section('title')
商品信息
@stop

@section('content')

<style>
	.forproductsize td{padding:3px 6px}
	.jiacu {font-size: 14px;font-weight: 900}
	 table th{font-size: 14px;}
	.label{font-size: 100%}
</style>
	<div class="widget">

	<div class="widget-head">
	  <div class="pull-left">商品列表</div>
	  <div class="pull-right">
		<a class="btn btn-primary btn-sm" href="/admin/products/create">添加商品</a>
	  </div>
	  <div class="clearfix"></div>
	</div>


	<div class="max-table widget-content">

		<div class="padd form-option">

			  <div class="form-group" style="position:relative">
			    <label for="">商品名称</label>
			    <input type="text" name="name" class="form-control" id="thisgoodsname" placeholder="请输入商品名称" style="width:20%;display:inline-block">
				<ul id="showthisgoodsname" style="position: absolute;top:32px;left:51px;width:200px;background:white;list-style: none;padding:0px"></ul>
				  <a class="label label-info" onclick="justshowthistitle()">搜索</a>
				  <a class="label label-primary" onclick="showall()">显示全部</a>
			   </div>
			{{--  <div class="form-group">
				<label for="">是否显示</label>
				  <input type="radio" name="is_show" value="2">否
				  <input type="radio" name="is_show" value="1">是
			  </div>--}}


		</div>
		<hr>
		<div class="panel panel-default">

			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
						<tr class="info">
							<th class="col-md-1">#</th>
							<th class="col-md-2">商品图片</th>
							<th class="col-md-1">商品名称/品牌</th>
							<th class="col-md-3">商品规格</th>
							<th class="col-md-1">商品状态</th>
							<th class="col-md-2">创建时间</th>
							<th class="col-md-1">排序</th>
							<th class="col-md-1">操作</th>
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
	<script	>
	var thisurl=changeurl();
		var goodsdetail;
		var tbody=document.getElementById("tbody");
		var goodstitlearr=[];
		$.ajax({
			type:"get",
			url: thisurl+"/api/malls/products",
			data:{'from':'op'},
			success:function(res){
				console.log(res)
				for(var i=0 ;i<res.data.products.length;i++){
					var newtr=document.createElement("tr");
					goodsdetail=res.data.products[i];

					var goodsrangeArr=goodsdetail.size_prices;

					goodstitlearr.push(goodsdetail.title);
					newtr.setAttribute('name',goodsdetail.title);
					var brandtitle="";
					for(var x=0;x<goodsdetail.brands.length;x++){
						if(goodsdetail.brands[x]){
							brandtitle=goodsdetail.brands[x].title
						}
					}
					newtr.innerHTML=
								"<td>"+goodsdetail.id+"</td>" +
								"<td><img style='width:90px;height:80px' src='"+goodsdetail.picture[0]+"'></td>" +
								"<td><a href=''>"+goodsdetail.title+"</a><br /><br/>"+brandtitle+"</td>" +
								"<td><table class='pro-option list-unstyled forproductsize'></table></td>" +
								"<td class='thisgoodstatus'></td>" +
								"<td>"+goodsdetail.created_at+"</td>" +
								"<td>"+goodsdetail.sort+"</td>" +
								"<td>" +
									/*"<span onclick=javascript:deleteThisGood('"+goodsdetail.id+"')  class='btn btn-sm btn-danger'>删除</span> &nbsp" +*/
									"<a href='/admin/products/"+goodsdetail.id+"/edit' class='btn btn-sm btn-primary jiacu'>编辑</a><br />" +
									"<a href='/admin/products/"+goodsdetail.id+"/prices'  class='btn btn-sm btn-info jiacu'>改价</a>" +
									"<a href='/admin/products/"+goodsdetail.id+"/brands'  class='btn btn-sm btn-info jiacu'>品牌</a>" +
								"</td>";

					tbody.appendChild(newtr);
					//thisgoodstatus
					var thisgoodstatus=document.getElementsByClassName('thisgoodstatus')[i];
					var thisgoodstyle=document.createElement("p");
					var num=Number(goodsdetail.is_show);
					switch(num){
						case 0:
							thisgoodstyle.innerHTML="<span class='label label-danger'>未上架</span>";
							thisgoodstatus.appendChild(thisgoodstyle);
							break;
						case 1:
							thisgoodstyle.innerHTML="<span class='label label-success'>已上架</span>";
							thisgoodstatus.appendChild(thisgoodstyle);
							break;
						case 2:
							thisgoodstyle.innerHTML="<span class='label label-default'>已下架</span>";
							thisgoodstatus.appendChild(thisgoodstyle);
							break;
					};
					//thisgood price
					for(var j=0;j<goodsrangeArr.length;j++){
						var newli=document.createElement("tbody");
						newli.innerHTML=
								"<tr><td><span class='text-default'>"+goodsrangeArr[j].desc+"</span></td>" +
								"<td><span class='text-default'>销售价:￥"+goodsrangeArr[j].price+"</span></td></tr>";
						$(".forproductsize").eq(i).append(newli)
					}
				}
			}
		});
		function deleteThisGood(id){
			if (window.confirm("是否确认要删除?")) {
				$.ajax({
					type:'delete',
					url: thisurl+"/api/malls/products/"+id,
					success:function(res){
						location.reload()
					}
				})
			}
		}
		var thisinput=$("#thisgoodsname");
		var thisul=$("#showthisgoodsname");
		thisinput.keyup(function(){
			thisul.css("display","block");
			var thetext=thisinput.val();
			thisul.empty();
			if(thetext!="") {
				for (var i = 0; i < goodstitlearr.length; i++) {
					var onetitle = goodstitlearr[i];
					var l = onetitle.toUpperCase().indexOf(thetext.toUpperCase());
					if (l > -1) {
						var li=document.createElement("li");
						var oldmatchstr = onetitle.substr(l, thetext.length);
						var pattern = eval("/" + thetext + "/gi");
						li.innerHTML= onetitle.replace(pattern, "<font color=red>" + oldmatchstr + "</font>");
						thisul.append(li)
					}
				}
			}
			$("#showthisgoodsname li").mouseover(function(){
				$(this).css("background-color","green");
				$(this).css("color","white");
			});
			$("#showthisgoodsname li").mouseout(function(){
				$(this).css("background-color","white");
				$(this).css("color","#666");
			});
			$("#showthisgoodsname li").click(function(){
				thisinput.val($(this).text());
			});

		});
		function justshowthistitle(){
			thisvalue=thisinput.val();
			if(thisvalue==""){
				$("table tr").css("display","table-row");
			}
			else{
				$("table tr").css("display","none");
				$("table tr[name='"+thisvalue+"']").css("display","table-row");
				thisul.css("display","none");
			}
		}
		function showall(){
			$("table tr").css("display","table-row");
		}

	</script>

@endsection