@extends('front.base')

@section('css')
	<style type="text/css">
		.alert ul{list-style: none;}
        #zhichen{display: none;}
	</style>
@endsection

@section('title')
	<title>提现</title>
@endsection

@section('content')
    
    <div class="header">
        <a href="/user_center" class="go_return">个人中心</a><p>提现申请</p>
    </div>

    @include('flash::message')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="/tixian/shenqing">
        {{ csrf_field() }}
        <div class="weui-cells__title">选择银行卡</div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                    <select class="weui-select" name="card_id">
                        @foreach ($bankcards as $bankcard)
                            <option value="{{$bankcard->id}}">{{$bankcard->name}} (<?php echo substr($bankcard->count,-4); ?>)</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">提取金额 (余额{{$user->money}}, 最低提取金额为200元)</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入提现金额" name="money">
                </div>
            </div>
        </div>
    
        <div class="weui-btn-area">
            @if($user->money < 200)
                <input type="submit" name="" value="余额不足" class="weui-btn weui-btn_default">
                <a href="/yue" class="yue">余额不足怎么办</a>
            @else 
                <input type="submit" name="" value="提交" class="weui-btn weui-btn_primary">
            @endif
            
        </div>
    </form>

@endsection


@section('js')
    
@endsection