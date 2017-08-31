@extends('layouts.admin')

@section('title')
    社保信息
@stop

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta name="format-detection" content="telephone=no">
<style>
    table img{width:85px;
        height: 65px;}
    table  {  white-space: nowrap;font-size: 14px;}
    #nobordered th{border:none}
    .page{list-style:none;overflow: hidden}
    .page li{float:left;margin:5px 3px 0 3px}
    .page li a{color:black}
    #ordershow td{color:black;white-space: nowrap}
    .label{margin-top:14px}
    .jiacu tr td:nth-child(2){ font-weight: 800;color:black}
</style>
<style>
    .details-resource {
        padding: 20px 0;
    }

    .details-logo {
        width: 70px;
        height: 70px;
        border-radius: 4px;
        overflow: hidden;
        margin: 10px auto 20px;
    }

    .details-logo img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .details-title {
        font-weight: normal;
        font-size: 22px;
        padding: 0 20px;
    }

    .resource-bd {
        padding-bottom: 100px;
    }

    .resource-bd .content {
        padding-left: 20px;
        padding-right: 20px;
    }

    .resource-bd .content h4 {
        margin-bottom: 20px;
    }

    .resource-bd .content h5 {
        color: #333;
        font-size: 17px;
        font-weight: bold;
    }

    .resource-bd .img {
        margin: 0 20px;
    }

    .resource-bd img {
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
    }

    .resource-bd .content p,
    .resource-bd .content pre {
        color: #333;
        margin-bottom: 30px;
        font-size: 16px;
        line-height: 1.6;
        white-space: pre-wrap;
        word-wrap: break-word;
        text-align: justify;
    }

    .details-fixed {
        padding: 8px 0;
        text-align: center;
        background: #fff;
    }

    .details-fixed:before {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 1px;
        content: '';
        -webkit-transform: scaleY(.5);
        transform: scaleY(.5);
        background-color: #ddd;
    }

    .details-fixed .mui-btn-success {
        font-size: 18px;
        border-radius: 100px;
        width: 170px;
        padding: 6px 0;
    }

    .writers h2 {
        font-weight: normal;
        border-top: 1px solid #e8e8e7;
        font-size: 20px;
        padding-top: 28px;
        margin: 0 20px 22px;
    }

    .writers-item {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .writers-item .slider-img:first-child {
        margin-left: 20px;
    }

    .writers-item .slider-img {
        display: inline-block;
        width: 60px;
        margin-right: 10px;
        text-align: center;
        font-size: 16px;
    }

    .writers-item .slider-img p {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        background: #f9f9f9 url("/assets/mobile/img/logo-d.png") no-repeat center center;
        background-size: contain;
    }

    .writers-item .slider-img img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .mui-popup-inner {
        padding: 25px 15px 15px;
    }

    .mui-fullscreen {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .mui-slider {
        position: relative;
        z-index: 1;
        overflow: hidden;
        width: 100%;
    }

    .mui-preview-image.mui-fullscreen {
        position: fixed;
        z-index: 999;
        background-color: #000;
    }

    .mui-preview-header,
    .mui-preview-footer {
        position: absolute;
        width: 100%;
        left: 0;
        z-index: 10;
    }

    .mui-preview-header {
        height: 44px;
        top: 0;
    }

    .mui-preview-footer {
        height: 50px;
        bottom: 0px;
    }

    .mui-preview-header .mui-preview-indicator {
        display: block;
        line-height: 25px;
        color: #fff;
        text-align: center;
        margin: 15px auto 4;
        width: 50px;
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 12px;
        font-size: 16px;
        margin: 10px auto 0;
    }

    .mui-preview-image {
        display: none;
        -webkit-animation-duration: 0.5s;
        animation-duration: 0.5s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    .mui-preview-image.mui-preview-in {
        -webkit-animation-name: fadeIn;
        animation-name: fadeIn;
    }

    .mui-preview-image.mui-preview-out {
        background: none;
        -webkit-animation-name: fadeOut;
        animation-name: fadeOut;
    }

    .mui-preview-image.mui-preview-out .mui-preview-header,
    .mui-preview-image.mui-preview-out .mui-preview-footer {
        display: none;
    }

    .mui-zoom-scroller {
        position: absolute;
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        -webkit-backface-visibility: hidden;
    }

    .mui-zoom {
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }

    .mui-slider .mui-slider-group .mui-slider-item img {
        width: auto;
        height: auto;
        max-width: 80%;
        max-height: 70%;
    }

    .mui-android-4-1 .mui-slider .mui-slider-group .mui-slider-item img {
        width: 100%;
    }

    .mui-android-4-1 .mui-slider.mui-preview-image .mui-slider-group .mui-slider-item {
        display: inline-table;
    }

    .mui-android-4-1 .mui-slider.mui-preview-image .mui-zoom-scroller img {
        display: table-cell;
        vertical-align: middle;
    }

    .mui-preview-loading {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        display: none;
    }

    .mui-preview-loading.mui-active {
        display: block;
    }

    .mui-preview-loading .mui-spinner-white {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -25px;
        margin-top: -25px;
        height: 50px;
        width: 50px;
    }

    .mui-preview-image img.mui-transitioning {
        -webkit-transition: -webkit-transform 0.5s ease, opacity 0.5s ease;
        transition: transform 0.5s ease, opacity 0.5s ease;
    }

    @-webkit-keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeOut {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    .header {
        margin-top: 64px;
        background-color: transparent;
    }

    .app {
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        background-color: rgba(255, 255, 255, .9);
        border-bottom: 1px solid #eee;
        width: 100%;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 5;
    }

    .app-icon {
        width: 50px;
        height: 50px;
        overflow: hidden;
        background: url("/assets/mobile/img/logo-lg.png") no-repeat center center;
        background-size: contain;

    }

    .app-text {
        margin-left: 10px;
        margin-right: auto;
    }

    .app-text-title {
        color: #181818;
        font-weight: normal;
        margin: 3px 0;
    }

    .app-text-summary {
        color: #828282;
        margin-bottom: 0;
    }

    .app-btn {
        display: block;
        padding: 6px 8px;
        text-align: center;
        color: #fff;
        background-color: #66c68c;
        border-radius: 3px;
        text-decoration: none;
        font-size: 16px;
    }

    .app-label {
        position: absolute;
        left: 0;
        top: 0;
        width: 44px;
        height: 32px;
        background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABACAMAAACpzkDwAAAAY1BMVEX////kNyDkNyDkNyDkNyDkNyDkNyDkNyDkNyDkNyD99vXkNyDkNyDkNyDkNyD1xcHkNyD////99vX76+r64d/41tT2y8j0wLzztK/xqKLvm5TtjYXrf3bqcGToX1HmTTzkNyDPEQg9AAAAEXRSTlMAESIzRFVmd4iZqqq7zN3u7uYy9NoAAAHASURBVHja1dXbkoIwEATQJtyXyxJFIKiE///KJSJCVhQ3ZB62H7Sssk6Nk8agt54ijXwG2EXzJHAxxuKkScAwx5KaRS702FBTbdQnuKtrI9V3sJbFV0rezR9aIWouNzcQrKs6fOHi9i74FPG+AiHD60zmnBFuhHjPJh7eZhVuN6sVMeATuO+bRr3Ksu234TzAdh4wV5048WYTznzgD3BfV93gnvsNOPWAz+FusWJev4GzT9kX8COdKav1uL1P+gLOfWAv3KofoT/gRejAABZPPf4FJwzYDTeqGxpc+IAZrK2i5hcdjh0Yw7IUChbV9C83w7kHmMOC3+BmePIkP/QLOHGwA+74cVxFxdszr2bYZLtLuFJrVbA8XU+3VY9wxrAPburH4V34QU5wDOyE720YYHkc740BNl/DEj6oCl/VKR7lCH+7sAGX0xVXXe/H+QUr8NOV5oAEjgESOAINHIIGDkAD25h3DbbjguLcVuEYNHACGjhzaOCcgQQuXNDAAWjgGDSwxYPTYRc0cAgaOAURzIhg24uY4BxEsEcEx6CBC4cIjkADkwwMkqqNMM3AoBoYVAODphIKZkRwSuTCxz/LDzuIyYMbR8EsAAAAAElFTkSuQmCC") no-repeat;
        background-size: contain;

    }

</style>
<link rel="stylesheet" href="/assets/css/ui.css">
<div class="panel panel-default">
    <div class="panel-heading" style="font-size: 18px">
        社保
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="table-responsive">
            <table  class="table table-bordered table-hover table-striped " id="ordershow">
                <thead id="nobordered">
                <tr class="info" style="">
                    <th style="colspan:2;overflow:hidden">参保人信息</th>
                    <th style="colspan:3;overflow:hidden">身份证照(点击查看原图)</th>
                    <th style="colspan:2;overflow:hidden">户籍信息</th>
                    <th style="colspan:3;overflow:hidden">参保信息</th>
                    <th style='colspan:2;overflow:hidden'>详细价格</th>
                </tr>
                </thead>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.panel-body -->
    <div>
        <input type="hidden" id="pagenumnow" value="1">
        <ul class="page pagination" id="page">
            <li id="shouye" >
                <a href='javascript:pagenum(1);'>首 页</a>
            </li>
            <li id="shangyiye"  >
                <a href='javascript:goback();'>上一页</a>
            </li>
            <li class="active"><a id="one" href="javascript:pagenum(1);" >1</a></li>
            <li><a id="two" href="javascript:pagenum(2);" >2</a></li>
            <li><a id="three" href="javascript:pagenum(3);" >3</a></li>
            <li class="more"><a id="five">...</a></li>
            <li><a id="last" ></a></li>
            <li >
                <a href='javascript:gonext();'>下一页</a>
            </li>
            <li id="weiye" >
                <a  onclick="pagenum(0);">尾 页</a>
            </li>
            <li >
			<span >共<span id="totalpagenum"></span>页 到第<input type="text" id="input_number" style="width:15%;color:black" />页
				<input name="" value="确定" type="button" onclick="jumpToPage(jQuery('#input_number').val());" style="color:black"/>
			</span>
            </li>
        </ul>
    </div>
</div>
    <script src="/assets/javascripts/m.js"></script>
    <script src="/assets/admin/js/changeurl.js"></script>
    <script src="/assets/admin/js/jquery.js"></script>
    <script>
        /**/
        var pading;
        var thisurl=changeurl();
        window.onload=function(){
           getajax(1);
            console.log(thisurl)
       };
        function getajax(page){
            $.ajax({
                type:'get',
                url :thisurl+"/api/social-securities/orders",
                data: {'from':'op','page':page},
                success:function(res){
                    ajaxsuccess(res)
                }
            })
        }
        //成功调取ajax
        function ajaxsuccess(res){

            $(".all").remove();
            var societySecutiry=res.data.orders;
            pading=res.data.total;
            originalpading(pading)
           // console.log(res.data.total)
            for(var i=0;i<societySecutiry.length;i++){
                var tbody=document.createElement("tbody");
                tbody.className="all"
                //开头的tr
                showallorderth(societySecutiry,i,tbody);
                //详情
                showallorderdetail(societySecutiry,i,tbody);
                ordershow.appendChild(tbody)
            }
        }
        //社保开头th
        function showallorderth(societySecutiry,i,tbody){
            var tr=document.createElement("tr");
            tr.innerHTML =
                    "<tr name='thistrhead'>" +
                    "<th colspan='13'>" +
                        "订单号:<a href=''>"+societySecutiry[i].serial_number+"</a> " +
                        "开始时间:<span >"+societySecutiry[i].show_start_date+"</span>&nbsp" +
                        "持续时间:<span >"+societySecutiry[i].show_continue_date+"</span>&nbsp" +
                        "缴费时长:<span >"+societySecutiry[i].show_cost_months+"</span>" +
                        "<span style='text-align: right;font-size:12px;float:right;color:#333'>下单时间:"+societySecutiry[i].created_at+"</span>" +
                    "</th> </tr>";
            tbody.appendChild(tr);
        }
        //社保具体内容
        function showallorderdetail(societySecutiry,i,tbody){
            var tr=document.createElement("tr");
            var idcarddetail,howtopay,howstart,societystate;
            if(societySecutiry[i].id_card_photo==""){
                idcarddetail=
                    "<td style='white-space: nowrap;'>" +
                    "<div class='img tc'><img src='"+societySecutiry[i].id_card_up_image+"' data-preview-src='' data-preview-group='1'/>" +
                    "<img src='"+societySecutiry[i].id_card_down_image+"' data-preview-src='' data-preview-group='1'/>" +
                    "</div></td>" ;
            }
            else {
                idcarddetail=
                    "<td style='white-space: nowrap'>" +
                     "<div class='img tc'><img src='" + societySecutiry[i].id_card_up_image + "' data-preview-src='' data-preview-group='1'/>" +
                     "<img src='" + societySecutiry[i].id_card_down_image + "' data-preview-src='' data-preview-group='1'/>" +
                     "<img src='" + societySecutiry[i].id_card_photo + "' data-preview-src='' data-preview-group='1'/>" +
                    "</div></td>";
            }
            var channel=societySecutiry[i].channel
            howtopay=howtopayfor(channel);
            if(societySecutiry[i].show_is_first=="社保转入"){
                howstart="<span class='label label-primary'>社保转入</span>"
            }
            if(societySecutiry[i].show_is_first=="初次参保") {
                howstart = "<span class='label label-danger'>初次参保</span>"
            }
            if(societySecutiry[i].show_is_first=="外埠转入北京") {
                howstart = "<span class='label label-info'>外埠转入北京</span>"
            }
            societystate="<span class='label label-warning'>"+societySecutiry[i].show_status+"</span>"
            tr.innerHTML=
                    "<td >" +
                        "<table class='table table-condensed jiacu' style='margin-bottom:0px'>" +
                            "<tr>" +
                                 "<td style='width:30%'>参保人姓名</td><td style='width:70%'>"+societySecutiry[i].user_name+"</td></tr>" +
                            "<tr>" +
                                 "<td style='width:30%'>身份证号</td><td style='width:70%'><span style='display:block;width:130px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>"+societySecutiry[i].id_card_number+"</span></td></tr>" +
                            "<tr>" +
                                 "<td style='width:30%'>手机号</td><td style='width:70%'>"+societySecutiry[i].user_phone+"</td></tr>" +
                        "</table>" +
                    "</td>" +
                    idcarddetail +
                    "<td >" +
                        "<table class='table table-condensed jiacu' style='margin-bottom:0px'>" +
                            "<tr>" +
                                "<td style='width:30%'>户籍类型</td><td style='width:70%'>"+societySecutiry[i].hukou_type+"</td></tr>" +
                            "<tr>" +
                                "<td style='width:30%'>户籍地址</td><td style='width:70%'><span style='display:block;width:140px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>"+societySecutiry[i].hukou_address+"</span></td></tr>" +
                            "<tr>" +
                                "<td style='width:30%'>民族</td><td style='width:70%'>"+societySecutiry[i].minority+"</td></tr>" +
                        "</table>" +
                    "</td>" +
                    "<td >" +
                        "<table class='table table-condensed jiacu' style='margin-bottom:0px'>" +
                        "<tr>" +
                        "<td style='width:27%'>参保方式</td><td style='width:73%;text-align: right'>"+ howstart +"</td></tr>" +
                        "<tr>" +
                        "<td style='width:27%'>状态</td><td style='width:73%;text-align: right'>"+ societystate +"</td></tr>" +
                        "<tr>" +
                        "<td style='width:27%'>支付方式</td><td style='width:73%;text-align: right'>"+ howtopay +"</td></tr>" +
                        "</table>" +


                    "</td>" +
                    "<td>" +
                        "<table class='table table-condensed jiacu' style='margin-bottom:0px'>" +
                            "<tr>" +
                                "<td>社保价格</td><td>"+societySecutiry[i].social_security_price+"</td></tr>" +
                            "<tr>" +
                                "<td>服务费</td><td>"+societySecutiry[i].service_price+"</td></tr>" +
                            "<tr>" +
                                "<td>总价</td><td>"+societySecutiry[i].total_price+"</td></tr>" +
                        "</table>" +
                    "</td>"
            tbody.appendChild(tr)
        }
        //支付方式
        function howtopayfor(channel){
            var consumeway=[
                {
                    'way':'alipay',
                    'chinese':'支付宝'
                },
                {
                    'way':'wx',
                    'chinese':'微信APP'
                },
                {'way':'alipay_wap'      ,'chinese': '支付宝手机网页'},
                {'way':'alipay_pc_direct','chinese': '即支付宝PC网页'},
                {'way':'alipay_qr'       ,'chinese': '支付宝扫码'},
                {'way':'bfb'             ,'chinese': '百度钱包APP'},
                {'way':'bfb_wap'         ,'chinese': '百度钱包手机网页'},
                {'way':'cp_b2b'          ,'chinese': 'B2B银联PC网页'},
                {'way':'upacp'           ,'chinese': '银联APP支付'},
                {'way':'upacp_wap'       ,'chinese': '银联手机网页'},
                {'way':'upacp_pc'        ,'chinese': '银联PC网页支付'},
                {'way':'wx_pub'          ,'chinese': '微信公众号'},
                {'way':'wx_pub_qr'       ,'chinese': '微信公众号扫码'},
                {'way':'wx_wap'          ,'chinese': '微信WAP'},
                {'way':'yeepay_wap'      ,'chinese': '易宝手机网页'},
                {'way':'jdpay_wap'       ,'chinese': '京东手机网页'},
                {'way':'fqlpay_wap'      ,'chinese': '分期乐'},
                {'way':'qgbc_wap'        ,'chinese': '量化派'},
                {'way':'cmb_wallet'      ,'chinese': '招行一网通'},
                {'way':'applepay_upacp'  ,'chinese': 'Apple Pay'},
                {'way':'mmdpay_wap'      ,'chinese': '么么贷'},
                {'way':'qpay'            ,'chinese': 'QQ钱包'}
            ];
            for(var i=0;i<consumeway.length;i++){
                if(consumeway[i].way==channel){
                    switch(channel){
                        case "wx":
                            howtopay="<span class='label label-success'>"+consumeway[i].chinese+"</span>";
                            break;
                        case "alipay":
                            howtopay="<span class='label label-info'>"+consumeway[i].chinese+"</span>";
                            break;
                        default:
                            howtopay="<span class='label label-primary'>"+consumeway[i].chinese+"</span>";
                    }
                    return howtopay
                }
            }
        }
        //也就是 初始时候的页数
        function originalpading(pading) {
            $("#totalpagenum").text(pading);
            if (pading == 0) {
                $('#one').parent().hide();
                $('#two').parent().hide();
                $('#three').parent().hide();
                $('#five').parent().hide();
                $('#last').parent().hide();
            }
            else if (pading == 1) {
                $('#shouye').hide();
                $('#weiye').hide();
                $('#one').parent().hide();
                $('#two').parent().hide();
                $('#three').parent().hide();
                $('#five').parent().hide();
                $('#last').parent().hide();
            }
            else if (pading == 2) {
                $('#one').parent().show();
                $('#two').parent().show();
                $('#three').parent().hide();
                $('#five').parent().hide();
                $('#last').parent().hide();
            }
            else if (pading == 3) {
                $('#one').parent().show();
                $('#two').parent().show();
                $('#three').parent().show();
                $('#five').parent().hide();
                $('#last').parent().hide();
            }
            else if (pading == 4) {
                $('#one').parent().show();
                $('#two').parent().show();
                $('#three').parent().show();
                $('#five').parent().hide();
                $('#last').parent().show();
                $('#last').text(pading);
            }
            else {
                $('#one').parent().show();
                $('#two').parent().show();
                $('#three').parent().show();
                $('#five').parent().show();
                $('#last').parent().show();
                $('#last').text(pading);
            }
        }
        //点击页数时,页数发生改变
        function changepageindex(nowpage){

            if(nowpage<5 && pading>=5){
                $('#one').text(1);
                $('#one').attr('href','javascript:pagenum(1)');
                $('#two').text(2);
                $('#two').attr('href','javascript:pagenum(2)');
                $('#three').text(3);
                $('#three').attr('href','javascript:pagenum(3)');
                $('#five').text(4);
                $('#five').attr('href','javascript:pagenum(4)');
                $('#last').text(5);
                $('#last').attr('href','javascript:pagenum(5)');
                $('#five').parent().show();
                $('#last').parent().show();
            }
            else if(nowpage>=5){
                //alert("已经不是第五页了");
                //设置中间的为当前页
                $('#one').text(Number(nowpage)-2);
                $('#one').attr('href','javascript:pagenum("'+(Number(nowpage)-2)+'");');
                $('#two').text(Number(nowpage)-1);
                $('#two').attr('href','javascript:pagenum("'+(Number(nowpage)-1)+'");');
                $('#three').text(nowpage);
                $('#three').attr('href','javascript:pagenum("'+(nowpage)+'");');
                $('#five').parent().show();
                $('#last').parent().show();
                //判断下一页是否超过了总页数
                if(Number(nowpage)+1>pading){
                    $('#five').parent().hide();
                    $('#last').parent().hide();
                }else{
                    $('#five').parent().show();
                    $('#five').text(Number(nowpage)+1);
                    $('#five').attr('href','javascript:pagenum("'+(Number(nowpage)+1)+'");');
                }
                //判断下一页的第二页是否超过了总页数
                if(Number(nowpage)+2>pading){
                    $('#last').parent().hide();
                }else{
                    $('#last').parent().show();
                    $('#last').text(Number(nowpage)+2);
                    $('#last').attr('href','javascript:pagenum("'+(Number(nowpage)+2)+'");');
                }
            }
        }
        //点击页数
        function pagenum(pagenow){

            if(pagenow==0){
                pagenow=pading
            }
            $("#pagenumnow").val(pagenow); //将当前页数存到他妈的Input 隐藏框里
            changepageindex(pagenow);
            activethispage(pagenow);
            getajax(pagenow);
        }
        //点击上一页
        function goback(){
            var temppage=$("#pagenumnow").val();

            if(temppage<=1){
                temppage=1
            }
            else{
                temppage=temppage-1;
            }
            $("#pagenumnow").val(temppage);
            changepageindex(temppage);
            activethispage(temppage);
            getajax(temppage);
        }
        //点击下一页
        function gonext(){
            var temppage=$("#pagenumnow").val();
            if(temppage>=pading){
                temppage=pading
            }
            else{
                temppage=Number(temppage)+1;
            }
            $("#pagenumnow").val(temppage);
            changepageindex(temppage);
            activethispage(temppage);
            getajax(temppage);
        }
        //输入页数进行跳转
        function jumpToPage(pagenum){
            changepageindex(pagenum);
            activethispage(pagenum);
            getajax(pagenum);
            $("#pagenumnow").val(pagenum);
        }
        //当前页数高亮
        function activethispage(pagenum){
            $("#page li").removeClass();
            $("#page li a").each(function(){
                if($(this).text()==pagenum){
                    $(this).parent().addClass('active')
                }
            })

        }
        /*function newwindow(){
            window.open ('/admin/social_securities/detail', 'newwindow', 'height=800, width=800, top=400, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no')
        }*/

    </script>
<script>

    mui.init();
    mui.previewImage();
    mui('body').on('tap', 'a', function () {
        location.href = this.getAttribute('href');
    });

</script>

@endsection