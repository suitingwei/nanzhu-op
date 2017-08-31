@extends('layouts.admin')

@section('title')
    编辑制作公司
@stop

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
            编辑公司
        </div>

        <div class="widget-content">
            <div class="padd">

                <form class="form-horizontal" action="/admin/companies/{{$company->id}}" method="POST"
                      enctype='multipart/form-data' onsubmit="return sumbit_sure()">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-8">
                            <input type="text" id='title' name="title" value="{{$company->title}}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">logo</label>
                        <div class="col-lg-8 ">
                            <img src="{{ $company->logo }}" alt="" width="200px" height="200">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-2">
                            <input type="file" name="logo" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <div class="col-lg-8">
                            <pre style="display: none;">
                                {!! $company->introduction !!}
                            </pre>
                            <input type="hidden" name="introduction">
                            <input type="hidden" name="plain_introduction">
                            <script id="introduction" type="text/plain" style="width:100%;height:500px;">
                            </script>
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