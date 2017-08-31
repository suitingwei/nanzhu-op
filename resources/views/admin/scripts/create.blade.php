@extends('layouts.admin')

@section('title')
    创建
@stop

@section('content')

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
    </style>
    <div class="widget wgreen">
        <div class="widget-head">
            <div class="pull-left">Forms</div>
            <div class="widget-icons pull-right">
                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="widget-content">
            <div class="padd">

                <br/>
                <!-- Form starts.  -->

                <form class="form-horizontal" action="/admin/scripts" method="POST" enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input type="text" id="title" name="title" class="form-control" placeholder="名称">
                            <div id="titlediv"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">作者</label>
                        <div class="col-lg-8">
                            <input type="text" id="author" name="author" class="form-control" placeholder="作者名称">
                            <div id="authordiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <div class="col-lg-8" style="background:#fff">
                            <input type="hidden" name="content">
                            <input type="hidden" name="plain_content">
                            <script id="content" type="text/plain" style="width:100%;height:500px;">
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">联系人</label>
                        <div id="contact" class="col-lg-8">
                            <input type="text" id="autocomplete1" class="form-control">
                        </div>
                    </div>
                    @for($i =0 ;$i<9;$i++)
                        <div class="form-group">
                            <label class="col-lg-2 control-label">上传图片</label>
                            <div class="col-lg-8">
                                <input type="file" name="pic_url[]" value=""/>
                            </div>
                        </div>
                    @endfor

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-6">
                            <button id="submitbutton" type="submit" class="btn btn-sm btn-primary">保存</button>
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
        var ue = UE.getEditor('content');
        $(document).ready(function () {
            $('form').submit(function () {
                if (!check('title')) {
                    return false;
                }
                if (typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
                    $('input[name=content]').val(ue.getContent());
                    $('input[name=plain_content]').val(ue.getContentTxt());
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

        var contactnumber = 1;
        autocompletion(contactnumber);
        function autocompletion(contact) {
            $('#autocomplete' + contact).autocomplete({
                serviceUrl: '/admin/companies/create/autoload',
                onSelect: function (suggestion) {
                    var thisContact = $(this).val();
                    var newContact = '<label>' + suggestion.value + ' </label>&nbsp;&nbsp;' +
                            '<input type="text"  hidden="hidden" name="contact_user_ids[]" value="' + suggestion.data + '">';
                    $('#contact').append(newContact);
                    $('#autocomplete1').val("");
                    contactnumber++;
                }
            });
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

    </script>
@endsection



