@extends('front.base')

@section('css')
    <style type="text/css">
        
    </style>
@endsection

@section('title')
    <title>直播</title>
@endsection

@section('content')
    <div class="swiper-container">
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

    <div class="weui-panel__bd scroll-container">
        @foreach ($lives as $element)
            <a href="/live/{{ $element->id }}" class="weui-media-box weui-media-box_appmsg scroll-post">
                @if(!empty($element->image))
                    <div class="weui-media-box__hd hkj">
                        <img class="weui-media-box__thumb" src="{{$element->image}}" alt="">
                    </div>
                @endif
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title hkj">{{$element->name}}</h4>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">直播开始时间：{{$element->time}}</li>
                    </ul>
                </div>
            </a>
        @endforeach
    </div>
    
    @include('front.bottom-bar', ['index' => 3])
@endsection


@section('js')
    
    <script type="text/javascript">
        $('.scroll-container').infiniteScroll({
          // options
          path: "a[rel='next']",
          append: '.scroll-post',
          history: false,
        });
    </script>
    
@endsection

