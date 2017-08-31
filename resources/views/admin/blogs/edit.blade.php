@extends('layouts.admin')

@section('title')
    编辑
@stop

@section('content')

    <div class="widget wgreen">
        <div class="widget-head">
            编辑
        </div>

        <div class="widget-content">
            <div class="padd">

                <form class="form-horizontal" action="/admin/blogs/{{$blog->id}}" method="POST"
                      enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH">

                    <input type="hidden" name="author_id" value="{{$blog->author_id}}">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input type="text" name="title" value="{{$blog->title}}" class="form-control" placeholder="名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">类型</label>
                        <div class="col-lg-8">
                            <?php $is_trend_cover = 0 ?>
                            @if($blog->type=="news")
                                <?php $is_trend_cover = 1 ?>
                            @endif
                            <input type="hidden" name="type" value="{{$blog->type}}">
                            <select name="type_value" class="form-control">
                                @foreach($type_arr as $type)
                                    <option value="{{$type}}" @if($type==$blog->type_value) selected @endif>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <div class="col-lg-8">
                            <input type="hidden" name="content">
                            <pre style="display: none;">
                                {!! $blog->content !!}
                            </pre>
                            <script id="content" type="text/plain" style="width:100%;height:500px;">
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">审核</label>
                        <div class="col-lg-8">
                            <div class="radio">
                                <label><input id="radio1" type="radio" name="is_approved" @if($blog->is_approved==1) checked @endif value="1">通过</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input id="radio2" type="radio" name="is_approved" @if($blog->is_approved==2) checked @endif value="2">拒绝</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">审核意见</label>
                        <div class="col-lg-8">
                            <input type="text" name="approved_opinion" value="{{$blog->approved_opinion}}" class="form-control" placeholder="审核意见">
                        </div>
                    </div>

                    <input type="hidden" name="is_trend_cover" value="{{$is_trend_cover}}">
                    @if($is_trend_cover)
                        <div class="form-group">
                            <label class="col-lg-2 control-label">上传封面图片</label>
                            <div class="col-lg-8">
                                @if($blog->trend_cover)
                                    <a href="{{$blog->trend_cover}}" target="blank"><img src="{{$blog->trend_cover}}" style="width:100px"/></a>
                                    删除<input type="checkbox" value="1" name="trend_cover_del">
                                @endif
                                <input type="file" name="trend_cover" value=""/>
                            </div>
                        </div>
                    @endif

                    <?php $arr = ["1", "2", "3", "4", "5", "6", "7", "8", "9"] ?>
                    <?php use App\Models\Picture; ?>
                    <?php $pics = Picture::where("blog_id", $blog->id)->get(); ?>

                    @foreach($arr as $key=> $a )
                        <div class="form-group">
                            <label class="control-label col-md-2">图片{{$a}}</label>
                            <div class="col-md-8">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    @if(isset($pics[$key]))
                                        <a href="{{$pics[$key]->url}}" target="blank">
                                            <img src="{{$pics[$key]->url}}" style="width:100px"/></a>
                                        <input type="hidden" name="pic_ids[]" value="{{$pics[$key]->id}}">
                                        删除<input type="checkbox" value="1" name="pic_del_{{$a}}">
                                    @endif
                                    <div class="input-group">
                                        <div data-trigger="fileinput">
                                            <div class="form-group">
                                                <div class="col-lg-8">
                                                    <input type="file" name="pic_url[]" value=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
        var contentEditor = UE.getEditor('content');
        contentEditor.ready(function(){
            contentEditor.setContent($('pre').html());
        });

        $(document).ready(function () {
            $('form').submit(function () {
                if (!document.getElementById("radio1").checked && !document.getElementById("radio2").checked) {
                    alert("请审核后保存");
                    return false;
                }
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