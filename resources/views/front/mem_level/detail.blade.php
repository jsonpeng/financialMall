@extends('front.base')

@section('css')
    <style type="text/css">
        .kecheng-type{
            background-color: #0e83f0;
            color: #fff;
            padding: 2px;
            border-radius: 3px;
        }

        html {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        .db {
            display: block;
        }

        .weixinAudio {
            line-height: 1.5;
        }

        .audio_area {
            display: inline-block;
            width: 100%;
            vertical-align: top;
            margin: 0px 1px 0px 0;
            font-size: 0;
            position: relative;
            font-weight: 400;
            text-decoration: none;
            -ms-text-size-adjust: none;
            -webkit-text-size-adjust: none;
            text-size-adjust: none;
        }

        .audio_wrp {
            border: 1px solid #ebebeb;
            background-color: #fcfcfc;
            overflow: hidden;
            padding: 12px 20px 12px 12px;
        }

        .audio_play_area {
            float: left;
            margin: 9px 22px 10px 5px;
            font-size: 0;
            width: 18px;
            height: 25px;
        }

        .playing .audio_play_area .icon_audio_default {
            display: block;
        }

        .audio_play_area .icon_audio_default {
            background: transparent url({{ asset('images/iconloop.png') }}) no-repeat 0 0;
            width: 18px;
            height: 25px;
            vertical-align: middle;
            display: inline-block;
            -webkit-background-size: 54px 25px;
            background-size: 54px 25px;
            background-position: -36px center;
        }

        .audio_play_area .icon_audio_playing {
            background: transparent url({{ asset('images/iconloop.png') }}) no-repeat 0 0;
            width: 18px;
            height: 25px;
            vertical-align: middle;
            display: inline-block;
            -webkit-background-size: 54px 25px;
            background-size: 54px 25px;
            -webkit-animation: audio_playing 1s infinite;
            background-position: 0px center;
            display: none;
        }

        .audio_area .pic_audio_default {
            display: none;
            width: 18px;
        }

        .tips_global {
            color: #8c8c8c;
        }

        .audio_area .audio_length {
            float: right;
            font-size: 14px;
            margin-top: 3px;
            margin-left: 1em;
        }

        .audio_info_area {
            overflow: hidden;
        }

        .audio_area .audio_title {
            font-weight: 400;
            font-size: 17px;
            margin-top: -2px;
            margin-bottom: -3px;
            width: auto;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            word-wrap: normal;
        }

        .audio_area .audio_source {
            font-size: 14px;
        }

        .audio_area .progress_bar {
            position: absolute;
            left: 0;
            bottom: 0;
            background-color: #0cbb08;
            height: 2px;
        }

        .playing .audio_play_area .icon_audio_default {
            display: none;
        }

        .playing .audio_play_area .icon_audio_playing {
            display: inline-block;
        }

        @-webkit-keyframes audio_playing {
            30% {
                background-position: 0px center;
            }
            31% {
                background-position: -18px center;
            }
            61% {
                background-position: -18px center;
            }
            61.5% {
                background-position: -36px center;
            }
            100% {
                background-position: -36px center;
            }
        }

        video::-webkit-media-controls-enclosure {
        overflow:hidden;
        }
        video::-webkit-media-controls-panel {
            width: calc(100% + 50px);
        }
    </style>
@endsection

@section('title')
    <title>中级会员</title>
@endsection

@section('content')

    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>{!! $element->title !!}</p>
    </div>
    <div class="post-header">
        <div class="post-title">
            {{$element->title}}
        </div>
        <div class="post-author">
            <img src="{{ asset('images/header.png') }}">小卡 {{$element->created_at->diffForHumans()}}
        </div>
    </div>

    @if (auth('web')->check() && auth('web')->user()->member && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse(auth('web')->user()->member_end_time)))

        {{-- 检查会员等级 --}}
        @if ( ($element->level == '中级会员' && auth('web')->user()->mem_level <= 1) || ($element->level == '高级会员' && auth('web')->user()->mem_level <= 2) )
         {{--    <div style="color: #fff; text-align: center; background-image: url({{ asset('images/bgred.png') }}); background-size: 100% 100%; margin-top: 30px; font-size: 16px;"></div>
            <div style="text-align: center;"><img src="{{ asset('images/bottom-arrow.png') }}" style="margin-top: 15px; margin-bottom: 15px; width: 27px;"></div> --}}

            <div style="padding: 15px 10px; color: orange;">权限不够，需要{{ $element->level }}才可学习</div>
            
            <div style="text-align: center;"><a href="/member_buy_v2" class="join_member">升级会员</a></div>
        @else
            @if ($element->type == '视频')
                <video src="{{ asset('sound/kuka.mp4') }}" controls="controls" style="width: 100%;">
                    您的浏览器不支持 video 标签。
                </video>
                <div class="content-wrapper">
                    {!!$element->intro!!}
                </div>

            @else
                <p class="weixinAudio">
                    <audio src="" id="media" width="1" height="1" preload></audio>
                    <span id="audio_area" class="db audio_area">
                    <span class="audio_wrp db">
                    <span class="audio_play_area">
                        <i class="icon_audio_default"></i>
                        <i class="icon_audio_playing"></i>
                    </span>
                    <span id="audio_length" class="audio_length tips_global">3:07</span>
                    <span class="db audio_info_area">
                        <strong class="db audio_title">Title/标题</strong>
                        <span class="audio_source tips_global">From/来源</span>
                    </span>
                    <span id="audio_progress" class="progress_bar" style="width: 0%;"></span>
                    </span>
                    </span>
                </p>
                <div class="content-wrapper">
                    {!!$element->intro!!}
                </div>
            @endif
        @endif

    @else
        <div style="color: #fff; text-align: center; background-image: url({{ asset('images/bgred.png') }}); background-size: 100% 100%; margin-top: 30px; font-size: 16px;">您还不是VIP会员，加入VIP学习全部课程</div>
        <div style="text-align: center;"><img src="{{ asset('images/bottom-arrow.png') }}" style="margin-top: 15px; margin-bottom: 15px; width: 27px;"></div>
        
        <div style="text-align: center;"><a href="/member" class="join_member">立即加入</a></div>
        
    @endif
    
    @include('front.bottom-bar', ['index' => 2])
@endsection


@section('js')
    <script type="text/javascript" src="{{ asset('js/weixinAudio.js') }}"></script>

    @if ($element->type == '语音')
        <script type="text/javascript">
            $('.weixinAudio').weixinAudio({
                autoplay:false,
                src: '{{ asset('sound/sound.mp3') }}',
            });
        </script>
    @endif
@endsection

