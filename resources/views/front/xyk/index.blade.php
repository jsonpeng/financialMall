@extends('front.base')

@section('css')
    <style type="text/css">
        .swiper-container{max-height: 320px;}
        
    </style>
@endsection

@section('title')
    <title>信用卡</title>
@endsection

@section('content')
    <!-- Slider main container -->
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

    <div class="hot-bank">
        <p>热门银行</p>
    </div>
    <section class="all_bank">
        @foreach($banks as $bank)
            <a href="/xyk_bank/{{ $bank->id }}" style="display: block;">
                <dl class="bank">
                    <dt><img src="{{ $bank->image }}"></dt>
                    <dd>{{ $bank->name }}</dd>
                </dl>
            </a>
        @endforeach
    </section>
    <em class="all_em" click="1" style="transform: rotate(360deg);"><img src="{{ asset('images/jiantou.png') }}"></em>

    <div class="hot-bank">
        <p>主题卡</p>
    </div>
    <section class="card">
        <div class="r_left">
            <?php $index =0;?>
            @if($themes->count() > 0)
                <a href="/xyk_theme/{{ $themes[$index]['id'] }}">
                    <div class="bjhui" style=" position:relative;">
                        <div class="zjy_ka">
                            <img class="zjy_che" src="{{ $themes[$index]['image'] }}" style="width: 80px;height: 80px;margin-left: -40px;  left: 50%;">
                            <div class="zx_ha"><h3>{{ $themes[$index]['name'] }}</h3><p>{{ $themes[$index++]['brief'] }}</p></div>
                        </div>
                    </div>
                </a>
            @endif
            @if($themes->count() > 1)
            <a href="/xyk_theme/{{ $themes[$index]['id'] }}">
                <div class="bjhui">
                    <div class="flh3p">
                        <h3>{{ $themes[$index]['name'] }}</h3><p>{{ $themes[$index]['brief'] }}</p>
                    </div>
                    <img src="{{ $themes[$index++]['image'] }}" class="r-imgicon">
                </div>
            </a>
            @endif
        </div>
        <div class="r_right">
            @if($themes->count() > 2)
            <a href="/xyk_theme/{{ $themes[$index]['id'] }}">
                <div class="bjhui">
                    <div class="flh3p">
                        <h3>{{ $themes[$index]['name'] }}</h3><p>{{ $themes[$index]['brief'] }}</p>
                    </div>
                    <img src="{{ $themes[$index++]['image'] }}" class="r-imgicon">
                </div>
            </a>
            @endif
            @if($themes->count() > 3)
            <a href="/xyk_theme/{{ $themes[$index]['id'] }}">
                <div class="bjhui">
                    <div class="flh3p">
                        <h3>{{ $themes[$index]['name'] }}</h3><p>{{ $themes[$index]['brief'] }}</p>
                    </div>
                    <img src="{{ $themes[$index++]['image'] }}" class="r-imgicon">
                </div>
            </a>
            @endif
            @if($themes->count() > 4)
            <a href="/xyk_theme/{{ $themes[$index]['id'] }}">
                <div class="bjhui">
                    <div class="flh3p">
                        <h3>{{ $themes[$index]['name'] }}</h3><p>{{ $themes[$index]['brief'] }}</p>
                    </div>
                    <img src="{{ $themes[$index++]['image'] }}" class="r-imgicon">
                </div>
            </a>
            @endif
        </div>
    </section>

    <section class="mt_10">
        <div class="zhu_ti">
            <p>热门信用卡</p>
        </div>
    </section>

    <section>
        <div class="insurance scroll-container">
            @foreach($cards as $card)
                <div class="in_ce scroll-post">
                    <a class="in_ce_img" href="{{ $card->link }}">
                        <img src="{{ $card->image }}">
                    </a>
                    <a href="{{ $card->link }}" class="in_xa">
                        <dl>
                            <dt></dt>
                            <dd>
                                <p class="card_p1"><i class="feature2">{{ $card->name }}</i></p>

                                <p></p>
                                <p class="card_p2">{{ $card->brief }}</p>
                                <p class="card_p3">
                                    申请人数<span>&nbsp;&nbsp;{{ $card->view }}</span>
                                </p>
                            </dd>
                        </dl>
                    </a>
                    <a href="{{ $card->link }}" class="in_ljsq">立即申请</a>
                </div>
            @endforeach
        </div>

        <div style="opacity: 0;position: fixed;">{{$cards->links()}}</div>
    </section>
    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')
    <script>
        var num = 8;
        $('.all_bank a').hide();
        var len = $('.all_bank a').length;
        if(len > num){
            for (var i = 0; i < num; i++) {
                $('.all_bank a').eq(i).show()
            };
            $('.all_em').show()
        }else{
            $('.all_em').hide();
            
            $('.all_bank a').show();
        }
        
        $('.all_em').on('click',function(){
            if($(this).attr('click') == 1){
                $(this).attr('click',0);
                $('.all_bank a').show();
                $(this).css('transform','rotate(180deg)')
            }else{
                $('.all_bank a').hide();
                $(this).css('transform','rotate(360deg)')
                
                for (var i = 0; i <num; i++) {
                    $('.all_bank a').eq(i).show();
                };
                $(this).attr('click',1);
            }
        })

        $('.scroll-container').infiniteScroll({
          // options
          path: "a[rel='next']",
          append: '.scroll-post',
          history: false,
        });
        
    </script>
    
@endsection

