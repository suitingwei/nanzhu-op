@extends('layouts.admin')

@section('title')
    编辑{{$type}}
@stop
@section('dropzone_css')
    <link href="/assets/javascripts/dropzone/dropzone.min.css" rel="stylesheet">
@endsection
@section('content')
    <style>
        .newInput {
            margin-top:10px;
            font-size:14px;
            line-height:16px;
        }
    </style>
    <div class="widget wgreen">
        <div class="widget-head">
            编辑
        </div>

        <div class="widget-content">
            <div class="padd">

                <form class="form-horizontal" action="/admin/basements/{{$type}}/{{$basement->id}}" method="POST"
                      enctype='multipart/form-data' >
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input type="text" id='title' name="title" value="{{$basement->title}}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">logo</label>
                        <div class="col-lg-8 ">
                            <img src="{{ $basement->cover }}" alt="" width="200px" height="200">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-2">
                            <input type="file" name="cover" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <div class="col-lg-8">
                            <pre style="display: none;">
                                {!! $basement->content !!}
                            </pre>
                            <input type="hidden" name="content">
                            <input type="hidden" name="introduction">
                            <script id="introduction" type="text/plain" style="width:100%;height:500px;">
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">sort</label>
                        <div class="col-lg-8">
                            <input type="text" name="sort" value="{{$basement->sort}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">已上传的图片</label>
                        <div class="col-lg-8" id="oldimgs">
                            @foreach($picurls as $picurl)
                                <img src="{{$picurl->url}}" style='width:100px;height:80px' />
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2 ">图片</label>
                        <div class="col-lg-8">
                            <div id="dropzPic" class="dropzone">
                                <div class="dz-message">
                                    将文件拖至此处或点击上传.<br/>
                                    <span class="help-block"> 上传格式 jepg,gif,png,jpg<span class="h4 text-danger">主文件名中不能带 "."</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="form-group">
                        <label class="col-lg-2 control-label">上传图片</label>
                        <div class="col-lg-8" id="getfiles">
                            <a onclick="addfiles()" class="btn btn-sm btn-info">添加文件</a>
                        </div>
                    </div>--}}

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-8">
                            <button type="submit" class="btn btn-sm btn-primary" id="formGo">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="widget-foot">

            <!-- Footer goes here -->
        </div>
    </div>
@section('dropzone_js')
    <script src="/assets/javascripts/dropzone/dropzone.min.js"></script>
    <script>

        Array.prototype.indexOf = function(val) {
            for (var i = 0; i < this.length; i++) {
                if (this[i] == val) return i;
            }
            return -1;
        };
        Array.prototype.remove = function(val) {
            var index = this.indexOf(val);
            if (index > -1) {
                this.splice(index, 1);
            }
        };

        $("#dropzPic").dropzone({
            url: "/admin/basements/upload/a/a",
            maxFiles: 100,
            maxFilesize: 50,
            addRemoveLinks: true,
            init: function () {
                this.on("addedfile", function (file) {
                    if (file.name.split('.').length - 1 != 1) {
                        alert('您上传的文档主文件名中含有英文标点“.”请修改后再次上传，否则手机上无法正常打开。例如“12.10”改成“12月10日”。谢谢您的理解和配合！');
                        this.removeFile(file);
                    }
                    //如果后缀名不符合需求,给用户提示
                    var suffixName = file.name.split('.')[1].toLowerCase();
                    var suffixNames = [ "png", "jpg",'jpeg','gif'];
                    if (jQuery.inArray(suffixName, suffixNames) < 0) {
                        alert('请选择文件格式为： png,jpg,jpeg 的文件上传');
                        this.removeFile(file);
                    }

                    if (this.files.length) {
                        var _i, _len;
                        var isDuplicate = false;
                        for (_i = 0, _len = this.files.length-1; _i < _len; _i++) {
                            if( this.files[_i].name === file.name  ){
                                isDuplicate = true;
                            }
                        }

                        if(isDuplicate){
                            alert('不能上传重复文件');
                            this.removeFile(file);
                        }
                    }

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn-tgddel btn btn-danger btn-sm btn-block' data-dz-remove>删除</a>");

                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
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
                this.on("processing", function (file) {
                    $(".btn-submit").attr("disabled", "true")
                });
                this.on('success', function (file, response) {
                    console.log(response);
                    var newImgInput = '';

                    newImgInput = "<input type=hidden name='pictures[]' value='" + response.data.uploaded_file_url+ "'"+
                            " file_name='"+file.name+"'>";

                    $('form').append(newImgInput);
                    $(".btn-submit").removeAttr("disabled");
                });
                this.on('removedfile',function(file){
                    $("input[file_name='"+file.name+"']").remove();
                });
            }
        });





    </script>

@endsection
@endsection

@section('ueditor')
    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/ueditor/ueditor.config.js"></script>
    <script src="/ueditor/ueditor.all.min.js"></script>
    <script>
        var ue = UE.getEditor('introduction');
        ue.ready(function () {
            ue.setContent($('pre').html());
        });

        $(document).ready(function () {
            $('form').submit(function () {
                if (!check('title') || !check('logo')) {
                    return false;
                }

                if (typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
                    $('input[name=content]').val(ue.getContent());
                    $('input[name=introduction]').val(ue.getContentTxt());
                    jQuery.data(this, "disabledOnSubmit", {submited: true});
                    $('input[type=submit], input[type=button]', this).each(function () {
                        $(this).attr("disabled", "disabled");
                    });
                    return true;
                }
                else {
                    return false;
                }
            });
        });

        function check($checked) {
            var content = $("#" + $checked + "").val();
            if (content == "") {
                $("#" + $checked + "div").html('<span class="text-danger">该内容未填写</span>');
                return false;
            } else {
                $("#" + $checked + "div").html('');
                return true;
            }
        }
        var flag=false;
        var getfiles=document.getElementById('getfiles');
        function addfiles(){
            if(flag==false){
                var mes=confirm('添加新图片后，已上传的图片将全部被替换，确定吗？');
                    if(mes==true){
                        var newInput=document.createElement('input');
                        newInput.type='file';
                        newInput.name='pictures[]';
                        newInput.className='newInput';
                        getfiles.appendChild(newInput);
                        flag=true;
                     }
            }
            else{
                var newInput=document.createElement('input');
                newInput.type='file';
                newInput.name='pictures[]';
                newInput.className='newInput';
                getfiles.appendChild(newInput);
            }
        }
        $('#formGo').click(function(e){
            if (e && e.stopPropagation){
                e.stopPropagation()}
            else{
                window.event.cancelBubble=true}
            var gnl=confirm("确定要提交?");
            if (gnl==true){
                return true;
            }else{
                return false;
            }
        });

    </script>

@endsection
