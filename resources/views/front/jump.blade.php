@extends('front.base')

@section('css')

@endsection

@section('title')
    <title>进入公众号使用全功能版</title>
@endsection

@section('content')
    <div class="swiper-container">
        <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('images/banner-index.jpg') }}" alt="" class="swiper-lazy">
                    <div class="swiper-lazy-preloader"></div>
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('images/mobile-banner.jpg') }}" alt="" class="swiper-lazy">
                    <div class="swiper-lazy-preloader"></div>
                </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div style="text-align: center; padding-top: 30px;">
        <img src="{{ asset('images/xiaoka-jump.png') }}" style="width: 33.3%;">
        <div style="text-align: center;">功能受限，请使用<span style="color: red;">微信扫描二维码</span>就可解锁全部功能哦</div>
        <div style="margin-top: 20px;">或者添加微信公账号</br> <span style="color: red; font-size: 26px; font-weight: bold;">cardmember</span> </br>(长按复制)解锁全部功能</div>
    </div>
    <div>
        
    </div>
@endsection


@section('js')
    <script type="text/javascript">
       
    </script>
    
@endsection

