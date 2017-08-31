@extends('layouts.admin')

@section('title')
    编辑
@stop

@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/admin/css/easy-autocomplete.min.css">
    <style>
        .newInput {
            margin-top: 10px;
            font-size: 14px;
            line-height: 16px;
        }

        .autocomplete-suggestions {
            border: 1px solid #999;
            background: #FFF;
            overflow: auto;
        }

        .autocomplete-suggestion {
            padding: 2px 5px;
            white-space: nowrap;
            overflow: hidden;
        }

        .autocomplete-selected {
            background: #F0F0F0;
        }

        .autocomplete-suggestions strong {
            font-weight: normal;
            color: #3399FF;
        }

        .autocomplete-group {
            padding: 2px 5px;
        }

        .autocomplete-group strong {
            display: block;
            border-bottom: 1px solid #000;
        }
    </style>
    <div class="widget wgreen">
        <div class="widget-head">
            <span> {{ $company->title }}</span>
        </div>

        <div class="widget-content">
            <div class="padd">
                <form action="/admin/companies/{{$company->id}}/allow-cooperation" class="form form" method="POST"
                      id="toggleAllowCooperation">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="">是否允许寻求合作</label>
                        <input type="hidden" name="allow_cooperation">
                        <input type="checkbox" @if($company->allow_cooperation) checked
                               @endif id="allowCooperationSwitch">
                    </div>
                </form>
                @if($company->allow_cooperation)
                    <form class="form-horizontal" action="/admin/companies/{{$company->id}}" method="POST"
                          id="receiveUsersForm" onsubmit="return sumbit_sure()"
                          enctype='multipart/form-data'>
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="PATCH">
                        <input class="form-control" id="addNewContactUser" type="text" />

                        <div id="contacters" style="margin-top: 10px"></div>

                        <button type="submit" class="btn btn-sm btn-primary">授权联系人</button>

                        <div style="margin-top: 20px;font-size: 20px;">
                            现有联系人:
                        @foreach($receiveUsers as $user)
                            <label class="label label-success">{{$user->FNAME}} {{ $user->FPHONE }}</label>
                        @endforeach
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="/assets/admin/js/jquery.autocomplete.js"></script>
    <script>

        $(function () {
            $('#allowCooperationSwitch').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });

            $('#allowCooperationSwitch').change(function () {
                const switchStatus = $(this).prop('checked') ? 1 : 0;
                $('input[name="allow_cooperation"]').val(switchStatus);
                $("#toggleAllowCooperation").submit();
            });
        })
        var uniqueClass=0;
        $("#addNewContactUser").devbridgeAutocomplete({
            serviceUrl: '/admin/users/search',
            onSelect: function (suggestion) {
                var labelForUserName = document.createElement('label');
                labelForUserName.className='label label-info forclick';
                labelForUserName.style='padding:5px 10px;margin-right:15px';
                labelForUserName.innerHTML=suggestion.value;
                var input = document.createElement('input');
                input.setAttribute('name','receive_user_ids[]');
                input.setAttribute('type','hidden');
                input.value=suggestion.data.user_id;
                var div = document.createElement('div');
                div.style='float:left';
                div.className='thisUser'+uniqueClass;
                div.appendChild(input);
                div.setAttribute('onclick','dele("thisUser'+uniqueClass+'")');
                div.appendChild(labelForUserName);
                $('#contacters').append(div);
                $('#addNewContactUser').val('');
                uniqueClass++;
            },
        });
        function dele(className) {
            var gnl = confirm("确定删除此联系人?");
            if (gnl == true) {
                $('.'+className).eq(0).remove();
            }
        }
        function sumbit_sure() {
            var gnl = confirm("确定提交?");
            if (gnl == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection