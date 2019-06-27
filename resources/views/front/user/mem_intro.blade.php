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
    <img src="{{ asset('images/banner-index.jpg') }}" alt="">
    <div style="padding: 30px; font-size: 16px; line-height: 30px;">
        
        您还不是我们商学院的会员，成为商学院会员，即刻学习全网最全面的借贷黑科技，样卡技巧，提额技术。学成后，办贷款，做中介，开公司，实现人生价值。</br>
        现在加入更可免费获得合伙人资格，拥有你的专属二维码，有码者拿红包拿奖励。
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/member" style="padding: 5px 35px; background-color: #fcb02b; color: #fff; display: inline-block; border-radius: 5px;">了解详情</a>
        </div>
    </div>
    
    @include('front.bottom-bar', ['index' => 5])
@endsection


@section('js')
    
@endsection

