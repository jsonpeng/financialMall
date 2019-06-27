@extends('front.base')

@section('css')
    <style type="text/css">

    </style>
@endsection

@section('title')
    <title>{{$live->name}}</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">后退</a><p>直播</p>
    </div>

    <div class="post-header">
        <div class="post-title">
            {{$live->name}}
        </div>
        <div class="post-author">
            <dir style="display: flex;">
                <img src="{{ asset('images/header.png') }}">
                <div>
                    <dir class="author-name">小卡</dir>
                    <div class="post-time">发表于: {{$live->created_at->diffForHumans()}}</div>
                </div>
            </dir>
            <img src="{{ asset('images/share.png') }}">
        </div>
    </div>

    <div class="content-wrapper">
        @if (auth('web')->check() && auth('web')->user()->member && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse(auth('web')->user()->member_end_time)))
            {!!$live->content!!}
        @else
            </br>
            <div style="color: #fff; text-align: center; background-image: url({{ asset('images/bgred.png') }}); background-size: 100% 100%; margin-top: 30px; font-size: 16px;">您还不是VIP会员，加入VIP获取在线学习特权</div>
            <div style="text-align: center;"><img src="{{ asset('images/bottom-arrow.png') }}" style="margin-top: 15px; margin-bottom: 15px; width: 27px;"></div>
            
            <div style="text-align: center;"><a href="/member" class="join_member">立即加入</a></div>
            
        @endif
    </div>
    
    @include('front.bottom-bar', ['index' => 2])
@endsection


@section('js')
    <script type="text/javascript">
        
    </script>
    
@endsection

