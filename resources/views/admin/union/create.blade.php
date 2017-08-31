@extends('layouts.admin')

@section('title')
    创建影视基地
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
            创建成员
        </div>

        <div class="widget-content">
            <div class="padd">

                <form onsubmit="return sumbit_sure()" class="form-horizontal" action="/admin/unions/{{$type}}" method="POST" enctype='multipart/form-data' method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="type" value="{{$type}}">

                    <div class="form-group">
                        <label class="col-lg-2 control-label">备注</label>
                        <div class="col-lg-8">
                            <input  name="name" type="text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">手机号</label>
                        <div class="col-lg-8">
                            <input  name="phone" type="text" />
                        </div>
                    </div>

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

  <script>
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

