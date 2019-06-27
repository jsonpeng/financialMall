<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--title>会员系统</title-->
	@yield('title')
    {{-- <link href="https://cdn.bootcss.com/Swiper/4.0.7/css/swiper.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('vendor/swiper4.2.6/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/weui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    
    <style type="text/css">
        .weui-tabbar{max-width: 640px;}

        ::-webkit-scrollbar{
        display:none;
        }

        html, body{
            background-color: #fff;
        }
    </style>

    @yield('css')
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">你正在使用<strong>过时的</strong> 浏览器. 请 <a href="http://browsehappy.com/">更新你的浏览器</a> 以提升您的上网体验.</p>
<![endif]-->
<div style="padding-bottom: 50px;" id="container">
    @yield('content')

    <!--BEGIN toast-->
    <div id="toast" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content" id="toast-info">支付成功</p>
        </div>
    </div>
    <div id="dialogs">

        <div class="js_dialog" id="g_iosDialog1" style="display: none;">
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__bd" id="g_iosDialog1_text">此功能只有VIP用户才享有</div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn">关闭</a>
                    <a href="/member_buy_v2" class="weui-dialog__btn weui-dialog__btn_primary">立即开通</a>
                </div>
            </div>
        </div>

        <div class="js_dialog" id="g_iosDialog2" style="display: none;">
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__bd" id="g_iosDialog2_text"></div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<script src="{{ asset('js/jquery1.12.4.min.js') }}"></script>
{{-- <script src="https://cdn.bootcss.com/Swiper/4.0.7/js/swiper.min.js"></script> --}}
<script src="{{ asset('js/infinite-scroll.pkgd.min.js') }}"></script>
<script src="{{ asset('vendor/swiper4.2.6/js/swiper.min.js') }}"></script>
<script src="{{ asset('js/jweixin-1.0.0.js') }}"></script>
<script src="{{ asset('js/front.js') }}"></script>

@yield('js')

<script type="text/javascript">
    $('#dialogs').on('click', '.weui-dialog__btn', function(){
        $(this).parents('.js_dialog').fadeOut(200);
    });

    $('.scroll-container').infiniteScroll({
        // options
        path: "a[rel='next']",
        append: '.scroll-post',
        history: false,
        scrollThreshold: 400
    });

    function closeMemIntro() {
        $('#mem_intro').hide();
    }

    function openMemIntro() {
        $('#mem_intro').show();
    }
</script>

</html>