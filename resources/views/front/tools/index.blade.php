@extends('front.base')

@section('css')
    <style type="text/css">
        .tool{width: 50%; padding: 5px; box-sizing: border-box; display: block; float: left;}
        
    </style>
@endsection

@section('title')
    <title>工具</title>
@endsection

@section('content')    
    <div class="header-title" style="padding: 5px 15px;">全部工具</div>
    <a href="/share_dks" class="tool">
        <img src="{{ asset('images/share_theme/tools/share.png') }}">
    </a>
    <a href="/dk" class="tool">
        <img src="{{ asset('images/share_theme/tools/dk.png') }}">
    </a>
    <a href="/xyk" class="tool">
        <img src="{{ asset('images/share_theme/tools/xyk.png') }}">
    </a>
    <a href="/tools/jinrong" class="tool">
        <img src="{{ asset('images/share_theme/tools/jinrong.png') }}">
    </a>
    <a href="/kaoshis" class="tool">
        <img src="{{ asset('images/share_theme/tools/kaoshi.png') }}">
    </a>
    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')

@endsection

