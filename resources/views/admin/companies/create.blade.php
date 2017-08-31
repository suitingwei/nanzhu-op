@extends('layouts.admin')

@section('title')
    创建制作公司
@stop

@section('content')

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

        #contact sup {
            cursor: pointer;
            font-size: 65%
        }
    </style>
    <div class="widget wgreen">
        <div class="widget-head">
            创建公司
        </div>

        <div class="widget-content">
            <div class="padd">

                <form onsubmit="return sumbit_sure()" class="form-horizontal" action="/admin/companies" method="POST"
                      enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" value="{{$user_id}}">
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
                            <input id="logo" name="logo" type="file" class="form-control">
                            <div id="logodiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <input type="hidden" name="introduction">
                        <input type="hidden" name="plain_introduction">
                        <div class="col-lg-8">
                            <script id="editor" type="text/plain">
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">联系人</label>
                        <div id="contact" class="col-lg-8">
                            <input type="text" id="autocomplete1" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">上传图片</label>
                        <div class="col-lg-8" id="getfiles">
                            <a onclick="addfiles()" class="btn btn-sm btn-info">添加文件</a>
                            {{--<input type="file" name="pic_url[]" value=""/>--}}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-8">
                            <button type="submit" class="btn btn-sm btn-primary">保存</button>
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
                    $('input[name=introduction]').val(ue.getContent());
                    $('input[name=plain_introduction]').val(ue.getContentTxt());
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
        Array.prototype.unique = function () {
            var res = [];
            var json = {};
            for (var i = 0; i < this.length; i++) {
                if (!json[this[i]]) {
                    res.push(this[i]);
                    json[this[i]] = 1;
                }
            }
            return res;
        };
        var contactnumber = 1;
        var allpeople = [];
        var fortestpeople = {};
        autocompletion(contactnumber);
        function autocompletion(contact) {
            $('#autocomplete' + contact).autocomplete({
                serviceUrl: '/admin/companies/create/autoload',
                onSelect: function (suggestion) {
                    var thisContact = $(this).val();
                    allpeople.push(thisContact);
                    var newContact;
                    var length = allpeople.unique().length;
                    // console.log(allpeople.unique());
                    // 这里不能用数组直接去判断，因为会执行很多次；
                    // 所以我们定义了一个新的obj{} 将已经存在的值 当成obj的一个属性 去判断
                    // 为什么数组要去重呢  因为如果不去重  这里没问题 但当我们点击删除按钮的时候
                    // 只会清除一次  比如 你这个arr[1,1,1,12,2 ]只会把一个1 清除得到[1,1,12,2]那么在此点击时候 这个1 就自动出来了
                    // 请除的时候 也必须从大往小循环 ，从小往大循环的话  splice() 清除后 数组发生变动 会跳过删除元素的下一个元素
                    // 其中可能参数带 空格 所以加码并解码
                    console.log(allpeople.unique());
                    for (var i = 0; i < length; i++) {
                        if (!fortestpeople[allpeople.unique()[i]]) {
                            fortestpeople[allpeople.unique()[i]] = 1;
                            var incaseofspace = encodeURIComponent(allpeople.unique()[i])
                            console.log(incaseofspace)
                            newContact = '<span class="contractPerson' + contactnumber + '"><label >' + allpeople.unique()[i] +
                                '</label> <sup  onclick=javascript:deleteThisId("contractPerson' + contactnumber + '","' + incaseofspace + '")>x</sup> | ' +
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

        function deleteThisId(classname, contrct) {
            var contrcts = decodeURIComponent(contrct)
            console.log(contrcts)
            delete fortestpeople[contrcts];

            for (var i = allpeople.unique().length; i >= 0; i--) {
                if (contrcts == allpeople[i]) {
                    allpeople.splice(i, 1)
                }
            }

            console.log(allpeople)
            console.log(allpeople.unique())
            $("." + classname).eq(0).remove();

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
        function addfiles() {
            var newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'pic_url[]';
            newInput.className = 'newInput';
            getfiles.appendChild(newInput);
        }
        function sumbit_sure() {
            var gnl = confirm("确定要提交?");
            if (gnl == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection

