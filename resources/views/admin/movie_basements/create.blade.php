@extends('layouts.admin')

@section('title')
    创建
@stop
@section('dropzone_css')
    <link href="/assets/javascripts/dropzone/dropzone.min.css" rel="stylesheet">
@endsection
@section('content')
    <head>
        <meta http-equiv="Cache-Control" content="no-cache">
    </head>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
    <script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
    <script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>
    <link rel="stylesheet" href="/assets/admin/css/jquery.tagsinput.min.css">
    <style>
        .autocomplete-suggestions {
            background-color: #fff;
            box-shadow: 0 0 5px #ccc;
            border-radius: 0 0 3px 3px;
        }

        .autocomplete-suggestion {
            padding: 3px 7px;
        }

        .autocomplete-suggestion strong {
            color: #2094ca;
        }
        .newInput {
            margin-top:10px;
            font-size:14px;
            line-height:16px;

        }

        #contact sup{cursor:pointer;font-size:65%}
    </style>
    <div class="widget wgreen">
        <div class="widget-head">
            创建{{$type}}
        </div>

        <div class="widget-content">
            <div class="padd">

                <form onsubmit="return sumbit_sure()" class="form-horizontal" action="/admin/basements/{{$type}}" method="POST" enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" value="{{$user_id}}">
                    <input type="hidden" name="type" value="{{$type}}">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input id="title" type="text" name="title" class="form-control" placeholder="名称">
                            <div id="titlediv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Logo</label>
                        <div class="col-lg-8">
                            <input id="logo" name="cover" type="file" class="form-control">
                            <div id="logodiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <input type="hidden" name="content">
                        <input type="hidden" name="introduction">
                        <div class="col-lg-8">
                            <script id="editor" type="text/plain" style="width:100%;height:500px;">

                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Sort</label>
                        <div class="col-lg-8">
                            <input  name="sort" type="text" placeholder="排序值，值越大越靠前" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2 ">图片</label>
                        <div class="col-lg-8">
                            <div id="dropzPic" class="dropzone">
                                <div class="dz-message">
                                    将文件拖至此处或点击上传.<br/>
                                    <span class="help-block"> 上传格式 png,jpg<span class="h4 text-danger">主文件名中不能带 "."</span></span>
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
                            <button type="submit" class="btn btn-sm btn-primary btn-submit">保存</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="widget-foot">
            <!-- Footer goes here -->
        </div>
    </div>

    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/ueditor/ueditor.config.js"></script>
    <script src="/ueditor/ueditor.all.min.js"></script>
    <script src="/assets/admin/js/jquery.autocomplete.min.js"></script>
    <script src="/assets/admin/js/jquery.tagsinput.min.js"></script>
    <script>
        var ue = UE.getEditor('editor');
    </script>
    <script>
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
        Array.prototype.unique = function(){
             var res = [];
             var json = {};
             for(var i = 0; i < this.length; i++){
                if(!json[this[i]]){
                    res.push(this[i]);
                    json[this[i]] = 1;
                }
             }
            return res;
        };
        var contactnumber = 1;
        var allpeople=[];
        var fortestpeople={};
        autocompletion(contactnumber);
        function autocompletion(contact) {

            $('#autocomplete' + contact).autocomplete({
                serviceUrl: '/admin/companies/create/autoload',
                onSelect: function (suggestion) {
                    var thisContact = $(this).val();
                    allpeople.push(thisContact);
                    var newContact;
                    var length=allpeople.unique().length;
                    // console.log(allpeople.unique());
                    // 这里不能用数组直接去判断，因为会执行很多次；
                    // 所以我们定义了一个新的obj{} 将已经存在的值 当成obj的一个属性 去判断
                    // 为什么数组要去重呢  因为如果不去重  这里没问题 但当我们点击删除按钮的时候
                    // 只会清除一次  比如 你这个arr[1,1,1,12,2 ]只会把一个1 清除得到[1,1,12,2]那么在此点击时候 这个1 就自动出来了
                    // 请除的时候 也必须从大往小循环 ，从小往大循环的话  splice() 清除后 数组发生变动 会跳过删除元素的下一个元素
                    // 其中可能参数带 空格 所以加码并解码
                    console.log(allpeople.unique());
                    for(var i=0;i<length;i++){
                        if(!fortestpeople[allpeople.unique()[i]]){
                            fortestpeople[allpeople.unique()[i]]=1;
                            var incaseofspace=encodeURIComponent(allpeople.unique()[i])
                            console.log(incaseofspace)
                            newContact = '<span class="contractPerson'+contactnumber+'"><label >' + allpeople.unique()[i] +
                                         '</label> <sup  onclick=javascript:deleteThisId("contractPerson'+contactnumber+'","'+incaseofspace+'")>x</sup> | ' +
                                         '<input  type="text"  hidden="hidden" name="contact_user_ids[]" value="' + suggestion.data + '">' +
                                         '</span>';

                            $('#contact').append(newContact);
                        }
                    }
                    $('#autocomplete1').val("");
                    contactnumber++;
                }
            });
        }

        function deleteThisId(classname,contrct){
            var contrcts=decodeURIComponent(contrct)
            console.log(contrcts)
            delete fortestpeople[contrcts];

            for(var i=allpeople.unique().length;i>=0;i--){
                if(contrcts==allpeople[i]){
                    allpeople.splice(i,1)
                }
            }

            console.log(allpeople)
            console.log(allpeople.unique())
            $("."+classname).eq(0).remove();

        }
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


        /*function addfiles(){
            var newInput=document.createElement('input');
            newInput.type='file';
            newInput.name='pic_url[]';
            newInput.className='newInput';
            getfiles.appendChild(newInput);
        }*/
        function sumbit_sure(){
            var gnl=confirm("确定要提交?");
            if (gnl==true){
                return true;
            }else{
                return false;
            }
        }
    </script>
@endsection
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

                    newImgInput = "<input type=hidden name='pic_url[]' value='" + response.data.uploaded_file_url+ "'"+
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
