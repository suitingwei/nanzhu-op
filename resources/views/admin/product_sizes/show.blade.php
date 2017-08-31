@extends('layouts.admin')

@section('title')
商品详情
@stop

@section('content')
	<div class="widget wgreen">

		<div class="widget-head">
			<div class="pull-left">商品详情</div>
			<div class="pull-right">
				<a href="javascript:history.go(-1)" class="btn btn-default btn-sm" href="">返回</a>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="widget-content">
			<br><br>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-2 control-label">商品名称</label>
					<div class="col-lg-5">
						<label class="control-label">
							爆款单支抽拉红酒盒包装葡萄酒
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">创建时间</label>
					<div class="col-lg-5">
						<label class="control-label">
							2016-12-15 08:01
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">商品图片</label>
					<div class="col-lg-5">
						<div class="control-label">
							<img class="img-responsive" src="/assets/admin/img/wine.jpg" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">商品规格</label>
					<div class="col-lg-5">
						<br>
						<ul class="pro-option list-unstyled">
							<li>
								<span class="text-default">
									智象美露 双支木盒
								</span>
								&nbsp;&nbsp;
								<span class="text-default">
									销售价:￥399.00
								</span>
							</li>
							<li>
								<span class="text-default">
									智象美露 双支木盒
								</span>
								&nbsp;&nbsp;
								<span class="text-default">
									销售价:￥399.00
								</span>
							</li>
							<li>
								<span class="text-default">
									智象美露 双支木盒
								</span>
								&nbsp;&nbsp;
								<span class="text-default">
									销售价:￥399.00
								</span>
							</li>
						</ul>
					</div>
				</div>

				<div class="form-group" >
					<label class="col-lg-2 control-label">商品状态</label>
					<div class="col-lg-5">
						<label class="control-label">
							<span class="label label-success">已上架</span> 2016-12-15 08:01
							<span class="label label-danger">未上架</span>
							<span class="label label-default">已下架</span>
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">排序</label>
					<div class="col-lg-5">
						<label class="control-label">
							1
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">商品介绍</label>
					<div class="col-lg-10">
						<div class="details-pro">
							<p>爆款单支抽拉红酒盒包装葡萄酒</p>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">商品图片</label>
					<div class="col-lg-10">
						<div class="details-pro">
							<p><img class="img-responsive" src="https://img10.360buyimg.com/imgzone/jfs/t3505/2/1622764925/320925/5aeb58f7/582d54c0Nfd74a028.jpg" alt=""></p>
						</div>
					</div>
				</div>

				<br><br>
				<div class="widget-foot">
					<div class="col-lg-offset-2">
						<a href="/admin/products/1/edit" class="btn btn-lg btn-success">编辑</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:history.go(-1)" class="btn btn-lg btn-default">返回</a>
					</div>
				</div>
			</div>
		</div>

	</div><!-- end -->
@endsection