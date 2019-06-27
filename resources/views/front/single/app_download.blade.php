@extends('front.base')

@section('css')
    <style type="text/css">
        a img{width: 50%;}
        body{
            background-image: url({{ asset('images/invite/bg.png') }});
            background-size: cover;
        }
    </style>
@endsection

@section('title')
    <title>APP下载</title>
@endsection

@section('content')
    <div style="padding: 30px; text-align: center;">
        <img src="{{ $setting->logo }}" alt="" style="width: 40%;">
        <div style="margin-top: 10px; font-size: 18px; font-weight: bold;">{{ $setting->name }}</div>
    </div>

    <div style="text-align: center;">
        <img src="{{ asset('images/invite/text.png') }}" alt="" style="width: 70%;">
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <div><a href="{{ getSettingValueByKey('android_link') }}"><img src="{{ asset('images/invite/apk.png') }}"></a></div>
        <div><a href="{{ getSettingValueByKey('ios_link') }}"><img src="{{ asset('images/invite/ios.png') }}"></a></div>
    </div>

@endsection


@section('js')

@endsection

