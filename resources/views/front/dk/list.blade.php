@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{
            width: 25%;
            padding: 10px 10px 10px 10px;
        }
        .weui-grids{margin: 15px 0;}
        .swiper-container{max-height: 320px;}

        #selector{
            z-index: 666;
            
            display: flex; width: 100%; background-color: #fff; justify-content: center;
            font-size: 14px;
            line-height: 14px;
        }
        #selector .type{
            flex: 1;  padding: 10px 0; text-align: center;
            display: flex; align-items: center; justify-content: center;
        }
        #selector .type img{
            margin-left: 5px; height: 10px; width: auto;
        }

        .card{
          padding: 3px 5px;
          margin-right: 10px;
          margin-bottom: 10px;
          float: left;
          border: 1px solid #999;
          font-size: 12px;
        }

        .card.active{
          font-weight: bold;
          color: #40558d;
          border: 1px solid #40558d;
        }
    </style>
@endsection

@section('title')
    <title>口子信息</title>
@endsection

@section('content')
    <div style="position: fixed; top: 0; left: 0; right: 0; background-color: #fff; z-index: 2;">
        <div class="header">
            <a href="javascript:history.go(-1)" class="go_return">返回</a><p>口子信息</p>
        </div>

        <div id="selector" class="" style="border-bottom: 1px solid #eee;">
          <div class="type" style="border-right: 1px solid #eee; " onclick="openEduSelector()"><span id="edu_text">{{ $range_name }}</span> <img src="{{ asset('images/arrow-down.png') }}" alt="" ></div>
          <div class="type" style="" onclick="openTypeSelector()"><span id="type_text">{{ $type_name }}</span> <img src="{{ asset('images/arrow-down.png') }}" alt="" ></div>
        </div>
    </div>

    <div class="weui-panel__bd scroll-container" style="padding-top: 78px;">
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

    <div style="z-index: 999999; display: none;" id="eduSelector">
        <div class="weui-mask" id="iosMask" onclick="hideEduSelector()" style="top: 78px;"></div>
        <div class="weui-actionsheet weui-actionsheet_toggle" id="iosActionsheet" style="top: 78px; bottom: auto; padding: 10px;">
            <a class="card @if($range == 0) active @endif" href="/dk/list/0/{{ $type }}">全部额度</a>
            <a class="card @if($range == 1) active @endif" href="/dk/list/1/{{ $type }}">0-5000</a>
            <a class="card @if($range == 2) active @endif" href="/dk/list/2/{{ $type }}">5000-2万</a>
            <a class="card @if($range == 3) active @endif" href="/dk/list/3/{{ $type }}">2万-5万</a>
            <a class="card @if($range == 4) active @endif" href="/dk/list/4/{{ $type }}">5万-10万</a>
            <a class="card @if($range == 5) active @endif" href="/dk/list/5/{{ $type }}">10万以上</a>
        </div>
    </div>

    <div style="z-index: 999999; display: none;" id="typeSelector">
        <div class="weui-mask" id="iosMask" onclick="hideTypeSelector()" style="top: 78px;"></div>
        <div class="weui-actionsheet weui-actionsheet_toggle" id="iosActionsheet" style="top: 78px; bottom: auto; padding: 10px;">
            <a class="card @if($type == 0) active @endif" href="/dk/list/{{ $range }}/0">全部分类</a>
            @foreach($cats as $element)
                <a class="card @if($type == $element->id) active @endif" href="/dk/list/{{ $range }}/{{ $element->id }}">{{ $element->name }}</a>
            @endforeach
        </div>
    </div>

@endsection


@section('js')
    <script type="text/javascript">
        function openEduSelector() {
            $('#typeSelector').hide();
            $('#eduSelector').fadeIn(200);

        }

        function hideEduSelector(){
            $('#eduSelector').fadeOut(200);
        }

        function openTypeSelector() {
            $('#eduSelector').hide();
            $('#typeSelector').fadeIn(200);
        }

        function hideTypeSelector(){
            $('#typeSelector').fadeOut(200);
        }
    </script>
    
@endsection

