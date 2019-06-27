@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{
            width: 20%;
            padding: 5px;
        }
        .weui-grids{margin: 15px 0;}
        .swiper-container{max-height: 320px;}

        .txtScroll-top{ overflow:hidden; position:relative;  border:1px solid #eee; }
        .txtScroll-top .bd{ padding:10px 15px;  padding-left: 90px; background-image: url('{{ asset('images/laba.png') }}');background-position: 15px center; background-repeat: no-repeat; background-size: 70px;}
        .txtScroll-top .infoList li{ height:24px; line-height:24px; font-size: 14px;  }
        .txtScroll-top .infoList li .date{ float:right; color:#999; font-size: 12px; }

        .weui-media-box_half{width: 50%; box-sizing: border-box; float: left;}
        .weui-media-box_half .weui-media-box__desc{-webkit-line-clamp: 2; line-clamp: 2; color: #999;}
        .weui-media-box__titl{font-size: 15px;}

        .tool{width: 50%; padding: 5px; box-sizing: border-box; display: block; float: left;}
        .weui-media-box__desc{font-size: 12px;}
        
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
    <title>首页</title>
@endsection

@section('content')
    <!-- Slider main container -->
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($banners as $element)
                <a class="swiper-slide" href="{{ $element->link }}">
                    <img src="{{ $element->image }}" alt="" class="swiper-lazy">
                    <div class="swiper-lazy-preloader"></div>
                </a>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="weui-grids" style="margin-top: 0; margin-bottom: 0; padding: 10px 0;">
        <a href="/tools" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/share_theme/index/1.png') }}" alt="">
            </div>
            <p class="weui-grid__label">融资工具</p>
        </a>
        <a href="/all_level" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/share_theme/index/2.png') }}" alt="">
            </div>
            <p class="weui-grid__label">在线课程</p>
        </a>
        <a href="/lives" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/share_theme/index/3.png') }}" alt="">
            </div>
            <p class="weui-grid__label">直播间</p>
        </a>
        <a href="/share_dks" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/share_theme/index/4.png') }}" alt="">
            </div>
            <p class="weui-grid__label">我要赚钱</p>
        </a>
        <a href="{{ $setting->chat_link }}" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/share_theme/index/5.png') }}" alt="">
            </div>
            <p class="weui-grid__label">在线客服</p>
        </a>
        
    </div>

    @if ($notices->count())
        <div class="txtScroll-top">
            <div class="bd">
                <ul class="infoList">
                    @foreach ($notices as $element)
                        <li><span class="date">{{ $element->created_at->format('Y-m-d') }}</span><a href="/notice/{{ $element->id }}" target="_blank">{{ $element->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    

    @if (!empty($notice_pop) && $needPopUp)
        <style type="text/css">
            #popup-notice{
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                right: 0;
                background-color: rgba(0,0,0,0.3);
                z-index: 999;
                border-radius: 10px;
            }

            .outer-wrapper{
                position: absolute;
                top: 30px;
                bottom: 30px;
                left: 20px;
                right: 20px;
                background-color: #fff;
            }

            .header{
                height: 50px;
                text-align: center;
                line-height: 50px;
                font-size: 18px;
            }

            .header img{
                position: absolute; right: 15px; top: 15px; height: 20px; width: auto;
            }

            .inner-wrapper{
                position: absolute;
                top: 50px;
                bottom: 0px;
                left: 0px;
                right: 0px;
                background-color: #fff;
                overflow-y: auto;
                font-size: 14px;
                padding: 15px;
                line-height: 28px;
            }
            .inner-wrapper img{max-width: 100%; height: auto;}

        </style>

        <div id="popup-notice">
            <div class="outer-wrapper">
                <div class="header">
                    公&nbsp;&nbsp;&nbsp;&nbsp;告
                    <img src="{{ asset('images/share_theme/index/x.png') }}" alt="" onclick="closePopNotice()">
                </div>
                <div class="inner-wrapper">
                    <h3>{!! $notice_pop->name !!}</h3>
                    {!! $notice_pop->intro !!}
                </div>
            </div>
        </div>
    @endif
    
    <div class="header-title" style="padding: 5px 15px;">我的服务</div>
    <div class="weui-panel__bd" style="overflow: hidden;">
        <a href="/hkj" class="weui-media-box weui-media-box_appmsg weui-media-box_half">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="{{ asset('images/share_theme/mem_level/1.jpg') }}" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title hkj">百万金融和科技</h4>
            </div>
        </a>
        <a href="/all_level" class="weui-media-box weui-media-box_appmsg weui-media-box_half">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="{{ asset('images/share_theme/mem_level/2.jpg') }}" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title hkj">音频视频权威课程</h4>
            </div>
        </a>
    </div>

    <div class="weui-tab" style="height: 40px; margin-top: 10px;">
        <div class="weui-navbar">
            {{-- <a href="/hkj" class="weui-navbar__item @if(empty($cat)) weui-bar__item_on @endif ">
                最新口子
            </a> --}}
            @foreach($hkjCats as $element)
            <a href="/?cat={{ $element->id }}" class="weui-navbar__item @if($cat == $element->id) weui-bar__item_on @endif">
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
    
    @include('front.bottom-bar', ['index' => 1])
@endsection


@section('js')
    <script src="{{ asset('js/jquery.SuperSlide.2.1.1.js') }}"></script>
    <script type="text/javascript">

        jQuery(".txtScroll-top").slide( { titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:'top',autoPlay:true,scroll:1,vis:1,easing:'swing',delayTime:500,pnLoop:true,trigger:'mouseover',mouseOverStop:true });
    
         function GetQueryString(name) {
           var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
           var r = window.location.search.substr(1).match(reg);
           if (r!=null) return unescape(r[2]); 
           return null;
        }

        var invitor = GetQueryString('invitor');

        if (invitor) {
            localStorage.zcjy_kadaren_invitor = invitor;
        }

        $('.scroll-container').infiniteScroll({
          // options
          path: "a[rel='next']",
          append: '.scroll-post',
          history: false,
        });

        function closePopNotice() {
            $('#popup-notice').hide();
        }
    </script>
    
@endsection

