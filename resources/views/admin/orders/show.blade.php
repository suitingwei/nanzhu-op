@extends('layouts.admin')

@section('title')
订单详情
@stop

@section('content')
	<div class="row">
		<div class="order-details col-md-12">

			<div class="order-status bg-warning">
				<h4 id="thisorderstatus"></h4>
			</div>

			<div id="packageInfo" class="widget package-info">
				<div class="widget-head">
					<div class="pull-left">物流信息</div>
					<div class="widget-icons pull-right">
						<a href="javascript:;" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					</div>
					<div class="clearfix"></div>
				</div><!-- Widget title -->
				<div class="widget-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="logisticsdetail">

						</table>
					</div>
					<div class="widget-foot">
					</div>
				</div>
			</div><!-- Widget content -->

			<div class="widget">
				<div class="widget-head">
					<div class="pull-left">订单信息</div>
					<div class="widget-icons pull-right">
						<a href="javascript:;" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					</div>
					<div class="clearfix"></div>
				</div><!-- Widget title -->
				<div class="widget-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="orderdetail">

						</table>
					</div>
					<div class="widget-foot">
					</div>
				</div>
			</div><!-- Widget content -->

			<div class="widget">
				<div class="widget-head">
					<div class="pull-left">商品信息</div>
					<div class="widget-icons pull-right">
						<a href="javascript:;" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					</div>
					<div class="clearfix"></div>
				</div><!-- Widget title -->
				<div class="widget-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<tbody id="productdetail">
								<tr>
									<th>商品</th>
									<th>商品编号</th>
									<th>价格</th>
									<th>数量</th>
								</tr>

							</tbody>
						</table>
					</div>
					<div class="widget-foot">
						<span class="pull-right" id="totalprice">
						</span>
						<div class="clearfix"></div>
					</div>
				</div>
			</div><!-- Widget content -->

			<div id="userInfo" class="widget">
				<div class="widget-head">
					<div class="pull-left">收货人信息</div>
					<div class="widget-icons pull-right">
						<a href="javascript:;" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					</div>
					<div class="clearfix"></div>
				</div><!-- Widget title -->
				<div class="widget-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<tbody id="postmandetail">

							</tbody>
						</table>
					</div>
					<div class="widget-foot">
					</div>
				</div>
			</div><!-- Widget content -->

			<div class="col-lg-offset-4">
				<a onclick="goedit()" class="btn btn-lg btn-primary">编辑</a>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:history.go(-1)" class="btn btn-lg btn-default">返回</a>
			</div><!-- end -->

		</div>
	</div>
@endsection

@section('javascript')
	<script>
		/* Widget minimize */
		$('.wminimize').click(function(e){
			e.preventDefault();
			var $wcontent = $(this).parent().parent().next('.widget-content');
			if($wcontent.is(':visible'))
			{
				$(this).children('i').removeClass('fa fa-chevron-up');
				$(this).children('i').addClass('fa fa-chevron-down');
			}
			else
			{
				$(this).children('i').removeClass('fa fa-chevron-down');
				$(this).children('i').addClass('fa fa-chevron-up');
			}
			$wcontent.toggle(500);
		});


	</script>
	<script src="/assets/admin/js/jquery.js"></script>
	<script src="/assets/admin/js/changeurl.js">
	</script>
	<script>
		var thisurl=changeurl();
		var address=location.href;
		var arr=address.split("?")[1].split("&")
		var user_id,id;
		for(var i=0;i<arr.length;i++){
			if(arr[i].split("=")[0]=="user"){
				user_id=arr[i].split("=")[1]
			}
			if(arr[i].split("=")[0]=="id"){
				id=arr[i].split("=")[1]
			}
		}
		function goedit(){
			location.href="/admin/orders/"+id+"/edit?user="+user_id;
		}
		$.ajax({
			type:"get",
			url:thisurl+"/api/malls/purchases/"+id,
			data:{"user_id":user_id,"from":"op"},
			success:function(res){
				var whoseorder=res.data.purchase;
				logisticsdetail.innerHTML=
						"<tbody> " +
							"<tr> " +
								"<td>发货方式</td> <td>普通快递</td> " +
							"</tr>" +
							" <tr>" +
								" <td>物流公司</td>" +
								" <td>"+whoseorder.express_company+"</td>" +
							" </tr> " +
							"<tr>" +
								" <td>物流运费</td> " +
								"<td>"+whoseorder.express_price+"</td>" +
							" </tr> " +
							"<tr>" +
								" <td>运单号码</td>" +
								" <td><a href=''>"+whoseorder.express_number+"</a></td>" +
							"</tr>" +
						"</tbody>";
				orderdetail.innerHTML=
						"<tbody> " +
							"<tr>" +
								"<td>订单编号</td>" +
								"<td>"+whoseorder.serial_number+"</td>" +
							"</tr>" +
							"<tr>" +
								"<td>创建时间</td> " +
								"<td>"+whoseorder.created_at+"</td> " +
							"</tr> " +
							"<tr>" +
								"<td>付款方式</td>" +
								"<td>"+whoseorder.chinese_channel+"</td> " +
							"</tr> " +
							"<tr>" +
								"<td>付款时间</td> " +
								"<td></td> " +
							"</tr> " +
						"</tbody>"
				var allproduct=whoseorder.items;

				for(var i=0;i<allproduct.length;i++){
					var productdetails=document.createElement("tr");
					productdetails.innerHTML=
							'<td>' +
							'<div class="media">' +
							'<a class="pull-left" href="/admin/products/show">' +
							'<div class="pro-img">' +
							'<img class="img-responsive" src="'+allproduct[i].item_cover+'" />' +
							'</div> ' +
							'</a>' +
							'<div class="media-bd"> ' +
							'<h6 class="media-heading">' +
							'<a href="/admin/products/show">'+allproduct[i].item_title+'</a>' +
							'</h6> ' +
							'<p class="text-muted">'+allproduct[i].item_size+'</p> ' +
							'</div> ' +
							'</div> ' +
							'</td> ' +
							'<td>'+allproduct[i].item_id+'</td> ' +
							'<td>￥'+allproduct[i].item_price+'</td> ' +
							'<td>x'+allproduct[i].item_count+'</td>';
					productdetail.appendChild(productdetails)

				}
				totalprice.innerHTML="订单总金额:<strong class='h4 text-danger'>"+whoseorder.total_items_price+"</strong> 元";
				postmandetail.innerHTML=
						"<tr>" +
						"<td>收货人</td> " +
						"<td>"+whoseorder.address.receiver_name+"</td> " +
						"</tr><tr> " +
						"<td>手机号</td>" +
						" <td>"+whoseorder.address.receiver_phone+"</td> " +
						"</tr><tr>" +
						" <td>收货地址</td> " +
						"<td>"+whoseorder.address.province+whoseorder.address.city+whoseorder.address.area+whoseorder.address.detail+"</td> " +
						"</tr>";
				thisorderstatus.innerHTML=
						"当前订单状态："+whoseorder.chinese_status;

			}
		});

	</script>
@endsection