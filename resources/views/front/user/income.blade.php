@extends('front.base')

@section('css')
	<style type="text/css">

        .sec-wrapper{display: flex; font-size: 16px; line-height: 30px; width: 100%; margin-top: 15px;}
        .sec-wrapper .sec{flex: 1; text-align: center;}
        .sec-wrapper .sec .title{display: inline-block;}
        .sec-wrapper .sec .title.active{border-bottom: 2px solid #0e83f0;}
        .weui-media-box_appmsg .weui-media-box__hd{width: 40px; height: 40px;}
        .user-header{
            background: -webkit-linear-gradient(left, #61b6f9, #527edf); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(right, #61b6f9, #527edf); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(right, #61b6f9, #527edf); /* Firefox 3.6 - 15 */
            background: linear-gradient(to right, #61b6f9, #527edf); /* 标准的语法（必须放在最后） */
            color: #fff;
            padding-bottom: 45px;
        }
        body{background-color: #f6f7fa;}
        .weui-media-box__title{font-size: 14px;}
        h4 span{float: right; font-size: 14px;}
        
	</style>
@endsection

@section('title')
	<title>用户中心</title>
@endsection

@section('content')
    <div class="user-header">
        <div class="header" style="background-color: transparent;">
            <a href="/user_center" class="go_return">返回</a><p>我的钱包</p>
        </div>
        
        <div class="sec-wrapper">
            <div class="sec">金币余额</br>{{ $user->money }}</div>
            <div class="sec">待审核金币</br>{{ $withdraw_pendding }}</div>
            <div class="sec">已提金币</br>{{ $withdraw_done }}</div>
        </div>

        <div style="text-align: center; margin: 10px 0;">
            <a href="/cash_withdraw" style="background-color: rgba(255,255,255,0.3); color: #fff; padding: 5px 10px; border-radius: 3px;">申请提现</a>
        </div>
    </div>
    <div style="margin: 0 15px;margin-top: -45px;background-color: #fff;border-radius: 5px; margin-bottom: 55px;">
        <div class="inner-list">
            <div class="sec-wrapper">
                <a class="sec" href="/wallet"><div class="title">提现记录</div></a>
                <a class="sec" href="/income?type=1"><div class="title @if($type == 1) active @endif">贷款收入</div></a>
                <a class="sec" href="/income?type=2"><div class="title @if($type == 2) active @endif">推广收入</div></a>
            </div>
            <div style="padding: 10px;" class="scroll-container">
                @foreach ($incomes as $element)
                    <div class="weui-media-box weui-media-box_text scroll-post">
                        <h4 class="weui-media-box__title">¥{{ $element->count }} <span>{{ $element->created_at }}</span></h4>
                        <ul class="weui-media-box__info">
                            <li class="weui-media-box__info__meta">{{ $element->des }}</li>
                        </ul>
                    </div>
                @endforeach

                {!! $incomes->appends($input)->links() !!}
            </div>

        </div>
    </div>
	

    @include('front.bottom-bar', ['index' => 5])
@endsection
