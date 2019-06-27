@extends('front.base')

@section('css')
	<style type="text/css">
		#zhichen{display: none;}
	</style>
@endsection

@section('title')
	<title>银行卡</title>
@endsection

@section('content')
    <div class="header">
        <a href="/user_center" class="go_return">个人中心</a><p>银行卡列表</p>
    </div>

    @include('flash::message')

	<div class="weui-cells__title">银行卡列表</div>
    <div class="weui-cells">
        @foreach ($bankcards as $bankcard)
            <a class="weui-cell weui-cell_access" href="/bankcard/edit/{{$bankcard->id}}">
                <div class="weui-cell__bd">
                    <p>{{$bankcard->name}} (<?php echo substr($bankcard->count,-4); ?>)</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
        @endforeach
        
        <div class="weui-btn-area">
            <a href="/bankcard/add" class="weui-btn weui-btn_primary">添加银行卡</a>
        </div>
    </div>

@endsection


@section('js')
    <script type="text/javascript">
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
@endsection