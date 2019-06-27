@extends('front.base')

@section('css')
    <style type="text/css">

    </style>
@endsection

@section('title')
    <title>{{ $setting->name }}</title>
@endsection

@section('content')
    <div class="page">
        <div class="weui-msg">
            <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
            <div class="weui-msg__text-area">
                <h2 class="weui-msg__title">支付失败</h2>
                <p class="weui-msg__desc">很遗憾，支付失败。再重新尝试一次吧</p>
            </div>
            <div class="weui-msg__opr-area">
                <p class="weui-btn-area">
                    <a href="/member" class="weui-btn weui-btn_primary">重新购买</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript">
        $(document).ready(function(){
            var seconds = 5;
            setInterval(function(){
                $('#seconds').text(--seconds);
            }, 1000)
            setTimeout(function(){
                window.location.href = '/';
            }, 4000);
        });
    </script>
    
@endsection

