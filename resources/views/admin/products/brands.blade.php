@extends('layouts.admin')

@section('title')
    商品编辑
@stop

@section('dropzone_css')
    <link href="/assets/javascripts/dropzone/dropzone.min.css" rel="stylesheet">
@endsection

<style>
    .btn-sm{margin:5px 5px 0 0;float:left;}
    table td{font-size:12px}
    table input{border:1px solid #ccc}
  </style>
@section('content')
    <div class="widget wgreen">
        <div class="widget-head">
            <div class="pull-left">商品价格规格编辑</div>
            <div class="pull-right">
                <a href="/admin/products" class="btn btn-default btn-sm" href="">返回</a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="widget-content">

            <div class="padd">
                <form class="pro-form form-horizontal" action="" method="POST" enctype='multipart/form-data'>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">商品名称</label>
                        <div class="col-lg-8">
                            <input name="name" type="text" class="form-control" placeholder="填写商品名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">商品品牌</label>
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    商品品牌
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="product-size" class="table  table-hover table-bordered">
                                            <thead>
                                            <tr >
                                                <th >#</th>
                                                <th >品牌</th>
                                                <th >操作</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>

                        </div>
                    </div>


                </form>
            </div>

            <div class="widget-foot">
                <div class="col-lg-offset-2">
                    &nbsp;
                    <a href="/admin/products" class="btn btn-lg btn-default">返回</a>
                </div>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
    <script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
    <script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>


    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/assets/admin/js/changeurl.js">
    </script>
    <script>
        var thisurl=changeurl();
        var address=location.href;
        var id=address.split("/")[5];
        var title;
        var productsizedesc=[];



        $.ajax({
            type:"get",
            url :thisurl+"/api/malls/products/"+id,
            success:function(res){
                title=res.data.product.title;
                $("input[name='name']").val(title);
                productsizedesc=res.data.product.brands;
                $.ajax({
                    type:"get",
                    url: thisurl+"/api/malls/brands",
                    success:function(res){
                        var productsize=res.msg.brands;
                        for(var i=0;i<productsize.length;i++){
                            var tr=document.createElement("tr");
                            tr.className="";

                            tr.innerHTML="<tr><td class='productsizeid'>"+productsize[i].id+"</td><td>" +
                                    "<span class='selection'>"+productsize[i].title+"</span>" +
                                    "</td>" +
                                    "<td><div class='putthesebtnIn'>" +
                                    "<a onclick=javascript:createThisSize('"+productsize[i].id+"','"+id+"') class='deletebtn  btn-sm btn-primary jiacu'>添加</a></div></td></tr>";
                            $("#product-size").append(tr)
                        }
                        var thesebutton;
                        var lens=document.getElementsByClassName('productsizeid');
                        var price=document.getElementsByClassName('price');
                        for(var i=0;i<lens.length;i++){
                            for(var j=0;j<productsizedesc.length;j++){
                                if(productsizedesc[j].id==lens[i].innerHTML){

                                    var thispriceid=productsizedesc[j].id;

                                    $(".putthesebtnIn").eq(i).empty();
                                    thesebutton="<span onclick=javascript:deleteThisSize('"+thispriceid+"','"+id+"') class='btn-sm btn-danger jiacu'>删除</span>";
                                    $(".putthesebtnIn").eq(i).append(thesebutton);
                                }
                            }
                        }
                    }
                });
            }
        });
        function deleteThisSize(brandid,productid){
            $.ajax({
                type:'delete',
                url: thisurl+"/api/malls/product-brands/delete",
                data:{'product_id':productid,'brand_id':brandid},
                success:function(res){
                    console.log(res);
                    location.reload()
                }
            })
        }
        function createThisSize(brandid,productid){

            $.ajax({
                type:'post',
                url: thisurl+"/api/malls/product-brands",
                data:{'product_id':productid,'brand_id':brandid},
                success:function(res){
                    console.log(res)
                    location.reload()
                }
            })
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

        var editor = new Editor({ element: document.getElementById("introduction") });
    </script>
@endsection
