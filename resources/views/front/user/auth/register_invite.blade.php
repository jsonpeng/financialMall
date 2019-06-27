@extends('front.base')

@section('css')
    <style type="text/css">
           *{
                margin:0;
                padding:0;
            }
            html,body{
                height: 100%;
                background-color:#fff;
                color:#333;
            }
            .weui-cell{
                padding:10px 15px;
                display: flex;
            }
            .weui-cell__bd{
                flex:1;
            }
            .login_box{

            }
            input{
                border:0;
                outline: 0;
            }
            .head_img img{width:100%;}
            .input_label{
                font-size:13px;
            }
            .input_box{
                font-size:13px;
                height: 40px;
                line-height: 40px;
                border-bottom: 1px solid #efefef;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            #tel{
                padding-left: 10px;
                margin-left: 10px;
                border-left:2px solid #efefef;
                flex:1;
            }
            .submitBtn{
                background-color:#f1d0b1;
                height:45px;
                line-height: 45px;
                text-align: center;
                color: #79482c;
                font-size: 15px;
                margin-bottom: 10px;
            }
            .down_link{
                display:flex;
                justify-content: space-between;
            }
            .down_link .item{
                display: flex;
                font-size: 11px;
                align-items: center;

            }
            .icon_warp{
                width:22.5px;
                height:22.5px;
                margin-right:5px;
            }
            .icon_warp img{
                display: block;
                width:100%;
            }
            .eye{
                display: inline-block;
                width:19px;
            }
            img{
                display:block;
                width:100%;
            }
            .getCode{
                font-size: 12px;
                color:#cacbcc;
                height: 30px;
                line-height: 30px;
                padding:0 10px;
                border-radius:15px;
                border:1px solid #cacbcc;
                text-decoration: none;
            }
    </style>
@endsection

@section('title')
    <title>用户注册</title>
@endsection

@section('content')

<div class="content weui-cell">
            <div class="login_box">
                <form>
                    <div class="head">
                        <div class="head_img">
                            <img src="{{ asset('img/launch.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="login_body weui-cell">
                        <div class="weui-cell__bd">
                            <div class="input_label">昵称</div>
                            <div class="input_box"><input type="text" id="nickname" name="nickname" placeholder="请输入昵称"> {{-- <div class="eye"><img src="{{ asset('img/eye.png') }}" alt=""></div> --}}</div>
                            <div class="input_label">手机号</div>
                            <div class="input_box">+86<input type="number" name=mobile placeholder="请输入手机号" id="tel"></div>
                            <div class="input_label">手机验证码</div>
                            <div class="input_box"><input type="number" name="code" id="code" placeholder="请输入验证码"><div class="eye"><img src="{{ asset('img/close.png') }}" alt=""></div><a href="javascript:;" id="getcode" onclick="sendCode()" class="getCode" data-click="true">获取验证码</a></div>
                            <div class="input_label">密码</div>
                            <div class="input_box"><input type="password" name="password" placeholder="请输入密码"> <div class="eye"><img src="{{ asset('img/eye.png') }}" alt=""></div></div>
                            <div class="input_label">确认密码</div>
                            <div class="input_box"><input type="password" name="confirm_password" placeholder="请输入确认密码"> <div class="eye"><img src="{{ asset('img/eye.png') }}" alt=""></div></div>
                      
                            <div class="input_label">推荐码</div>
                            <div class="input_box"><input type="text" readonly="readonly"  name="tuijianma" id="tuijianma" placeholder="请输入推荐码" value="{!! $invitor !!}"></div>
                        </div>
                    </div>
                    <div class="login_bottom weui-cell resetPwd">
                        <div class="weui-cell__bd">
                            <div class="submitBtn" onclick="register()">注册</div>
                            <div class="down_link">
                                <a class="item" href="{!! getSettingValueByKey('android_link')!!}"><div class="icon_warp"><img src="{{ asset('img/t1.png') }}" alt=""></div>安卓下载</a>
                                <a class="item" href="{!! getSettingValueByKey('ios_link')!!}"><div class="icon_warp"><img src="{{ asset('img/t2.png') }}" alt=""></div>IOS下载</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
</div>

