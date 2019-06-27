@extends('front.base')

@section('css')
	<style type="text/css">
		.alert ul{list-style: none;}
        #zhichen{display: none;}
	</style>
@endsection

@section('title')
	<title>银行卡</title>
@endsection

@section('content')

    <div class="header">
        <a href="/user_center" class="go_return">个人中心</a><p>添加银行卡</p>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/bankcard/add">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <div class="weui-cells__title">开户行</div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                    <select class="weui-select" name="name">
                        <option selected="" value="中国工商银行">中国工商银行</option>
                        <option value="中国建设银行">中国建设银行</option>
                        <option value="中国农业银行">中国农业银行</option>
                        <option value="中国银行">中国银行</option>
                        <option value="招商银行">招商银行</option>
                        <option value="邮政银行">邮政银行</option>
                        <option value="浦发银行">浦发银行</option>
                        <option value="兴业银行">兴业银行</option>
                        <option value="民生银行">民生银行</option>
                    </select>
                </div>
            </div>
        </div>

    	<div class="weui-cells__title">开户行支行名称</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="" name="bank_name">
                </div>
            </div>
        </div>

        <div class="weui-cells__title">银行卡用户姓名</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="" name="user_name">
                </div>
            </div>
        </div>

        <div class="weui-cells__title">银行卡账号</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="" name="count">
                </div>
            </div>
        </div>

        <div class="weui-cells__title">手机(可选)</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入手机" name="mobile">
                </div>
            </div>
        </div>

        <div class="weui-btn-area">
            <input type="submit" name="" value="提交" class="weui-btn weui-btn_primary">
        </div>

    </form>

@endsection
