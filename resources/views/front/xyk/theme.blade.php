@extends('front.base')

@section('css')
    <style type="text/css">
        .swiper-container{max-height: 320px;}
        
    </style>
@endsection

@section('title')
    <title>平台</title>
@endsection

@section('content')
    <div class="header">
        <a href="/xyk" class="go_return">信用卡</a><p>{{ $creditCardTheme->name }}</p>
    </div>

    <div class="hot-bank">
        <p>主题信用卡</p>
    </div>
    <section class="all_bank">
        @foreach($themes as $theme)
            <a href="/xyk_theme/{{ $theme->id }}" style="display: block;">
                <dl class="bank">
                    <dt><img src="{{ $theme->image }}"></dt>
                    <dd>{{ $theme->name }}</dd>
                </dl>
            </a>
        @endforeach
    </section>
    <em class="all_em" click="1" style="transform: rotate(360deg);"><img src="http://credit.haodai.com/static/shenma/img/jiantou.png"></em>

    <section>
        <div class="insurance">
            @foreach($cards as $card)
                <div class="in_ce">
                    <a class="in_ce_img" href="{{ $card->link }}">
                        <img src="{{ $card->image }}">
                    </a>
                    <a href="{{ $card->link }}" class="in_xa">
                        <dl>
                            <dt></dt>
                            <dd>
                                <p class="card_p1"><i class="feature2">{{ $card->name }}</i></p>
                    
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
    </script>
    <script type="text/javascript">
        $('.weui-panel__bd').infiniteScroll({
          // options
          path: "a[rel='next']",
          append: '.weui-media-box_appmsg',
          history: false,
        });
        
    </script>
    
@endsection

