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
    <title>{{ $setting->name }}</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>分享二维码</p>
    </div>
    <div style="text-align: center; margin-top: 20px; padding: 0 30px;">
        <img src="{{$url}}" alt="" style="width: 100%;">
        <div>将二维码分享给朋友，朋友加入会员后，即可获得奖励</div>
        <div style="color: #999; font-size: 12px;">长按图片，再弹出的菜单选项中分享给朋友</div>
    </div>
    
    
    @include('front.bottom-bar', ['index' => 5])
@endsection


@section('js')
    
@endsection

