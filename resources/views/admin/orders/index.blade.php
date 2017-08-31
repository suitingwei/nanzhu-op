@extends('layouts.admin')

@section('title')
订单信息
@stop

@section('content')
<style>
	.togatherrow{text-align:center}
	.posi{margin:5px;font-weight: 900;font-size:14px}
	.page{list-style:none;overflow: hidden}
	.page li{float:left;margin:5px 3px 0 3px}
	.page li a{color:black}
	.label{font-size: 100%}
	 table th{font-size: 14px}

</style>

<div class="widget">
	<div class="widget-head">
	  订单列表
	</div>
	<div class="max-table widget-content">
		<div class="padd form-option">
			  <div class="form-group" style="position: relative">
			    <label for="">商品名称</label>
			    <input type="text" name="name" style="width:20%;display:inline-block" class="form-control" placeholder="请输入商品名称" id="search">
				<ul style="position: absolute;background: white;left:51px;width:200px;list-style: none;padding-left:10px" id="searchresult"></ul>

				<span onclick="searchorder()" class="btn btn-primary btn-sm" >搜索</span>
				<span onclick="showallorder()" class="btn btn-info btn-sm" >显示全部</span>
			  </div>
			<span onclick="searchstatus('all','1')" class="btn btn-primary posi ">全部</span>
			<span onclick="searchstatus('wait_ship',1)" class="btn btn-warning posi">待发货</span>
			<span onclick="searchstatus('canceled',1)" class="btn btn-danger posi">已取消</span>
			<span onclick="searchstatus('wait_confirm',1)" class="btn btn-success posi">已配送</span>
			<span onclick="searchstatus('wait_pay',1)" class="btn btn-info posi">待支付</span>
			<span onclick="searchstatus('deleted',1)" class="btn btn-danger posi">已删除</span>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				商品订单
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table  id="ordershow" class="table  table-hover table-bordered table-striped">
						<thead>
						<tr class="info">
							<th style="width:50%">订单商品</th>
							<th style="width:10%">收货人</th>
							<th style="width:10%">订单金额</th>
							<th style="width:10%">全部状态</th>
							<th style="width:10%">操作</th>
						</tr>
						</thead>
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
	<input type="hidden" id="pagenumnow" value="1">
	<input type="hidden" id="thispagestatus" value="all">
	<ul class="page pagination" id="page">
		<li id="shouye" >
			<a href='javascript:pagenum(1);'>首 页</a>
		</li>
		<li id="shangyiye"  >
			<a href='javascript:goback();'>上一页</a>
		</li>
		<li class="active"><a id="one" href="javascript:pagenum(1);" >1</a></li>
		<li><a id="two" href="javascript:pagenum(2);" >2</a></li>
		<li><a id="three" href="javascript:pagenum(3);" >3</a></li>
		<li class="more"><a id="five">...</a></li>
		<li><a id="last" href="javascript:pagenum(0);"></a></li>
		<li >
			<a href='javascript:gonext();'>下一页</a>
		</li>
		<li id="weiye" >
			<a  onclick="pagenum(0);">尾 页</a>
		</li>
		<li >
			<span >共<span id="totalpagenum"></span>页 到第<input type="text" id="input_number" style="width:15%;color:black" />页
				<input name="" value="确定" type="button" onclick="jumpToPage(jQuery('#input_number').val());" style="color:black"/>
			</span>
		</li>
	</ul>
