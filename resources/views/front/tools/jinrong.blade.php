@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{

            padding: 20px 10px;
        }
        .weui-grids{margin: 15px 0;}
        .swiper-container{max-height: 320px;}
        
    </style>
@endsection

@section('title')
    <title>工具</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>工具</p>
    </div>
    
    <div class="weui-grids" style="margin-top: 0; margin-bottom: 0;">
        @foreach ($tools as $tool)
            <a href="{{ $tool->link }}" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset($tool->image) }}" alt="">
                </div>
                <p class="weui-grid__label">{{$tool->name}}</p>
            </a>
        @endforeach
        
    </div>

    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')

@endsection

