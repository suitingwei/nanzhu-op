@extends('layouts.admin')

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
            创建黑名单
        </div>

        <div class="widget-content">
            <div class="padd">

                <form class="form-horizontal" action="/admin/black-lists" method="POST"
                      enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-lg-2 control-label">手机号</label>
                        <input type="text" name="phone">
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">备注</label>
                        <textarea type="text" name="note" cols="50" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-8">
                            <button type="submit" class="btn btn-sm btn-primary">保存</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

