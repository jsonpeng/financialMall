@extends('front.base')

@section('css')
    <style type="text/css">

    </style>
@endsection

@section('title')
    <title>{{$hkj->name}}</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">后退</a><p>黑科技</p>
    </div>

    <div class="post-header">
        <div class="post-title">
            {{$hkj->name}}
        </div>
        <div class="post-author">
            <dir style="display: flex;">
                <img src="{{ asset('images/header.png') }}">
                <div>
                    <dir class="author-name">小卡</dir>
                    <div class="post-time">发表于: {{$hkj->created_at->diffForHumans()}}</div>
                </div>
            </dir>
            <img src="{{ asset('images/share.png') }}">
        </div>
    </div>

    <div class="content-wrapper">
        
        @if($user->member && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($user->member_end_time)))

            @if($user->mem_level < $hkj->level)

                @if($hkj->free_info) {!!$hkj->free_info!!} @endif

                <div style="padding: 15px 10px; color: orange;">您的课程级别不够，请先升级课程</div>

                <div style="text-align: center;"><a href="/member_buy_v2" class="join_member">立即升级</a></div>

            @else

                @if($hkj->free_info) {!!$hkj->free_info!!} @endif
                @if($hkj->intro) {!!$hkj->intro!!} @endif

            @endif
        @else
            @if($hkj->free_info) {!!$hkj->free_info!!} @endif

            <div style="padding: 15px 10px; color: orange;">以下内容为付费客户才能内容，订阅后即可浏览</div>
            <div style="text-align: center;"><a href="/member_buy_v2" class="join_member">立即订阅</a></div>

        @endif
        
    </div>
    
    @include('front.bottom-bar', ['index' => 2])
@endsection


@section('js')
    <script type="text/javascript">
        
    </script>
    
@endsection

