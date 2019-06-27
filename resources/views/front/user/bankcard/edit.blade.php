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
        <a href="/user_center" class="go_return">个人中心</a><p>编辑银行卡</p>
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

    <form method="GET" action="/bankcard/update/{{$bankCard->id}}">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{$bankCard->user_id}}">
        <div class="weui-cells__title">银行名称</div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                    <select class="weui-select" name="name">
                        <option @if($bankCard->name == '中国工商银行') selected="" @endif value="中国工商银行">中国工商银行</option>
                        <option @if($bankCard->name == '中国建设银行') selected="" @endif value="中国建设银行">中国建设银行</option>
                        <option @if($bankCard->name == '中国农业银行') selected="" @endif value="中国农业银行">中国农业银行</option>
                        <option @if($bankCard->name == '中国银行') selected="" @endif value="中国银行">中国银行</option>
                        <option @if($bankCard->name == '招商银行') selected="" @endif value="招商银行">招商银行</option>
                        <option @if($bankCard->name == '邮政银行') selected="" @endif value="邮政银行">邮政银行</option>
                        <option @if($bankCard->name == '浦发银行') selected="" @endif value="浦发银行">浦发银行</option>
                        <option @if($bankCard->name == '兴业银行') selected="" @endif value="兴业银行">兴业银行</option>
                        <option @if($bankCard->name == '民生银行') selected="" @endif value="民生银行">民生银行</option>
                    </select>
                </div>
            </div>
        </div>

    	<div class="weui-cells__title">开户行支行</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入开户行支行" name="bank_name" value="{{$bankCard->bank_name}}">
                </div>
            </div>
        </div>

        <div class="weui-cells__title">用户名</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入用户名" name="user_name" value="{{$bankCard->user_name}}">
                </div>
            </div>
        </div>

        <div class="weui-cells__title">账号</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入账号" name="count" value="{{$bankCard->count}}">
                </div>
            </div>
        </div>

        <div class="weui-cells__title">手机(可选)</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入手机" name="mobile" value="{{$bankCard->mobile}}">
                </div>
            </div>
        </div>

        <div class="weui-btn-area">
            <input type="submit" name="" value="保存" class="weui-btn weui-btn_primary">
            <a href="javascript:;" class="weui-btn weui-btn_warn" id="showIOSDialog1">删除</a>
        </div>

    </form>

    <div id="dialogs">
        <!--BEGIN dialog1-->
        <div class="js_dialog" id="iosDialog1" style="display: none;">
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__hd"><strong class="weui-dialog__title">提醒</strong></div>
                <div class="weui-dialog__bd">确认删除银行卡信息吗？该操作不可恢复</div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default">取消</a>
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onclick="delete_card({{$bankCard->id}})">确定</a>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script type="text/javascript">
        function delete_card(id) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/bankcard/delete/{{$bankCard->id}}',
                type: 'GET',
                data: {},
                success: function(data) {
                    
                    if (data.code == 1) {
                        alert(data.message);
                        return;
                    }

                   window.location.href = '/bankcard';

                },
            });
        }
        $(function(){
            var $iosDialog1 = $('#iosDialog1');

            $('#dialogs').on('click', '.weui-dialog__btn', function(){
                $(this).parents('.js_dialog').fadeOut(200);
            });

            $('#showIOSDialog1').on('click', function(){
                $iosDialog1.fadeIn(200);
            });


        });
    </script>
@endsection