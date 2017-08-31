@extends('layouts.admin')

@section('title')
    招聘编辑
@stop

@section('content')

    <div class="widget wgreen">
        <div class="widget-head">
            招聘编辑
        </div>

        <div class="widget-content">
            <div class="padd">
                <form class="form-horizontal" action="/admin/recruits/{{$recruit->id}}" method="POST"
                      enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">类型</label>
                        <div class="col-lg-8">
                            <select name="type" class="form-control">
                                <option value="公司" @if($recruit->type=="公司") selected @endif >公司</option>
                                <option value="个人" @if($recruit->type=="个人") selected @endif >个人</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input type="text" name="title" class="form-control" placeholder=""
                                   value="{{$recruit->title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">招聘人数</label>
                        <div class="col-lg-8">
                            <input type="text" name="count" class="form-control" placeholder=""
                                   value="{{$recruit->count}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">招聘方</label>
                        <div class="col-lg-8">
                            <input type="text" name="employer" class="form-control" placeholder=""
                                   value="{{$recruit->employer}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">详情</label>
                        <div class="col-lg-8">
                            <input type="hidden" name="content">
                            <pre style="display: none;">
                                {!! $recruit->content !!}
                            </pre>
                            <script id="content" type="text/plain">
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">审核</label>
                        <div class="col-lg-8">
                            <div class="radio">
                                <label><input type="radio" name="is_approved" @if($recruit->is_approved==1) checked
                                              @endif value="1">通过</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input type="radio" name="is_approved" @if($recruit->is_approved==2) checked
                                              @endif value="2">拒绝</label>
                            </div>
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
        <div class="widget-foot">
            <!-- Footer goes here -->
        </div>
    </div>

@endsection

@section('javascript')
    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/ueditor/ueditor.config.js"></script>
    <script src="/ueditor/ueditor.all.min.js"></script>
    <script>
        var contentEditor = UE.getEditor('content');
        contentEditor.ready(function () {
            contentEditor.setContent($('pre').html());
        });

        $(document).ready(function () {
            $('form').submit(function () {
                if (!document.getElementById("radio1").checked && !document.getElementById("radio2").checked) {
                    alert("请审核后保存");
                    return false;
                }
                if (typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
                    jQuery.data(this, "disabledOnSubmit", {submited: true});
                    $('input[name=content]').val(contentEditor.getContent());
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