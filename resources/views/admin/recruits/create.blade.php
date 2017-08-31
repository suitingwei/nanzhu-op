@extends('layouts.admin')

@section('title')
    新建招聘
@stop

@section('content')

    <div class="widget wgreen">
        <div class="widget-head">
            新建招聘
        </div>

        <div class="widget-content">
            <div class="padd">

                <form class="form-horizontal" action="/admin/recruits" method="POST" enctype='multipart/form-data'>
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="col-lg-2 control-label">类型</label>
                        <div class="col-lg-8">
                            <select name="type" class="form-control">
                                <option value="公司">公司</option>
                                <option value="个人">个人</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input type="text" name="title" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">招聘人数</label>
                        <div class="col-lg-8">
                            <input type="text" name="count" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">招聘方</label>
                        <div class="col-lg-8">
                            <input type="text" name="employer" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">详情</label>
                        <div class="col-lg-8">
                            <input type="hidden" name="content">
                            <script id="content" type="text/plain"></script>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-6">
                            <button type="submit" class="btn btn-lg btn-primary">保存</button>
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
        var contentEditor = UE.getEditor('content');

        $(document).ready(function () {
            $('form').submit(function () {
                if (typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
                    $('input[name=content]').val(contentEditor.getContent());
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
    </script>

@endsection