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
                        <label class="col-lg-2 control-label">商品规格</label>
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    商品规格
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="product-size" class="table  table-hover table-bordered">
                                            <thead>
                                            <tr >
                                                <th >#</th>
                                                <th >规格</th>
                                                <th >销售价</th>
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
                productsizedesc=res.data.product.size_prices;
                console.log(productsizedesc)
                $.ajax({
                    type:"get",
                    url: thisurl+"/api/malls/product-sizes",
                    success:function(res){
                        var productsize=res.data.produce_sizes;
                        for(var i=0;i<productsize.length;i++){
                            var tr=document.createElement("tr");
                            tr.className="";
                            var p=i+1
                            tr.innerHTML="<tr><td>"+p+"</td><td>" +
                                         "<span class='selection'>"+productsize[i].desc+"</span>" +
                                         "<input type='hidden' class='productsizeid' value='"+productsize[i].id+"'/ ></td>" +
                                         "<td>" +
                                         "<input type='form-control' type='text' placeholder='销售价' class='price'/></td>" +
                                         "<td><div class='putthesebtnIn'>" +
                                         "<a onclick=javascript:createThisSize('"+productsize[i].id+"','"+id+"','"+i+"') class='deletebtn  btn-sm btn-primary jiacu'>添加</a></div></td></tr>";
                            $("#product-size").append(tr)
                        }
                        var thesebutton;
                        var lens=document.getElementsByClassName('selection');
                        var price=document.getElementsByClassName('price');
                        for(var i=0;i<lens.length;i++){
                            for(var j=0;j<productsizedesc.length;j++){
                                if(productsizedesc[j].desc==lens[i].innerHTML){
                                    price[i].value=productsizedesc[j].price;
                                    var thispriceid=productsizedesc[j].product_price_id;
                                    $(".putthesebtnIn").eq(i).empty()
                                    thesebutton="<span onclick=javascript:deleteThisSize('"+thispriceid+"') class='btn-sm btn-danger jiacu'>删除</span>&nbsp&nbsp&nbsp<span onclick=javascript:updateThisSize('"+thispriceid+"','"+i+"') class='btn-sm btn-info jiacu'>更新</span>"
                                    $(".putthesebtnIn").eq(i).append(thesebutton);
                                }
                            }
                        }
                    }
                });
            }
        });
        function deleteThisSize(id){
            $.ajax({
                type:'delete',
                url: thisurl+"/api/malls/product-prices/"+id,
                success:function(res){
                    console.log(res);
                    location.reload()
                }
            })
        }
        function createThisSize(sizeid,productid,index){
            var price=$(".price").eq(index).val();
            $(".deletebtn").eq(index).remove();

            console.log($(".deletebtn").eq(index));
            $.ajax({
                type:'post',
                url: thisurl+"/api/malls/product-prices",
                data:{'product_id':productid,'product_size_id':sizeid,'price':price},
                success:function(res){
                    console.log(res)
                    location.reload()
                }
            })
        }
        function updateThisSize(id,index){
            var price=$(".price").eq(index).val();
            $.ajax({
                type:'put',
                url: thisurl+"/api/malls/product-prices/"+id,
                data:{'price':price},
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

@section('dropzone_js')
    <script src="/assets/javascripts/dropzone/dropzone.min.js"></script>
    <script>
        $("#dropzPic").dropzone({
            url: "/upload",
            maxFiles: 9,
            maxFilesize: 5,
            acceptedFiles: ".jpg,.png",
            addRemoveLinks: true,
            init: function() {
                this.on("addedfile", function(file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn-tgddel btn btn-danger btn-sm btn-block' data-dz-remove>删除</a>");

                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });
                this.on("processing",function (file) {
                    $(".btn-submit").attr("disabled","true")
                });
                this.on('success',function(file,response){

                    var newImgInput = "<input type=hidden name='img_url[]' value="+response.data.uploaded_file_url+">";

                    $('form').append(newImgInput);
                    $(".btn-submit").removeAttr("disabled")
                });
            }
        });
    </script>
@endsection