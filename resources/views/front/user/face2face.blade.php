@extends('front.base')

@section('css')
	<style type="text/css">
        .register{float: left; margin-left: 15px;}
        a{color: #333;}
        .weui-vcode-btn{font-size: 15px;}
	</style>
@endsection

@section('title')
	<title>面对面开通账号</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>面对面开通</p>
    </div>

    <div id="step1">
        <div class="weui-cells weui-cells_form">
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
                    <input class="weui-input" type="name" placeholder="请填写真实姓名，不可更改" id="name"  name="name" maxlength="10" />
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
                    <input class="weui-input" type="text" placeholder="" name="share_code" value="{{ $user->share_code }}" readonly="readonly" />
                </div>
            </div>
        </div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips"  onclick="submit()">确定</a>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">

        function register() {
            if ( $('input[name=nickname]').val() == '' ) {
                $('#g_iosDialog2_text').text('请输入昵称！');
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
                data: {nickname: $('input[name=nickname]').val(), password: $('input[name=password]').val(), confirm_password: $('input[name=confirm_password]').val(), invitor: $('input[name=share_code]').val(), mobile: $('#tel').val(), code: $('#code').val()},
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        $('#g_iosDialog2_text').text('账号开通成功');
                        $('#g_iosDialog2').fadeIn(200);
                    } else {
                        $('#g_iosDialog2_text').text(data.message);
                        $('#g_iosDialog2').fadeIn(200);
                    }                   
                },
            });

        }

        function sendCode() {

            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
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