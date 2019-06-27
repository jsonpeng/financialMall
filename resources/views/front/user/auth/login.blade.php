@extends('front.base')

@section('css')
	<style type="text/css">
        .register{float: left; margin-left: 15px;}
        .find{float: right; margin-right: 15px;}
        a{color: #333;}
        .help-block{
            font-weight: normal;
            padding: 15px;
            color: red;
        }
	</style>
@endsection

@section('title')
	<title>用户登录</title>
@endsection

@section('content')
    <form action="/login" method="POST">
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach ($banners as $banner)
                    <a class="swiper-slide" href="{{ $banner->link }}">
                        <img src="{{ $banner->image }}" alt="" class="swiper-lazy">
                        <div class="swiper-lazy-preloader"></div>
                    </a>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        {!! csrf_field() !!}
        
        <div class="weui-cells weui-cells_form" style="margin-top: 0;">
            <div>
            @if ($errors->has('mobile'))
                <span class="help-block">
                    {{ $errors->first('mobile') }}
                </span>
             @endif
            </div>
            <div class="weui-cell">

                <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" placeholder="请输入手机号" id="mobile"  name="mobile"/>
                </div>
            </div>
            <div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                 @endif
            </div>
            <div class="weui-cell">
                
                <div class="weui-cell__hd"><label class="weui-label">登录密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" placeholder="" name="password" />
                </div>
            </div>
            
        </div>
        <div class="weui-btn-area">
            <input class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips" type="submit"/>
        </div>
    </form>
    <div style="overflow: hidden; margin-top: 15px;">
        <a class="register" href="/register">注册</a>
        <a class="find" href="/find_password">找回密码</a>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        
    </script>
@endsection