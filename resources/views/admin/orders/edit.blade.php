@extends('layouts.admin')

@section('title')
订单编辑
@stop

@section('content')
	<style>
		.thisaddress{width:60%;border:none;color:black}
		.thisaddress::-webkit-input-placeholder {
			color: red;
		}
		.thisaddress:-moz-placeholder {
			color: red;
		}

		.thisaddress:-ms-input-placeholder {
			color: red;
		}
		.thisaddress1{width:12%;border:none;color:black}
		.thisaddress1::-webkit-input-placeholder {
			color: red;
		}
		.thisaddress1:-moz-placeholder {
			color: red;
		}

		.thisaddress1:-ms-input-placeholder {
			color: red;
		}

	</style>
	<div class="row">
		<div class="order-details col-md-12">

			<div class="widget package-info">
				<div class="widget-head">
					<div class="pull-left">订单状态</div>
					<div class="widget-icons pull-right">
						<a href="javascript:;" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					</div>
					<div class="clearfix"></div>
				</div><!-- Widget title -->
				<div class="widget-content">
					<div class="padd">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-2 control-label">订单状态</label>
								<div class="col-lg-10">
									<div class="radio">
										<label>
											<input checked type="radio" name="blankRadio" id="blankRadio1" value="option1"><span id="orderstatus"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">快递选择</label>
								<div class="col-lg-10">
									<select name="blood_type" class="form-control">
										<option value="zhongtong">中通速递</option>
										<option value="ems">ems快递</option>
										<option value="shentong">申通</option>
										<option value="shunfeng">顺丰</option>
										<option value="yuantong">圆通速递</option>
										<option value="debangwuliu">德邦物流</option>
										{{--<option value="aae">全球专递</option>
										<option value="anjie">安捷快递</option>
										<option value="anxindakuaixi">安信达快递</option>
										<option value="biaojikuaidi">彪记快递</option>
										<option value="bht">bht</option>
										<option value="baifudongfang">百福东方国际物流</option>
										<option value="coe">中国东方（COE）</option>
										<option value="changyuwuliu">长宇物流</option>
										<option value="datianwuliu">大田物流</option>
										<option value="dhl">dhl</option>
										<option value="dpex">dpex</option>
										<option value="dsukuaidi">d速快递</option>
										<option value="disifang">递四方</option>
										<option value="fedex">fedex（国外）</option>
										<option value="feikangda">飞康达物流</option>
										<option value="fenghuangkuaidi">凤凰快递</option>
										<option value="feikuaida">飞快达</option>
										<option value="guotongkuaidi">国通快递</option>
										<option value="ganzhongnengda">港中能达物流</option>
										<option value="guangdongyouzhengwuliu">广东邮政物流</option>
										<option value="gongsuda">共速达</option>
										<option value="huitongkuaidi">汇通快运</option>
										<option value="hengluwuliu">恒路物流</option
										><option value="huaxialongwuliu">华夏龙物流</option>
										<option value="haihongwangsong">海红</option>
										<option value="haiwaihuanqiu">海外环球</option>
										<option value="jiayiwuliu">佳怡物流</option>
										<option value="jinguangsudikuaijian">京广速递</option>
										<option value="jixianda">急先达</option>
										<option value="jjwl">佳吉物流</option>
										<option value="jymwl">加运美物流</option>
										<option value="jindawuliu">金大物流</option>
										<option value="jialidatong">嘉里大通</option>
										<option value="jykd">晋越快递</option>
										<option value="kuaijiesudi">快捷速递</option>
										<option value="lianb">联邦快递（国内）</option>
										<option value="lianhaowuliu">联昊通物流</option>
										<option value="longbanwuliu">龙邦物流</option>
										<option value="lijisong">立即送</option>
										<option value="lejiedi">乐捷递</option>
										<option value="minghangkuaidi">民航快递</option>
										<option value="meiguokuaidi">美国快递</option>
										<option value="menduimen">门对门</option>
										<option value="ocs">OCS</option>
										<option value="peisihuoyunkuaidi">配思货运</option>
										<option value="quanchenkuaidi">全晨快递</option>
										<option value="quanfengkuaidi">全峰快递</option>
										<option value="quanjitong">全际通物流</option>
										<option value="quanritongkuaidi">全日通快递</option>
										<option value="quanyikuaidi">全一快递</option>
										<option value="rufengda">如风达</option>
										<option value="santaisudi">三态速递</option>
										<option value="shenghuiwuliu">盛辉物流</option>
										<option value="sue">速尔物流</option>
										<option value="shengfeng">盛丰物流</option>
										<option value="saiaodi">赛澳递</option>
										<option value="tiandihuayu">天地华宇</option>
										<option value="tiantian">天天快递</option>
										<option value="tnt">tnt</option>
										<option value="ups">ups</option>
										<option value="wanjiawuliu">万家物流</option>
										<option value="wenjiesudi">文捷航空速递</option>
										<option value="wuyuan">伍圆</option>
										<option value="wxwl">万象物流</option>
										<option value="xinbangwuliu">新邦物流</option>
										<option value="xinfengwuliu">信丰物流</option>
										<option value="yafengsudi">亚风速递</option>
										<option value="yibangwuliu">一邦速递</option>
										<option value="youshuwuliu">优速物流</option>
										<option value="youzhengguonei">邮政包裹挂号信</option>
										<option value="youzhengguoji">邮政国际包裹挂号信</option>
										<option value="yuanweifeng">源伟丰快递</option>
										<option value="yuanzhijiecheng">元智捷诚快递</option>
										<option value="yunda">韵达快运</option>
										<option value="yuntongkuaidi">运通快递</option>
										<option value="yuefengwuliu">越丰物流</option>
										<option value="yad">源安达</option>
										<option value="yinjiesudi">银捷速递</option>
										<option value="zhaijisong">宅急送</option>
										<option value="zhongtiekuaiyun">中铁快运</option>
										<option value="zhongyouwuliu">中邮物流</option>
										<option value="zhongxinda">忠信达</option>
										<option value="zhimakaimen">芝麻开门</option>--}}
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">物流运费</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="请填写快递运费" name="postfee" readonly>
										<div class="input-group-addon">元</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label" >快递单号</label>
								<div class="col-lg-10">
									<input name="name" type="text" class="form-control" placeholder="请填写快递单号" >
								</div>
							</div>
						</form>
					</div>
					<div class="widget-foot">
						<div class="col-lg-offset-2">
							<a class="btn btn-primary" onclick="expressdetail()">保存</a>
						</div><!-- end -->
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
									<th>编辑</th>
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


			<div>
				<a href="/admin/orders" class="btn btn-lg btn-default btn-block">返回</a>
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
		var id=address.split("/")[5];
		var user_id=address.split("?")[1].split("=")[1];
		console.log(user_id);
		var canshipped=false;
		$.ajax({
			type:"get",
			url:thisurl+"/api/malls/purchases/"+id,
			data:{"user_id":user_id,"from":"op"},
			success:function(res){
				var whoseorder=res.data.purchase;
				orderdetail.innerHTML=
						"<tbody>" +
							"<tr>" +
								"<td>订单编号</td>" +
								"<td>"+whoseorder.serial_number+"</td>" +
							"</tr><tr>" +
								"<td>创建时间</td>" +
								"<td>"+whoseorder.created_at+"</td> " +
							"</tr><tr>" +
								"<td>付款方式</td>" +
								"<td>"+whoseorder.chinese_channel+"</td>" +
							"</tr><tr>" +
								"<td>付款时间</td> " +
								"<td></td> " +
							"</tr>" +
						"</tbody>";
				allproduct=whoseorder.items;
				var totalprices=0;
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
							'<td>x'+allproduct[i].item_count+'</td>' +
							'<td><button style="margin:5px auto" class="btn btn-primary btn-sm" onclick="changeprice()">确定修改</button></td>';
					productdetail.appendChild(productdetails)

				};
                totalprices=Number(whoseorder.total_items_price);
				totalprice.innerHTML="订单总金额:<input type='text' name='thisproductprice' value='"+totalprices+"' class='h4 text-danger' />元";
				postmandetail.innerHTML=
						"<tr>" +
							"<td>收货人</td> " +
							"<td><input class='thisaddress' type='text' placeholder='请填写收货人姓名' value='"+whoseorder.address.receiver_name+"' name='receiver'></td> " +
						"</tr><tr> " +
							"<td>手机号</td>" +
							"<td><input class='thisaddress' type='text' placeholder='请填写收货人手机号' value='"+whoseorder.address.receiver_phone+"' name='digitals'></td> " +
						"</tr><tr>" +
							"<td>收货地址</td> " +
							"<td>" +
								"<input class='thisaddress1' type='text' placeholder='请填写省' name='province' value='"+whoseorder.address.province+"'><span>省/直辖市</span>" +
								"<input class='thisaddress1' type='text' placeholder='请填写市' name='city' value='"+whoseorder.address.city+"'><span>市</span>" +
								"<input class='thisaddress1' type='text' placeholder='请填写县' name='area' value='"+whoseorder.address.area+"'><span>县</span>" +
								"<input class='thisaddress1' type='text' placeholder='请填写具体地址' name='address' value='"+whoseorder.address.detail+"' style='width:35%'>" +
							"</td> " +
						"</tr><tr>" +
							"<td></td>" +
							"<td><button style='margin:5px auto' class='btn btn-primary btn-sm' onclick='changeaddress()'>确定修改</button></td></tr>";
				orderstatus.innerHTML=whoseorder.chinese_status;
				canshipped=whoseorder.paid
				$("input[name='postfee']").val(whoseorder.express_price);
				$("input[name='name']").val(whoseorder.express_number);
			}
		});

		function expressdetail(){
			if(canshipped){
				if(confirm("快递即将配送,配送后将无法修改收货地址,确定发送吗")){
					var expressnumber=$("input[name='name']").val();
					var expresscompany=$("select[name='blood_type']").val();
					//console.log(expresscompany)
					$.ajax({
						type:"put",
						url :thisurl+"/api/malls/purchases/"+id,
						data:{"express_number":expressnumber,"express_company":expresscompany,"user_id":user_id},
						success:function(res){
							console.log(res);
						}
					});
					setTimeout(function(){
						location.reload();
					},1000)
				}
			}else{
				alert("订单可能未支付，已取消或者已经配送")
			}
		}
		function changeaddress(){
			if(orderstatus.innerHTML!="已发货"){
				var province=$("input[name='province']").val();
				var city=$("input[name='city']").val();
				var area=$("input[name='area']").val();
				var detail=$("input[name='address']").val();
				var receiver=$("input[name='receiver']").val();
				var digitals=$("input[name='digitals']").val();
				$.ajax({
					type:'put',
					url:thisurl+'/api/malls/purchases/'+id+'/address',
					data:{'user_id':user_id,'province':province,'city':city,'area':area,'detail':detail,'receiver_name':receiver,'receiver_phone':digitals},
					success:function(res){
						console.log(res);
						alert("修改成功")
					}
				})
			}
			else{
				alert("订单已经配送，无法修改地址");
			}
		}
		function changeprice(){
            if(orderstatus.innerHTML!="已发货" && orderstatus.innerHTML!="待发货" ){
                var price=$("input[name='thisproductprice']").val();
                $.ajax({
                    type:'put',
                    url:thisurl+'/api/malls/purchases/'+id+'/totalprice',
                    data:{'total_items_price':price,"user_id":user_id},
                    success:function(res){
                        console.log(res);
                        alert('修改成功')
                    }
                })
            }
            else{
                alert("订单已经配送或者已支付，无法修改价格");

            }
		}
	</script>
@endsection
