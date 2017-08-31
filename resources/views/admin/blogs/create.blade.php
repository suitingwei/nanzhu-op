@extends('layouts.admin')

@section('title')
    创建
@stop

@section('content')

    <div class="widget wgreen">
        <div class="widget-head">
            创建
        </div>

        <div class="widget-content">
            <div class="padd">

                <form class="form-horizontal" action="/admin/blogs" method="POST" enctype='multipart/form-data'>
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input type="text" name="title" class="form-control" placeholder="名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">类型</label>
                        <div class="col-lg-8">
                            <?php $is_trend_cover = 0 ?>
                            @if($type=="news")
                                <?php $is_trend_cover = 1 ?>
                            @endif
                            <input type="hidden" name="type" value="{{$type}}">
                            <select name="type_value" class="form-control">
                                <option value="">请选择</option>
                                @foreach($type_arr as $type)
                                    <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <div class="col-lg-8">
                            <input type="hidden" name="content">
                            <script id="content" type="text/plain" style="width:100%;height:500px;">
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">审核</label>
                        <div class="col-lg-8">
                            <div class="radio">
                                <label><input type="radio" name="is_approved" value="1">通过</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input type="radio" name="is_approved" value="2">拒绝</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="is_trend_cover" value="{{$is_trend_cover}}">
                    @if($is_trend_cover)
                        <div class="form-group">
                            <label class="col-lg-2 control-label">上传封面图片</label>
                            <div class="col-lg-8">
                                <input type="file" name="trend_cover" value=""/>
                            </div>
                        </div>
                    @endif
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

    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/ueditor/ueditor.config.js"></script>
    <script src="/ueditor/ueditor.all.min.js"></script>
    <script>
        var contentEditor= UE.getEditor('content');

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



