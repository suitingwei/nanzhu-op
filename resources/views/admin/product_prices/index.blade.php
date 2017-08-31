@extends('layouts.admin')

@section('title')
商品信息
@stop

@section('content')
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
		</div>
		<hr>

		<div class="table-responsive">
			<table class="pro table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="col-lg-1">#</th>
						<th class="col-md-1">商品图片</th>
						<th class="col-md-3">商品名称</th>
						<th class="col-md-3">商品规格</th>
						<th class="col-md-1">商品状态</th>
						<th class="col-md-1">创建时间</th>
						<th class="col-md-1">排序</th>
						<th class="col-md-1">操作</th>
					</tr>
				</thead>
				<tbody>

					<tr>
						<td>
							001
						</td>
						<td>
							<a href="/admin/products/show">
								<div class="pro-img"><img class="img-responsive" src="/assets/admin/img/wine.jpg" /></div>
							</a>
						</td>
						<td>
							<a href="/admin/products/show">爆款单支抽拉红酒盒包装葡萄酒</a>
						</td>
						<td>
							<ul class="pro-option list-unstyled">
								<li>
									<span class="text-default">
										智象美露 双支木盒
									</span>
									{{--<span class="text-default">--}}
										{{--采购价:￥199.00--}}
									{{--</span>--}}
									<span class="text-default">
										销售价:￥399.00
									</span>
								</li>
								<li>
									<span class="text-default">
										智象美露 双支木盒
									</span>
									{{--<span class="text-default">--}}
										{{--采购价:￥199.00--}}
									{{--</span>--}}
									<span class="text-default">
										销售价:￥399.00
									</span>
								</li>
								<li>
									<span class="text-default">
										智象美露 双支木盒
									</span>
									{{--<span class="text-default">--}}
										{{--采购价:￥199.00--}}
									{{--</span>--}}
									<span class="text-default">
										销售价:￥399.00
									</span>
								</li>
							</ul>
						</td>
						<td>
							<p><span class="label label-success">已上架</span></p>
							<p>2016-12-15<br>08:01</p>
						</td>
						<td>
							2016-12-14<br>13:25
						</td>
						<td>
							1
						</td>
						<td>
							<a class="btn btn-sm btn-warning" href="/admin/products/1/edit">编辑</a>
						</td>
					</tr>

					<tr>
						<td>
							002
						</td>
						<td>
							<a href="/admin/products/show">
								<div class="pro-img"><img class="img-responsive" src="//img12.360buyimg.com/n1/jfs/t3658/24/468999806/399166/9a965bf0/5809f593N008c7a1b.jpg" /></div>
							</a>
						</td>
						<td>
							<a href="/admin/products/show">保湿红酒滋养面膜补水清洁净肤保湿</a>
						</td>
						<td>
							<ul class="pro-option list-unstyled">
								<li>
									<span class="text-default">
										10片装/盒
									</span>
									<span class="text-default">
										销售价:￥399.00
									</span>
								</li>
								<li>
									<span class="text-default">
										20片装/盒
									</span>
									<span class="text-default">
										销售价:￥399.00
									</span>
								</li>
								<li>
									<span class="text-default">
										30片装/盒
									</span>
									<span class="text-default">
										销售价:￥399.00
									</span>
								</li>
							</ul>
						</td>
						<td>
							<span class="label label-danger">未上架</span>
						</td>
						<td>
							2016-12-14<br>13:25
						</td>
						<td>
							1
						</td>
						<td>
							<a class="btn btn-sm btn-warning" href="/admin/products/1/edit">编辑</a>
						</td>
					</tr>

					<tr>
						<td>
							003
						</td>
						<td>
							<a href="/admin/products/show">
								<div class="pro-img"><img class="img-responsive" src="//img13.360buyimg.com/n1/jfs/t775/200/838693125/89443/226e798e/54fe67b0N0e65f27d.jpg" /></div>
							</a>
						</td>
						<td>
							<a href="/admin/products/show">丽丽贝尔（LilyBell）柔软化妆棉</a>
						</td>
						<td>
							<ul class="pro-option list-unstyled">
								<li>
									<span class="text-default">
										50枚装/盒
									</span>
									<span class="text-default">
										销售价:￥99.00
									</span>
								</li>
								<li>
									<span class="text-default">
										100枚装/盒
									</span>
									<span class="text-default">
										销售价:￥99.00
									</span>
								</li>
								<li>
									<span class="text-default">
										200枚装/盒
									</span>
									<span class="text-default">
										销售价:￥99.00
									</span>
								</li>
							</ul>
						</td>
						<td>
							<span class="label label-default">已下架</span>
						</td>
						<td>
							2016-12-14<br>13:25
						</td>
						<td>
							1
						</td>
						<td>
							<a class="btn btn-sm btn-warning" href="/admin/products/1/edit">编辑</a>
						</td>
					</tr>

				</tbody>
			</table>
		</div>

		<div class="widget-foot">
		  <div class="clearfix"></div>
		</div>
	</div>

</div>
@endsection