@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{
            width: 25%;
            padding: 10px 10px 5px 10px;
        }
        .weui-media-box{padding: 5px;}
        .weui-grids{margin: 15px 0;}
    </style>
@endsection

@section('title')
    <title>提现申请</title>
@endsection

@section('content')
    <div class="header">
        <a href="/wallet" class="go_return">返回</a><p>提现申请</p>
    </div>
    
    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" name="count" placeholder="请输入提取金额" onkeyup='this.value=this.value.replace(/[^\d.]/g,"")' onpaste='this.value=this.value.replace(/[^\d.]/g,"")'/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p class="weui-cell__ft" style="float: left;">可用余额{{ $user->money }}元</p>
            </div>
            <div class="weui-cell__ft" style="color: #0e83f0;" onclick="takeAll({{ $user->money }})">全部提现</div>
        </div>
    </div>
    
    <div class="weui-cell" style="margin-top: 20px;">
        <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="name" placeholder="姓名">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">支付宝账号</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="zhifubao" placeholder="支付宝账号">
        </div>
    </div>
    
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" onclick="submit()">确定</a>
    </div>

    @include('front.bottom-bar', ['index' => 5])
@endsection


@section('js')

    <script type="text/javascript">
        function takeAll(allmoney) {
            $('input[name=count]').val(allmoney);
        }

        function submit() {
            if ( $('input[name=count]').val() == '' ) {
                $('#g_iosDialog2_text').text('请输入提取金额');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

            if ( $('input[name=name]').val() == '' ) {
                $('#g_iosDialog2_text').text('请输入姓名');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

            if ( $('input[name=zhifubao]').val() == '' ) {
                $('#g_iosDialog2_text').text('请输入支付宝账号');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/ajax/post_withdraw',
                type: 'POST',
                data: {
                    count: $('input[name=count]').val(), 
                    name: $('input[name=name]').val(), 
                    zhifubao: $('input[name=zhifubao]').val()
                },
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        $('#g_iosDialog2_text').text('提交成功');
                        $('#g_iosDialog2').fadeIn(200);
                        setTimeout(function() {
                            location.href = '/wallet';
                        }, 2000);
                        
                    } else {
                        $('#g_iosDialog2_text').text(data.message);
                        $('#g_iosDialog2').fadeIn(200);
                    }                   
                },
            });
        }
    </script>
    
@endsection

