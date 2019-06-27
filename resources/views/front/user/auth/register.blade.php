@extends('front.base')

@section('css')
	<style type="text/css">
        .register{float: left; margin-left: 30px;}
        a{color: #333;}
        .weui-vcode-btn{font-size: 15px;}
        a{
            color: #fcb02b;
        }
	</style>
@endsection

@section('title')
	<title>绑定手机号</title>
@endsection

@section('content')
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
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
                    <input class="weui-input" type="tel" placeholder="请输入手机号" id="tel"/>
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
        </div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" onclick="submit()">下一步</a>
        </div>
    </div>
    <div id="step2" style="display: none;">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">昵称</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="昵称" id="nickname"  name="nickname" maxlength="10" />
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请填写真实姓名,不可更改" id="name"  name="name" maxlength="6" />
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">登录密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" placeholder="" name="password" />
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">确认登录密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" placeholder="" name="confirm_password" />
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">推荐码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="推荐码" id="tuijianma"  name="tuijianma" maxlength="10" />
                </div>
            </div>

            <div style="padding: 15px; padding-top: 0;"><label><input name="law" type="checkbox" value="" id="btnCheckReverse" />同意  <a href="/law">《用户购买协议》</a> </label> </div>

        </div>
        <div class="weui-btn-area">
            <button class="weui-btn weui-btn_primary weui-btn_disabled" href="javascript:" id="buy_button"  onclick="register()" disabled="disabled">提交</button>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">

        var invitor = 0;
        if (localStorage.zcjy_kadaren_invitor) {
            //invitor = localStorage.zcjy_kadaren_invitor;
            $('#tuijianma').val(localStorage.zcjy_kadaren_invitor);
        }

        $("#btnCheckReverse").change(function() { 
            if ($("#btnCheckReverse").is(':checked')) {
                $('#buy_button').removeAttr("disabled"); 
                $('#buy_button').removeClass("weui-btn_disabled"); 
            }else{
                $('#buy_button').attr("disabled",true); 
                $('#buy_button').addClass("weui-btn_disabled"); 
            }
        });

        // var invitor = 0;
        // if (localStorage.zcjy_kadaren_invitor) {
        //     invitor = localStorage.zcjy_kadaren_invitor;
        //     alert(localStorage.zcjy_kadaren_invitor);
        // }
        // alert(invitor);

        function register() {
            if ( $('input[name=nickname]').val() == '' ) {
                $('#g_iosDialog2_text').text('请输入昵称！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

            if ( $('input[name=tuijianma]').val() == '' ) {
                $('#g_iosDialog2_text').text('请输入推荐码！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

            if ( $('input[name=password]').val().length < 6 ) {
                $('#g_iosDialog2_text').text('密码最少需要输入6位密码');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

            if ( $('input[name=password]').val() != $('input[name=confirm_password]').val() ) {
                $('#g_iosDialog2_text').text('两次密码输入不一致, 请重新输入');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

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
                        window.location.href = "/";
                    } else {
                        $('#g_iosDialog2_text').text(data.message);
                        $('#g_iosDialog2').fadeIn(200);
                    }                   
                },
            });

        }

        function sendCode() {

            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(14[0-9]{1})|(16[0-9]{1})|(19[0-9]{1}))+\d{8})$/; 
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
            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(14[0-9]{1})|(16[0-9]{1})|(19[0-9]{1}))+\d{8})$/; 
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
                        //window.location.href = "/member";
                        $('#step1').hide();
                        $('#step2').show();
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