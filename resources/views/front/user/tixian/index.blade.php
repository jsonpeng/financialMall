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

    @if (count($money_records) > 0)
    <div class="weui-cells__title">账户资金变动记录</div>
    <div class="weui-cells scroll-container">
        @foreach ($money_records as $money_record)
            <a class="weui-cell weui-cell_access scroll-post" href="/tixian/detail/{{$money_record->id}}">
                <div class="weui-cell__bd">
                    <p>{{$money_record->type}}({{$money_record->money}}元)</p>
                </div>
                <div class="weui-cell__ft">{{$money_record->status}}</div>
            </a>
        @endforeach
        <div style="opacity: 0;">{{$money_records->links()}}</div>
    </div>
    @else
    <div class="weui-cells__title">暂无提现记录</div>
    @endif

@endsection


@section('js')
    
@endsection