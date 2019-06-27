@extends('front.base')

@section('css')
    <style type="text/css">
        
    </style>
@endsection

@section('title')
    <title>{{$notice->name}}</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">公告列表</a><p>公告</p>
    </div>
    <div class="post-header">
        <div class="post-title">
            {{$notice->name}}
        </div>
        <div class="post-author">
            <img src="{{ asset('images/header.png') }}">小卡 {{$notice->created_at->diffForHumans()}}
        </div>
    </div>

    <div class="content-wrapper">
        {!!$notice->intro!!}
    </div>
    
    @include('front.bottom-bar', ['index' => 1])
@endsection


@section('js')
    <script type="text/javascript">
        
    </script>
    
@endsection

