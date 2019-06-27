@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-media-box_half{width: 50%; box-sizing: border-box; float: left;}
        .weui-media-box_half .weui-media-box__desc{-webkit-line-clamp: 2; line-clamp: 2; color: #999;}
        .weui-media-box__titl{font-size: 15px;}
    </style>
@endsection

@section('title')
    <title>学习</title>
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
    
    <div class="header-title" style="padding: 5px 15px;">我的服务</div>
    <div class="weui-panel__bd" style="overflow: hidden;">
        <a href="/hkj" class="weui-media-box weui-media-box_appmsg weui-media-box_half">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="{{ asset('images/share_theme/mem_level/1.jpg') }}" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">VIP会员</h4>
                <p class="weui-media-box__desc">优质口子信息</p>
            </div>
        </a>
        <a href="/middle_level" class="weui-media-box weui-media-box_appmsg weui-media-box_half">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="{{ asset('images/share_theme/mem_level/2.jpg') }}" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">中级会员</h4>
                <p class="weui-media-box__desc">独家线上课程教学</p>
            </div>
        </a>
        <a href="/high_level" class="weui-media-box weui-media-box_appmsg weui-media-box_half">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="{{ asset('images/share_theme/mem_level/3.jpg') }}" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">高级会员</h4>
                <p class="weui-media-box__desc">高级产品精讲</p>
            </div>
        </a>
        <a href="/super_level" class="weui-media-box weui-media-box_appmsg weui-media-box_half">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="{{ asset('images/share_theme/mem_level/4.jpg') }}" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title">特级会员</h4>
                <p class="weui-media-box__desc">一对一线下培训</p>
            </div>
        </a>
    </div>

    <div class="weui-tab" style="height: 40px; margin-top: 10px;">
        <div class="weui-navbar">
            {{-- <a href="/hkj" class="weui-navbar__item @if(empty($cat)) weui-bar__item_on @endif ">
                最新口子
            </a> --}}
            @foreach($hkjCats as $element)
            <a href="/learn?cat={{ $element->id }}" class="weui-navbar__item @if($cat == $element->id) weui-bar__item_on @endif">
                {{ $element->name }}
            </a>
            @endforeach
        </div>
    </div>


    <div class="weui-panel__bd scroll-container">
        @foreach ($hkjs as $hkj)
            <a href="/hkj_detail/{{ $hkj->id }}" class="weui-media-box weui-media-box_appmsg scroll-post">
                @if(!empty($hkj->image))
                    <div class="weui-media-box__hd hkj">
                        <img class="weui-media-box__thumb" src="{{$hkj->image}}" alt="">
                    </div>
                @endif
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title hkj">{{$hkj->name}}</h4>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">{{$hkj->created_at->diffForHumans()}}</li>
                        <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">{{$hkj->view}}人在看</li>
                    </ul>
                </div>
            </a>
        @endforeach
    </div>
    <div style="opacity: 0;position: fixed;">{{$hkjs->links()}}</div>
    
    @include('front.bottom-bar', ['index' => 2])
@endsection


@section('js')

    
@endsection

