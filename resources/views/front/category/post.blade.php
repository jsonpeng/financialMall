@extends('front.base')

@section('css')
    <style type="text/css">
        
    </style>
@endsection

@section('title')
    <title>{{$post->name}}</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">后退</a><p>黑科技</p>
    </div>

    <div class="post-header">
        <div class="post-title">
            {{$post->name}}
        </div>
        <div class="post-author">
            <dir style="display: flex;">
                <img src="{{ asset('images/header.png') }}">
                <div>
                    <dir class="author-name">小卡</dir>
                    <div class="post-time">发表于: {{$post->created_at->diffForHumans()}}</div>
                </div>
            </dir>
            <img src="{{ asset('images/share.png') }}">
        </div>
    </div>


    <div class="content-wrapper">
        {!!$post->intro!!}
    </div>
    
    @include('front.bottom-bar', ['index' => 1])
@endsection


@section('js')
    <script type="text/javascript">
        
    </script>
    
@endsection

