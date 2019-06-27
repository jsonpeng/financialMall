@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{
            width: 25%;
            padding: 10px 10px 5px 10px;
        }
        .weui-media-box{padding: 5px;}
        .weui-grids{margin: 15px 0;}

        .weui-cell{
            padding: 30px 15px;
        }
    </style>
@endsection

@section('title')
    <title></title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>分享</p>
    </div>

    <div class="weui-media-box weui-media-box_small-appmsg" style="border-bottom: none;">
        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" @if ($user->member) href="/erweima" @else onclick="shareCommon()"  @endif>
                <div class="weui-cell__hd"><img src="{{ asset('images/share/03.png') }}" alt="" style="width:40px;margin-right:15px;display:block"></div>
                <div class="weui-cell__bd weui-cell_primary">
                    <p>分享二维码</p>
                </div>
                <span class="weui-cell__ft"></span>
            </a>
            <a class="weui-cell weui-cell_access" @if ($user->member) href="/advertorial" @else onclick="shareCommon()"  @endif>
                <div class="weui-cell__hd"><img src="{{ asset('images/share/08.png') }}" alt="" style="width:40px;margin-right:15px;display:block"></div>
                <div class="weui-cell__bd weui-cell_primary">
                    <p>推广软文</p>
                </div>
                <span class="weui-cell__ft"></span>
            </a>
            <a class="weui-cell weui-cell_access" @if ($user->member) href="/face2face" @else onclick="shareCommon()"  @endif>
                <div class="weui-cell__hd"><img src="{{ asset('images/share/10.png') }}" alt="" style="width:40px;margin-right:15px;display:block"></div>
                <div class="weui-cell__bd weui-cell_primary">
                    <p>面对面开通账号</p>
                </div>
                <span class="weui-cell__ft"></span>
            </a>
        </div>
    </div>
    
    
    @include('front.bottom-bar', ['index' => 5])
@endsection


@section('js')
    <script>
        function shareCommon(){
          $('#g_iosDialog1').fadeIn(200);
        }
    </script>
@endsection

