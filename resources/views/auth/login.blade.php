@extends('front.base')

@section('css')
    <style type="text/css">

    </style>
@endsection

@section('title')
    <title>绑定手机号</title>
@endsection

@section('content')
    <form method="POST" action="login">
        {!! csrf_field() !!}
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

        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="mobile" placeholder="请输入手机号" name="mobile"/>
                </div>
            </div>
            
            @if ($errors->has('mobile'))
            <div class="weui-cell">
                {{ $errors->first('mobile') }}
            </span>
            @endif
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">登录密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" placeholder="请输入手机号" name="password"/>
                </div>
                <div class="weui-cell">
                    @if ($errors->has('password'))
                        {{ $errors->first('password') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="weui-btn-area">
            <input class="weui-btn weui-btn_primary"  id="showTooltips" value="登录" type="submit"></input>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        
    </script>
@endsection