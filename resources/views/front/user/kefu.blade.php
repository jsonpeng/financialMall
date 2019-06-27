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
    <title>客服</title>
@endsection

@section('content')
    <div style="text-align: center; padding-top: 40px;">
        <img src="images/kefu.jpg" alt="" style="width: 66%;">
    </div>
    
    <div style="text-align: center; font-size: 14px; margin-top: 10px;">长按二维码联系客服人员</div>
    
    @include('front.bottom-bar', ['index' => 5])
@endsection


@section('js')
    
@endsection

