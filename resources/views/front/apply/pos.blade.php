@extends('front.base')

@section('css')
    <style type="text/css">
        .title{
            font-size: 14px; font-weight: bold;
        }
        .eng-text{
            color: #a8a8a8; font-size: 12px; text-align: center; position: relative;
        }
        .eng-text:after{
            content: '';
            width: 70px;
            height: 2px;
            border-bottom: 1px solid red;
            position: absolute;
            bottom: -10px;
            left: 50%;
            margin-left: -35px;
        }
        .intro-content{
            font-size: 14px;
            line-height: 20px;
            padding: 15px;
        }
        .weui-cells{
            font-size: 14px;
        }
        .weui-input, .weui-textarea{
            font-size: 14px;
        }
    </style>
@endsection

@section('title')
    <title>POS机申请</title>
@endsection

@section('content')
<div class="header">
    <a href="/" class="go_return">首页</a><p>POS机申请</p>
</div>
<div class="intro-content">
    @if (!empty($posIntro))
        {!! $posIntro->intro !!}
    @endif
</div>

<div style="text-align: center; margin-top: 30px; margin-bottom: 20px;">
    <div class="title">填写您的信息并提交</div>
    <div class="eng-text">fill in your information and submit.</div>
</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="name" maxlength="5" minlength="2" placeholder="请输入姓名">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number" name="mobile" pattern="[0-9]*" maxlength="11" minlength="11" placeholder="请输入手机号">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">信用卡数量</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number" name="card_num" pattern="[0-9]*" maxlength="11" minlength="11" placeholder="请输入信用卡数量">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">邮寄地址</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="address" minlength="11" placeholder="请输入邮寄地址">
        </div>
    </div>
    <div style="padding: 30px 15px;">
        <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="submit()">提交</a>
    </div>
</div>
    
@endsection


@section('js')
    <script type="text/javascript">
        function submit() {
            if ($('input[name=name]').val() == '' || $('input[name=name]').val().length < 2) {
                alert('请填写姓名');
                return;
            }
            if ($('input[name=mobile]').val() == '' || $('input[name=mobile]').val().length != 11) {
                alert('请填写正确手机号');
                return;
            }
            if ($('input[name=card_num]').val() == '') {
                alert('请填写信用卡张数');
                return;
            }
            if ($('input[name=address]').val() == '' || $('input[name=address]').val().length < 10) {
                alert('请填写正确的邮寄地址');
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });
          $.ajax({
              url:"/api/save_pos_apply",
              type:"POST",
              data:'name='+$('input[name=name]').val()+'&mobile='+$('input[name=mobile]').val()+'&card_num='+$('input[name=card_num]').val()+'&address='+$('input[name=address]').val(),
              success: function(data) {
                  if (data.code) {
                    alert(data.message);
                  }else{
                    alert('申请提交成功');
                    $('input[name=name]').val('');
                    $('input[name=mobile]').val('');
                    $('input[name=card_num]').val('');
                    $('input[name=address]').val('');
                  }
              },
              error: function(data) {
                  //提示失败消息

              },
          });
        }
    </script>
@endsection