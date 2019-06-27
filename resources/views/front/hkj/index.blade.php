@extends('front.base')

@section('css')
    <style type="text/css">
        .huiyuan-meta{
            color: #fff;
            text-align: center; padding: 1px 5px; margin-right: 5px;
            border-radius: 3px;
        }

        .hkj_level1{
            background: -webkit-linear-gradient(270deg, #08AEEA 0%, #2AF598 100%);; /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(270deg, #08AEEA 0%, #2AF598 100%);; /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(270deg, #08AEEA 0%, #2AF598 100%);; /* Firefox 3.6 - 15 */
            background: linear-gradient(270deg, #08AEEA 0%, #2AF598 100%);; /* 标准的语法（必须放在最后） */
        }

        .hkj_level2{
            background: -webkit-linear-gradient(90deg, #FBAB7E 0%, #F7CE68 100%); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(90deg, #FBAB7E 0%, #F7CE68 100%); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(90deg, #FBAB7E 0%, #F7CE68 100%); /* Firefox 3.6 - 15 */
            background: linear-gradient(90deg, #FBAB7E 0%, #F7CE68 100%); /* 标准的语法（必须放在最后） */
        }

        .hkj_level3{
            background: -webkit-linear-gradient(left, rgb(148,86,225), rgb(224,83,169)); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(right, rgb(148,86,225), rgb(224,83,169)); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(right, rgb(148,86,225), rgb(224,83,169)); /* Firefox 3.6 - 15 */
            background: linear-gradient(to right, rgb(148,86,225), rgb(224,83,169)); /* 标准的语法（必须放在最后） */
        }
    </style>
@endsection

@section('title')
    <title>科技</title>
@endsection

@section('content')
    <div class="header">
        <a href="/learn" class="go_return">返回</a><p>VIP课程</p>
    </div>
    <!-- Slider main container -->
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

    <div class="weui-tab" style="height: 40px;">
        <div class="weui-navbar">
            @foreach($hkjCats as $element)
            <a href="/hkj?cat={{ $element->id }}" class="weui-navbar__item @if($cat == $element->id) weui-bar__item_on @endif">
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
                        @if( !empty($hkj->level_name) )
                          <li class="weui-media-box__info__meta huiyuan-meta hkj_level{{$hkj->level}}">{{$hkj->level_name}}</li>
                        @endif
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
    
    <script type="text/javascript">
        $('.scroll-container').infiniteScroll({
          // options
          path: "a[rel='next']",
          append: '.scroll-post',
          history: false,
        });
    </script>
    
@endsection

