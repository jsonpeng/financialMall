@extends('front.base')

@section('css')

@endsection

@section('title')
    <title>{{ $setting->name }}服务协议</title>
@endsection

@section('content')
    <h2 style="font-size: 16px; text-align: center; font-weight: bold; padding: 15px 0;">{{ $setting->name }}服务协议</h2>
    <div style="text-align: center; padding: 0 15px;">
        {!! $setting->law !!}
    </div>
@endsection


@section('js')
    <script type="text/javascript">
       
    </script>
    
@endsection

