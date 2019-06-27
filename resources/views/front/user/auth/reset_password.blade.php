@extends('front.base')

@section('css')
	<style type="text/css">
        .register{float: left; margin-left: 30px;}
        a{color: #333;}
	</style>
@endsection

@section('title')
	<title>重置密码</title>
@endsection

@section('content')
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($hkj_banners as $hkj_banner)
                <a class="swiper-slide" href="{{ $hkj_banner->link }}">
                    <img src="{{ $hkj_banner->image }}" alt="" class="swiper-lazy">
                    <div class="swiper-lazy-preloader"></div>
                </a>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
   
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">请输入新密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password" placeholder="" name="password" />
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">再次输入新密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password" placeholder="" name="confirm_password" />
            </div>
        </div>
    </div>
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips"  onclick="register()">确定</a>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        function register() {

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
                url: '/post_reset_password',
                type: 'POST',
                data: {password: $('input[name=password]').val(), confirm_password: $('input[name=confirm_password]').val()},
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        window.location.href = "/user_center";
                    } else {
                        $('#g_iosDialog2_text').text(data.message);
                        $('#g_iosDialog2').fadeIn(200);
                    }                   
                },
            });

        }

       

    </script>
@endsection