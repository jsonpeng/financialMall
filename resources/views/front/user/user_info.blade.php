@extends('front.base')

@section('css')
	<style type="text/css">
		#zhichen{display: none;}
        .user-header{
            background-image: url('{{ asset('images/user-header-bg.png') }}');
            background-size: cover;
            text-align: center;
            color: #fff;
            padding-bottom: 15px;
        }
        .user-header img{margin-top: 25px; margin-bottom: 5px;}
        .user-header h4{font-size: 20px;}
        .user-header p{font-size: 14px; color: #fff;}
	</style>
@endsection

@section('title')
	<title>用户中心</title>
@endsection

@section('content')
	<div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>个人信息</p>
    </div>
    <div class="weui-cells" style="margin-top: 0;">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>昵称</p>
            </div>
            <div class="weui-cell__ft">{{ $user->nickname }}</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>手机号码</p>
            </div>
            <div class="weui-cell__ft">{{ $user->mobile }}</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>注册时间</p>
            </div>
            <div class="weui-cell__ft">{{ $user->created_at }}</div>
        </div>

        @if($user->member)
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>会员等级</p>
                </div>
                <div class="weui-cell__ft">{{ $user->level_name }}<a href="/member_buy_v2" style="font-size: 12px; color: blue; margin-left: 5px;">续费升级</a></div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>会员开始时间</p>
                </div>
                <div class="weui-cell__ft">{{ $user->member_buy_time }}</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>会员结束时间</p>
                </div>
                <div class="weui-cell__ft">{{ $user->member_end_time }}</div>
            </div>
        @else
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>普通用户</p>
                </div>
                <a class="weui-cell__ft theme_color" href="/member_buy_v2">VIP订阅 ></a>
            </div>
        @endif

    </div>

@endsection
