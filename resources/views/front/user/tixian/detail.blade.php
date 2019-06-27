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
        <a href="/user_center" class="go_return">个人中心</a><p>提现记录</p>
    </div>

    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">{{$moneyRecord->type}}</label>
                <em class="weui-form-preview__value">¥{{$moneyRecord->money}}</em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">状态</label>
                <span class="weui-form-preview__value">{{$moneyRecord->status}}</span>
            </div>
            @if($moneyRecord->name)
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">银行名称</label>
                <span class="weui-form-preview__value">{{$moneyRecord->name}}</span>
            </div>
            @endif
            
            @if($moneyRecord->bank_name)
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">支行</label>
                <span class="weui-form-preview__value">{{$moneyRecord->bank_name}}</span>
            </div>
            @endif
            
            @if($moneyRecord->user_name)
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">用户名</label>
                <span class="weui-form-preview__value">{{$moneyRecord->user_name}}</span>
            </div>
            @endif
            
            @if($moneyRecord->mobile)
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">账号</label>
                <span class="weui-form-preview__value">{{$moneyRecord->mobile}}</span>
            </div>
            @endif
            
            @if($moneyRecord->info)
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">说明信息</label>
                <span class="weui-form-preview__value">{{$moneyRecord->info}}</span>
            </div>
            @endif
            
        </div>
        <div class="weui-btn-area">
            <a href="/tixian" class="weui-btn weui-btn_primary">返回</a>
        </div>
    </div>

@endsection

