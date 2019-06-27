@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{
            width: 25%;
            padding: 10px 10px 10px 10px;
        }
        .weui-grids{margin: 15px 0;}
        .swiper-container{max-height: 320px;}
        a.weui-actionsheet__cell{display: block;}
    </style>
@endsection

@section('title')
    <title>平台</title>
@endsection

@section('content')

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

    <div class="weui-grids" style="margin-top: 0; margin-bottom: 0;">
        @foreach ($postCats as $postCat)
            <a href="/dk/list/0/{{ $postCat->id }}" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset($postCat->image) }}" alt="">
                </div>
                <p class="weui-grid__label">{{$postCat->name}}</p>
            </a>
        @endforeach
    </div>
    
    <div class="weui-panel__bd" style="display: flex; border-top: 5px solid #efefef; border-bottom: 5px solid #efefef;">
      <div class="weui-media-box weui-media-box_appmsg" style="padding: 10px 5px; flex: 1; padding-left: 15px; border-left: 1px solid #eee;" id="showIOSActionSheet">
          <div class="weui-media-box__hd" style="height: 45px; width: 45px;">
              <img class="weui-media-box__thumb" src="{{ asset('images/edu.jpg') }}" alt="" style="height: 45px; width: auto;">
          </div>
          <div class="weui-media-box__bd">
              <h4 class="weui-media-box__title">额度筛选</h4>
              <p class="weui-media-box__desc">按额度筛选口子</p>
          </div>
      </div>
      <a class="weui-media-box weui-media-box_appmsg" style="padding: 10px 5px; flex: 1; padding-left: 15px;" href="/tools">
          <div class="weui-media-box__hd" style="height: 45px; width: 45px;">
              <img class="weui-media-box__thumb" src="{{ asset('images/gongju.jpg') }}" alt="" style="height: 45px; width: auto;">
          </div>
          <div class="weui-media-box__bd">
              <h4 class="weui-media-box__title">实用工具</h4>
              <p class="weui-media-box__desc">便捷查询工具</p>
          </div>
      </a>
    </div>

    <div class="weui-tab" style="height: 40px;">
        <div class="weui-navbar">
            <a href="/dk" class="weui-navbar__item @if(empty($type)) weui-bar__item_on @endif ">
                最新口子
            </a>
            <a href="/dk?type=hot" class="weui-navbar__item @if($type == 'hot') weui-bar__item_on @endif ">
                热门口子
            </a>
            <a href="/dk?type=recommend" class="weui-navbar__item @if($type == 'recommend') weui-bar__item_on @endif ">
                推荐口子
            </a>
        </div>
    </div>

    <div class="weui-panel__bd scroll-container">
        @foreach ($dks as $dk)
            <a href="@if(auth('web')->check()) {{$dk->link}} @else /login @endif"  class="weui-media-box weui-media-box_appmsg dk scroll-post">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="{{$dk->image}}" alt="">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">{{$dk->name}}</h4>
                    <p class="weui-media-box__desc">{{$dk->brief}}</p>
                    <ul class="weui-media-box__info" style="margin-bottom: 5px;">
                        <li class="weui-media-box__info__meta theme_color">{{$dk->fangkuan}}放款</li>
                        <li class="weui-media-box__info__meta theme_color">{{$dk->edu_min}}-{{$dk->edu_max}}元</li>
                        <li class="weui-media-box__info__meta theme_color">{{$dk->rate}}%/{{$dk->time}}</li>
                    </ul>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">{{$dk->view}}人已申请</li>
                    </ul>
                </div>
                <div style="position: absolute; right: 10px; top: 0;">
                    @for ($i = 0; $i < $dk->star; $i++)
                        <img src="{{ asset('images/star.png') }}" alt="" style="height: 14px; width: auto;">
                    @endfor
                </div>
            </a>
        @endforeach
    </div>
    <div style="opacity: 0;position: fixed;">{{$dks->links()}}</div>
    
    @include('front.bottom-bar', ['index' => 4])

    <div>
        <div class="weui-mask" id="iosMask" style="display: none"></div>
        <div class="weui-actionsheet" id="iosActionsheet">
            <div class="weui-actionsheet__title">
                <p class="weui-actionsheet__title-text">额度筛选</p>
            </div>
            <div class="weui-actionsheet__menu">
                <a class="weui-actionsheet__cell" href="/dk/list/0/0">全部</a>
                <a class="weui-actionsheet__cell" href="/dk/list/1/0">0-5000</a>
                <a class="weui-actionsheet__cell" href="/dk/list/2/0">5000-2万</a>
                <a class="weui-actionsheet__cell" href="/dk/list/3/0">2万-5万</a>
                <a class="weui-actionsheet__cell" href="/dk/list/4/0">5万-10万</a>
                <a class="weui-actionsheet__cell" href="/dk/list/5/0">10万以上</a>
            </div>
            <div class="weui-actionsheet__action">
                <div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script type="text/javascript">
        $('.scroll-container').infiniteScroll({
          // options
          path: "a[rel='next']",
          append: '.scroll-post',
          history: false,
        });

        var $iosActionsheet = $('#iosActionsheet');
        var $iosMask = $('#iosMask');

        function hideActionSheet() {
            $iosActionsheet.removeClass('weui-actionsheet_toggle');
            $iosMask.fadeOut(200);
        }

        $iosMask.on('click', hideActionSheet);
        $('#iosActionsheetCancel').on('click', hideActionSheet);
        $("#showIOSActionSheet").on("click", function(){
            $iosActionsheet.addClass('weui-actionsheet_toggle');
            $iosMask.fadeIn(200);
        });

        // $(function(){
        //     //1文字轮播(2-5页中间)开始
        
        //     $(".font_inner li:eq(0)").clone(true).appendTo($(".font_inner"));//克隆第一个放到最后(实现无缝滚动)
        //     var liHeight = $(".swiper_wrap").height();//一个li的高度
        //     //获取li的总高度再减去一个li的高度(再减一个Li是因为克隆了多出了一个Li的高度)
        //     var totalHeight = ($(".font_inner li").length *  $(".font_inner li").eq(0).height()) -liHeight;
        //     $(".font_inner").height(totalHeight);//给ul赋值高度
        //     var index = 0;
        //     var autoTimer = 0;//全局变量目的实现左右点击同步
        //     var clickEndFlag = true; //设置每张走完才能再点击

        //     function tab(){
        //         $(".font_inner").stop().animate({
        //             top: -index * liHeight
        //         },400,function(){
        //             clickEndFlag = true;//图片走完才会true
        //             if(index == $(".font_inner li").length -1) {
        //                 $(".font_inner").css({top:0});
        //                 index = 0;
        //             }
        //         })
        //     }

        //     function next() {
        //         index++;
        //         if(index > $(".font_inner li").length - 1) {//判断index为最后一个Li时index为0
        //             index = 0;
        //         }
        //         tab();
        //     }
        //     function prev() {
        //         index--;
        //         if(index < 0) {
        //             index = $(".font_inner li").size() - 2;//因为index的0 == 第一个Li，减二是因为一开始就克隆了一个LI在尾部也就是多出了一个Li，减二也就是_index = Li的长度减二
        //             $(".font_inner").css("top",- ($(".font_inner li").size() -1) * liHeight);//当_index为-1时执行这条，也就是走到li的最后一个
        //         }
        //         tab();
        //     }
        //     //切换到下一张
        //     $(".swiper_wrap .gt").on("click",function() {
        //         if(clickEndFlag) {
        //             next();
        //             clickEndFlag = false;
        //         }
        //     });
        //     //切换到上一张
        //     $(".swiper_wrap .lt").on("click",function() {
        //         if(clickEndFlag) {
        //             prev();
        //             clickEndFlag = false;
        //         }
        //     });
        //     //自动轮播
        //     autoTimer = setInterval(next,3000);
        //     $(".font_inner a").hover(function(){
        //         clearInterval(autoTimer);
        //     },function() {
        //         autoTimer = setInterval(next,3000);
        //     })

        //     //鼠标放到左右方向时关闭定时器
        //     $(".swiper_wrap .lt,.swiper_wrap .gt").hover(function(){
        //         clearInterval(autoTimer);
        //     },function(){
        //         autoTimer = setInterval(next,3000);
        //     })
        //     //1文字轮播(2-5页中间)结束
        // })
        
    </script>
    
@endsection

