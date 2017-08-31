@extends('layouts.admin')

@section('title')
添加商品
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
			<table >
				<tr>
					<td>商品规格</td><td><input type="text" id="description" placeholder="例如:50ml/瓶或30个/包"/></td>
				</tr>
				<tr>
					<td>排序值</td><td><input type="text" id="sort" placeholder="只能数字，越大越靠前" /></td>
				</tr>
				<tr><td></td><td><button onclick="create()" class='btn-primary'>创 建</button></td></tr>
			</table>


		</div>
		<div class="widget-foot">

		</div>

	</div>
</div><!-- end -->

<script src="/assets/admin/js/jquery.js"></script>
<script src="/assets/admin/js/changeurl.js">
</script>
<script>
	var thisurl=changeurl();
	function create(){
		var reg=/^\d+$/;

		if($("#description").val()=="" ||  reg.test($("#sort").val())==false){
			alert("description不能为空并且，sort只能为数字")
		}
		else{
			var newdescription=$("#description").val();
			var newsort=$("#sort").val();

			$.ajax({
				type:"post",
				url: thisurl+"/api/malls/product-sizes",
				data:{"desc":newdescription,"sort":newsort},
				success:function(res){
					console.log(res)
				}
			});
			location.href="/admin/product-sizes"
		}

	}
</script>
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

@endsection