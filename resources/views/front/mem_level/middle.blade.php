@extends('front.base')

@section('css')
    <style type="text/css">
        .kecheng-type{
            background-color: #0e83f0;
            color: #fff;
            padding: 2px;
            border-radius: 3px;
        }
    </style>
@endsection

@section('title')
    <title>中级会员</title>
@endsection

@section('content')
    <div class="header">
        <a href="/learn" class="go_return">返回</a><p>课程</p>
    </div>
    
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

    <div class="weui-tab" style="height: 40px; margin-top: 10px;">
        <div class="weui-navbar">
            <a href="/middle_level?type=语音" class="weui-navbar__item @if($type == '语音') weui-bar__item_on @endif">
                语音教程
            </a>
            <a href="/middle_level?type=视频" class="weui-navbar__item @if($type == '视频') weui-bar__item_on @endif">
                视频教程
            </a>
        </div>
    </div>

    <div class="weui-panel__bd scroll-container">
        @foreach ($elements as $element)
            <a href="/kecheng_detail/{{ $element->id }}" class="weui-media-box weui-media-box_appmsg scroll-post">
                @if(!empty($element->image))
                    <div class="weui-media-box__hd hkj">
                        <img class="weui-media-box__thumb" src="{{$element->image}}" alt="">
                    </div>
                @endif
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title hkj">{{$element->title}}</h4>
                    <p class="weui-media-box__desc">{{$element->des}}</p>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta kecheng-type">{{$type}}课程</li>
                        <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">{{$element->created_at->diffForHumans()}}</li>
                    </ul>
                </div>
            </a>
        @endforeach
    </div>
    <div style="opacity: 0;position: fixed;">{{$elements->links()}}</div>
    
    @include('front.bottom-bar', ['index' => 2])
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