{{--     <div class="swiper-container">
     
        <div class="swiper-wrapper">
      
            @foreach ($banners as $element)
                <a class="swiper-slide" href="{{ $element->link }}">
                    <img src="{{ $element->image }}" alt="" class="swiper-lazy">
                    <div class="swiper-lazy-preloader"></div>
                </a>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div id="step1">
        <div class="weui-cells weui-cells_form" style="margin-top: 0;">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="mobile" placeholder="请输入手机号" id="tel"/>
                </div>
            </div>
            <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd">
                    <label class="weui-label">验证码</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入验证码" id="code"/>
                </div>
                <div class="weui-cell__ft">
                    <button class="weui-vcode-btn" id="getcode" onclick="sendCode()">获取验证码</button>
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">昵称</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="nickname" placeholder="昵称" id="nickname"  name="nickname" maxlength="10" />
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请填写真实姓名" id="name"  name="name" maxlength="6" />
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">登录密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" placeholder="请输入密码(6位以上)" name="password" />
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">确认登录密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" placeholder="确认密码" name="confirm_password" />
                </div>
            </div>
            
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">推荐码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="" name="tuijianma" id="tuijianma" value="" readonly="readonly" />
                </div>
            </div>
        </div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips"  onclick="submit()">确定</a>
        </div>
    </div>

    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" @if (Config::get('zcjy.OPEN_SHARE')) href="/app_download" @else href="{!! $setting->apk_link !!}" @endif id="showTooltips" >已注册，前往下载APP</a>
    </div> --}}
@endsection

@section('js')
    <script type="text/javascript">

        var invitor = '20140617';

        function GetQueryString(name) {
           var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
           var r = window.location.search.substr(1).match(reg);
           if (r!=null) return unescape(r[2]); 
           return null;
        }

        // var invitor = GetQueryString('invitor');

        // $('#tuijianma').val(invitor);


        function register() {
            // if ( $('input[name=nickname]').val() == '' ) {
            //     $('#g_iosDialog2_text').text('请输入昵称！');
            //     $('#g_iosDialog2').fadeIn(200);
            //     return false; 
            // }

            if ( $('input[name=password]').val().length < 6 ) {
                $('#g_iosDialog2_text').text('密码最少需要输入6位密码');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

            // if ( $('input[name=password]').val() != $('input[name=confirm_password]').val() ) {
            //     $('#g_iosDialog2_text').text('两次密码输入不一致, 请重新输入');
            //     $('#g_iosDialog2').fadeIn(200);
            //     return false; 
            // }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/post_register',
                type: 'POST',
                data: {nickname: $('input[name=nickname]').val(), password: $('input[name=password]').val(), confirm_password: $('input[name=confirm_password]').val(), invitor: $('#tuijianma').val(), mobile: $('#tel').val(), code: $('#code').val(), name: $('#name').val()},
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        $('#g_iosDialog2_text').text('注册成功');
                        $('#g_iosDialog2').fadeIn(200);
                        setTimeout(function(){
                            window.location.href = "{!! url('app_download') !!}";
                        }, 2000);
                        
                    } else {
                        $('#g_iosDialog2_text').text(data.message);
                        $('#g_iosDialog2').fadeIn(200);
                    }                   
                },
            });

        }

        function sendCode() {

            var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/; 
            if(!myreg.test($("#tel").val())) 
            { 
                //alert('请输入有效的手机号码！'); 
                $('#g_iosDialog2_text').text('请输入有效的手机号码！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            } 

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/sendCode',
                type: 'GET',
                data: {mobile: $('#tel').val()},
            });

            time();
        }

        function submit() {
            var myreg = /^1[23456789]{1}\d{9}$/; 

            if(!myreg.test($("#tel").val())) 
            { 
                //alert('请输入有效的手机号码！'); 
                $('#g_iosDialog2_text').text('请输入有效的手机号码！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            } 
            if ($("#code").val() == '' || $("#code").val().length != 4) {
                $('#g_iosDialog2_text').text('请输入有效验证码！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/post_mobile',
                type: 'POST',
                data: {mobile: $('#tel').val(), code: $('#code').val()},
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        register();
                    } else {
                        $('#g_iosDialog2_text').text('手机或验证码输入不正确');
                        $('#g_iosDialog2').fadeIn(200);
                        //alert('输入信息不正确');
                    }                   
                },
            });
        }

        var wait=60;
        function time() {
            o = $('#getcode');
            if (wait == 0) {
                o.removeAttr("disabled");   
                o.text("获取验证码");
                wait = 60;
            } else { 

                o.attr("disabled", true);
                o.text("重新发送(" + wait + ")");
                wait--;
                setTimeout(function() {
                    time()
                }, 1000)
            }
        }

    </script>
@endsection
