@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{
            width: 25%;
            padding: 10px 10px 5px 10px;
        }
        .weui-media-box{padding: 5px;}
        .weui-grids{margin: 15px 0;}
    </style>
@endsection

@section('title')
    <title>推广软文</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>推广软文</p>
    </div>

    <div style="padding: 15px;">
        @if (empty($advertorial))
            没有推广软文信息
        @else
            {!! $advertorial->content !!}
        @endif
        
    </div>
    
    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')
    
@endsection

