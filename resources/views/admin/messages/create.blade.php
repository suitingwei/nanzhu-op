@extends('layouts.admin')

@section('title')
    创建
@stop

@section('content')

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

                <form class="form-horizontal" action="/admin/messages" method="POST" enctype='multipart/form-data'>
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="col-lg-2 control-label">类型</label>
                        <div class="col-lg-5">
                            <select id="type" name="type" class="form-control">
                                @foreach(App\Models\Message::types() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">标题</label>
                        <div class="col-lg-5">
                            <input type="text" name="title" class="form-control" placeholder="标题">
                        </div>
                    </div>

                    <div id="uri" style="display:none;">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">uri</label>
                            <div class="col-lg-5">
                                <input type="text" name="uri" class="form-control" placeholder="标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">notice</label>
                            <div class="col-lg-5">
                                <input type="text" name="notice" class="form-control" placeholder="标题">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">发送对象</label>
                        <div class="col-lg-8">
                            <div class="row">
                            <p style="padding:5px 0 0 13px;font-weight: 600">台前职位</p>
                            @foreach(App\Models\Profile::$beforeScenePositions as $before_position)
                                <div class="col-lg-3">
                                    <label class="label label-success">
                                        <input type="checkbox" name="position[]" value="{{$before_position}}" / class='position'>{{$before_position}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                            <div class="row">
                            <p style="padding:5px 0 0 13px;font-weight: 600">幕后职位</p>
                            @foreach(App\Models\Profile::$behindScenePositions as $behind_position)
                                <div class="col-lg-3">
                                    <label class="label label-info">
                                        <input type="checkbox" name="position[]" value="{{$behind_position}}" / class='position'>{{$behind_position}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">接受范围</label>
                        <div class="col-lg-5">
                            <input type="radio" name="scope" value="0">所有人
                            <input type="radio" checked name="scope" value="1">指定的人
                            <input type="text" name="scope_ids" value="">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label">发送数量</label>
                        <div class="col-lg-5">
                            <input class="howmanytosend" rows="8" cols="40"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">内容</label>
                        <div class="col-lg-5">
                            <textarea name="content" rows="8" cols="40"
                                      style="margin-left: 0px; margin-right: 0px; width: 464px;"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                    <div id="pics" >
                        @for($i =0 ;$i<9;$i++)
                            <div class="form-group">
                                <label class="col-lg-2 control-label">上传图片</label>
                                <div class="col-lg-5">
                                    <input type="file" name="pic_url[]" value=""/>
                                </div>
                            </div>
                        @endfor

                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-6">
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

    </div>

    </div>
@endsection
@section("javascript")
    <script type="text/javascript" charset="utf-8">
        $("#type").on("change", function () {
            $("#pics").hide();
            $("#uri").hide();
            if ($(this).val() == "BLOG" || $(this).val() =='SYSTEM') {
                $("#pics").show();
            }

            if ($(this).val() == "NOTICE") {
                $("#uri").show();
            }
        });

        var position = document.getElementsByClassName('position');
        for(var i=0;i<position.length;i++){
            position[i].onclick=function(){
                var param = "";
                var that = this;
                for(var j=0;j<position.length;j++) {
                    if (position[j].checked) {
                        param+=position[j].value+",";
                    }
                }

                $.ajax({
                    url : 'countNums/?position='+param,
                    type: 'post',
                    success:function (res) {
                        $('.howmanytosend').eq(0).val(res.num);
                    }
                });
            }
        }

    </script>
@endsection