</div>
<script src="/assets/admin/js/jquery.js"></script>
<script src="/assets/admin/js/changeurl.js"></script>
<script>
	var thisurl=changeurl();

	//数组去重
	Array.prototype.indexOf = function(val) {
		for (var i = 0; i < this.length; i++) {
			if (this[i] == val) return i;
		}
		return -1;
	};
	Array.prototype.removesame = function(val) {
		var index = this.indexOf(val);
		if (index > -1) {
			this.splice(index, 1);
		}
	};
	//最开始 先调用一遍(调取订单数据和分页)
	window.onload=function(){
		searchstatus('all',1);
		originalpading();
	};
	//暂时没用 存储所有订单号 和商品名称
	var allordername=[];
	//点击状态按钮切换
	function searchstatus(thisstatus,page){
		$("#thispagestatus").val(thisstatus);
		$("#pagenumnow").val(page);
		$.ajax({
			type:"get",
			url: thisurl+"/api/malls/purchases",
			data:{"user_id":"","page":page,"status":thisstatus,"from":"op"},
			success:function(res){
				ajaxsuccess(res);
			}
		});

		activethispage(page);
	}
	//成功调取ajax后
	function ajaxsuccess(res){
		$(".all").remove();
		var whoseorder=res.data.purchases;
		for(var i=0;i<whoseorder.length;i++) {
			allordername.push(whoseorder[i].serial_number);
			var newbody = document.createElement("tbody");
			newbody.className="all";
			//开头的 tr
			showallorderth(whoseorder,newbody,i);
			//订单的展示，itemnum是订单中商品的个数
			for(var j=0;j<whoseorder[i].items.length;j++) {
				var contentfororder=document.createElement("tr");
				//td订单商品
				showallorderdetail(whoseorder,contentfororder,i,j);
				//td收货人
				showallorderreceiver(whoseorder,contentfororder,i);
				//td订单金额
				showallordermoney(whoseorder,contentfororder,i);
				//td全部状态
				showallorderstatus(whoseorder,contentfororder,i);
				//td操作
				showallorderedit(whoseorder,contentfororder,i);
				newbody.appendChild(contentfororder);
			}
		}

	}
	//开头的 tr
	function showallorderth(whoseorder,newbody,i){
		newbody.innerHTML =
				"<tr name='thistrhead'>" +
				"<th colspan='9'>订单号<a href=''>"+whoseorder[i].serial_number+"</a> " +
				"更新时间:<span class='text-muted'>"+whoseorder[i].updated_at+"</span>" +
				"</th> </tr>";
		ordershow.appendChild(newbody);
	}
	//td订单商品
	function showallorderdetail(whoseorder,contentfororder,i,j){
		var thisiditem=whoseorder[i].items;
		var orderdetail=document.createElement("td");
		allordername.removesame(thisiditem[j].item_title);
		allordername.push(thisiditem[j].item_title);

		contentfororder.setAttribute('name',thisiditem[j].item_title);
		contentfororder.setAttribute('ordernum',whoseorder[i].serial_number);
		if(j==0){
			orderdetail.innerHTML =
					"<td style='width:60%'><div class='media pull-left' style='width:95%'>" +
					"<div class='pull-left' style='width:20%' >" +
					"<div class='pro-img'><img class='img-responsive' src='" + thisiditem[j].item_cover + "' /></div> </div> " +
					"<div class='pull-left' style='width:80%'> " +
					"<h6 class='media-heading'><a style='white-space: normal' href='/admin/orders/show?user=" + whoseorder[i].user_id + "&id=" + whoseorder[i].id + "'>" + thisiditem[j].item_title + "</a></h6> " +
					"<p class='text-muted'>规格: " + thisiditem[j].item_size + "</p>" +
					"<p class='text-muted'>备注: "+whoseorder[i].note+"</p> </div> </div>" +
					"<div class='pro-num pull-left' style='width: 5%;line-height:80px'> x" + thisiditem[j].item_count + "</div> " +

					"</td>";
			contentfororder.appendChild(orderdetail)
		}
		else{
			orderdetail.innerHTML =
					"<td colspan='5'><div class='media'>" +
					"<a class='pull-left' >" +
					"<div class='pro-img'><img class='img-responsive' src='" + thisiditem[j].item_cover + "' /></div> </a> " +
					"<div class='pro-num pull-right'> <span class='text-warning'>x" + thisiditem[j].item_count + "</span> </div> " +
					"<div class='media-bd'> " +
					"<h6 class='media-heading'><a href='/admin/orders/show?user=" + whoseorder[i].user_id + "&id=" + whoseorder[i].id + "'>" + thisiditem[j].item_title + "</a></h6> " +
					"<p class='text-muted'>" + thisiditem[j].item_size + "</p> </div> </div>" +
					"</td>" +
					"<td><p><strong class='text-danger'>￥" + whoseorder[i].total_items_price + "</strong></p> " +
					"<p><span class='label label-info'>" + whoseorder[i].chinese_channel + "</span></p></td>";
			contentfororder.appendChild(orderdetail)
		}
	}
	//td收货人
	function showallorderreceiver(whoseorder,contentfororder,i){
		var itemnum=whoseorder[i].items.length;
		var receiver=document.createElement("td");
		receiver.innerHTML =
				"<td class='togatherrow'><p><a href='/admin/orders/show#userInfo'>" + whoseorder[i].address.receiver_name + "</a></p>" +
				 "<p>" + whoseorder[i].address.receiver_phone + "</p></td>";
		contentfororder.appendChild(receiver)
		$(".togatherrow").attr("rowspan",itemnum+1);
	}
	//td订单金额
	function showallordermoney(whoseorder,contentfororder,i){
		var itemnum=whoseorder[i].items.length;
		var money=document.createElement("td");
		money.innerHTML =
				"<td><p><strong class='text-danger'>￥" + whoseorder[i].total_items_price + "</strong></p> " +
				"<p><span class='label label-info'>" + whoseorder[i].chinese_channel + "</span></p></td>";
		contentfororder.appendChild(money);
		$(".togatherrow").attr("rowspan",itemnum+1);
	}
	//td全部状态
	function showallorderstatus(whoseorder,contentfororder,i){
		var logistics="";
		if(whoseorder[i].shipped==true && whoseorder[i].paid==true  ){
			logistics="<a href='"+whoseorder[i].h5_express_url+"' target='_blank'>查看物流</a>";
		}
		var itemnum=whoseorder[i].items.length;
		var status=document.createElement("td");
		status.innerHTML =
				"<td class='togatherrow'><p><span class='label label-warning'>" + whoseorder[i].chinese_status + "</span></p>" +
				"<p><a href='/admin/orders/show?user=" + whoseorder[i].user_id + "&id=" + whoseorder[i].id + "'>订单详情</a></p>" +
				"<p>"+logistics+"</p></td>";
		contentfororder.appendChild(status)
		$(".togatherrow").attr("rowspan",itemnum+1);
	}
	//td操作
	function showallorderedit(whoseorder,contentfororder,i){

		var itemnum=whoseorder[i].items.length;
		var edit=document.createElement("td");
		edit.innerHTML =
				"<td class='togatherrow'><a class='btn btn-default' href='/admin/orders/" + whoseorder[i].id + "/edit?user=" + whoseorder[i].user_id + "'>编辑</a></td>";
		contentfororder.appendChild(edit)
		$(".togatherrow").attr("rowspan",itemnum+1);
	}
	//分页
	var pading=10;
	//每次 切换状态 页数也发生相应变化；也就是 初始时候的页数
	function originalpading() {
		$("#totalpagenum").text(pading);
		if (pading == 0) {
			$('#one').parent().hide();
			$('#two').parent().hide();
			$('#three').parent().hide();
			$('#five').parent().hide();
			$('#last').parent().hide();
		}
		else if (pading == 1) {
			$('#shouye').hide();
			$('#weiye').hide();
			$('#one').parent().hide();
			$('#two').parent().hide();
			$('#three').parent().hide();
			$('#five').parent().hide();
			$('#last').parent().hide();
		}
		else if (pading == 2) {
			$('#one').parent().show();
			$('#two').parent().show();
			$('#three').parent().hide();
			$('#five').parent().hide();
			$('#last').parent().hide();
		}
		else if (pading == 3) {
			$('#one').parent().show();
			$('#two').parent().show();
			$('#three').parent().show();
			$('#five').parent().hide();
			$('#last').parent().hide();
		}
		else if (pading == 4) {
			$('#one').parent().show();
			$('#two').parent().show();
			$('#three').parent().show();
			$('#five').parent().hide();
			$('#last').parent().show();
			$('#last').text(pading);
		}
		else {
			$('#one').parent().show();
			$('#two').parent().show();
			$('#three').parent().show();
			$('#five').parent().show();
			$('#last').parent().show();
			$('#last').text(pading);
		}
	}
	//点击页数时,页数发生改变
	function changepageindex(nowpage){
		if(nowpage<5 && pading>=5){
			$('#one').text(1);
			$('#one').attr('href','javascript:pagenum(1)');
			$('#two').text(2);
			$('#two').attr('href','javascript:pagenum(2)');
			$('#three').text(3);
			$('#three').attr('href','javascript:pagenum(3)');
			$('#five').text(4);
			$('#five').attr('href','javascript:pagenum(4)');
			$('#last').text(5);
			$('#last').attr('href','javascript:pagenum(5)');
			$('#five').parent().show();
			$('#last').parent().show();
		}
		else if(nowpage>=5){
			//alert("已经不是第五页了");
			//设置中间的为当前页
			$('#one').text(Number(nowpage)-2);
			$('#one').attr('href','javascript:pagenum("'+(Number(nowpage)-2)+'");');
			$('#two').text(Number(nowpage)-1);
			$('#two').attr('href','javascript:pagenum("'+(Number(nowpage)-1)+'");');
			$('#three').text(nowpage);
			$('#three').attr('href','javascript:pagenum("'+(nowpage)+'");');
			$('#five').parent().show();
			$('#last').parent().show();
			//判断下一页是否超过了总页数
			if(Number(nowpage)+1>pading){
				$('#five').parent().hide();
				$('#last').parent().hide();
			}else{
				$('#five').parent().show();
				$('#five').text(Number(nowpage)+1);
				$('#five').attr('href','javascript:pagenum("'+(Number(nowpage)+1)+'");');
			}
			//判断下一页的第二页是否超过了总页数
			if(Number(nowpage)+2>pading){
				$('#last').parent().hide();
			}else{
				$('#last').parent().show();
				$('#last').text(Number(nowpage)+2);
				$('#last').attr('href','javascript:pagenum("'+(Number(nowpage)+2)+'");');
			}
		}
	}
	//点击页数
	function pagenum(pagenow){

		if(pagenow==0){
			pagenow=pading
		}
		$("#pagenumnow").val(pagenow); //将当前页数存到他妈的Input 隐藏框里
		//获取当前状态
		var statusnow=$("#thispagestatus").val()
		searchstatus(statusnow,pagenow);
		changepageindex(pagenow);
		activethispage(pagenow)
	}
	//点击上一页
	function goback(){
		var temppage=$("#pagenumnow").val();

		if(temppage<=1){
			temppage=1
		}
		else{
			temppage=temppage-1;
		}
		var statusnow=$("#thispagestatus").val();
		$("#pagenumnow").val(temppage);
		searchstatus(statusnow,temppage);
		changepageindex(temppage);
		activethispage(temppage);
	}
	//点击下一页
	function gonext(){
		var temppage=$("#pagenumnow").val();
		if(temppage>=pading){
			temppage=pading
		}
		else{
			temppage=Number(temppage)+1;
		}
		var statusnow=$("#thispagestatus").val()
		$("#pagenumnow").val(temppage);
		searchstatus(statusnow,temppage);
		changepageindex(temppage);
		activethispage(temppage)
	}
	//输入页数进行跳转
	function jumpToPage(pagenum){
		var statusnow=$("#thispagestatus").val();
		searchstatus(statusnow,pagenum);
		changepageindex(pagenum);
		activethispage(pagenum);
		$("#pagenumnow").val(pagenum);
	}
	//当前页数高亮
	function activethispage(pagenum){
		$("#page li").removeClass();
		$("#page li a").each(function(){
			if($(this).text()==pagenum){
				$(this).parent().addClass('active')
			}
		})

	}
	//点击搜索时显示对应商品
	function searchorder(){
		console.log(allordername)
		thisvalue=$("#search").val();
		if(thisvalue==""){
			$("table tr").css("display","table-row");
		}
		else{
			$("table tr").css("display","none");
			$("table tr[name='"+thisvalue+"']").css("display","table-row");
			$("table tr[ordernum='"+thisvalue+"']").css("display","table-row");
			$("#searchresult").css("display","none");
			$("table thead tr").css("display","table-row");
		}
	}
	//输入时进行将对应的商品名称进行显示
	search.onkeyup=function(){
		$("#searchresult").css("display","block");
		var content=$("#search").val();
		$("#searchresult").empty();
		if(content!="") {
			for (var i = 0; i < allordername.length; i++) {
				var l = allordername[i].toUpperCase().indexOf(content.toUpperCase());
				if(l>-1){
					var li = document.createElement("li");
					var matched=allordername[i].substr(l,content.length);
					var pattern = eval("/" + content + "/gi");
					li.innerHTML=allordername[i].replace(pattern,"<font style='color:red'>"+matched+"</font>");
					searchresult.appendChild(li)
				}
			}
			$("#searchresult li").mouseover(function(){
				$(this).css("background-color","green");
				$(this).css("color","white");
			});
			$("#searchresult li").mouseout(function(){
				$(this).css("background-color","white");
				$(this).css("color","#666");
			});
			$("#searchresult li").click(function(){
				$("#search").val($(this).text());
			});
		}

	}
	//显示所有订单
	function showallorder(){
		$("table tr").css("display","table-row");
	}

</script>
@endsection