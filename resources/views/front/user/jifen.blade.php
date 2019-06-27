@extends('front.base')

@section('css')
	<style type="text/css">

        .sec-wrapper{display: flex; font-size: 16px; line-height: 30px; width: 100%; margin-top: 15px;}
        .sec-wrapper .sec{flex: 1; text-align: center;}
        .sec-wrapper .sec .title{display: inline-block;}
        .sec-wrapper .sec .title.active{border-bottom: 2px solid #0e83f0;}
        .weui-media-box_appmsg .weui-media-box__hd{width: 40px; height: 40px;}
        body{background-color: #f6f7fa;}
        .weui-media-box__title{font-size: 14px;}
        h4 span{float: right; font-size: 14px;}
        .user-header{

        }
        
	</style>
@endsection

@section('title')
	<title>积分兑换记录</title>
@endsection

@section('content')

    <div class="header">
        <a href="/user_center" class="go_return">返回</a><p>信用卡积分兑换记录</p>
    </div>

    <div style="background-color: #fff;border-radius: 5px; margin-bottom: 55px;">
        <div style="padding: 10px; 0" class="scroll-container">
            @foreach ($records as $element)
                <div class="weui-media-box weui-media-box_text scroll-post">
                    <h4 class="weui-media-box__title">兑换金额 ¥{{ $element->money_user }} <span>{{ $element->created_at }}</span></h4>
                    <h4 class="weui-media-box__title">{{ $element->bank }} ( {{ $element->title }} ) <span>{{ $element->status }}</span></h4>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">{{ $element->des }}</li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
	

    @include('front.bottom-bar', ['index' => 5])
@endsection
