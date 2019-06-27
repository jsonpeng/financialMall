@extends('front.base')

@section('css')
    <style type="text/css">
        
    </style>
@endsection

@section('title')
    <title>{{$page->name}}</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>{{$page->name}}</p>
    </div>
    <div class="post-header">
        <div class="post-title">
            {{$page->name}}
        </div>
        <div class="post-author">
            <img src="{{ asset('images/header.png') }}">小卡 {{$page->created_at->diffForHumans()}}
        </div>
    </div>

    <div class="content-wrapper">
        {!!$page->content!!}
    </div>
    
    @include('front.bottom-bar', ['index' => 2])
@endsection


@section('js')
    <script type="text/javascript">
        
    </script>
    
@endsection

