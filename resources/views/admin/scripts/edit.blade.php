@extends('layouts.admin')

@section('title')
    编辑
@stop

@section('content')

    <link rel="stylesheet" href="//cdn.jsdelivr.net/editor/0.1.0/editor.css">
    <script src="//cdn.jsdelivr.net/editor/0.1.0/editor.js"></script>
    <script src="//cdn.jsdelivr.net/editor/0.1.0/marked.js"></script>
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

                <form class="form-horizontal" action="/admin/scripts/{{$script->id}}" method="POST"
                      enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH">

                    <input type="hidden" name="author_id" value="{{$script->author_id}}">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-5">
                            <input type="text" name="title" value="{{$script->title}}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <div class="col-lg-8">
                            <pre style="display: none;">
                                {!! $script->content !!}
                            </pre>
                            <input type="hidden" name="content">
                            <input type="hidden" name="plain_content">
                            <script id="content" type="text/plain" style="width:100%;height:500px;">

                            </script>
                        </div>
                    </div>

                    @for($index =0 ;$index<9;$index++)
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                <input type="file" name="pictures[]" class="form-control">
                            </div>
                        </div>
                    @endfor
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-6">
                            <button type="submit" class="btn btn-sm btn-primary">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/ueditor/ueditor.config.js"></script>
    <script src="/ueditor/ueditor.all.min.js"></script>
    <script>
        var ue = UE.getEditor('content');
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



