@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-form-preview__hd .weui-form-preview__value{
            font-size: 16px;
            color: #333;
        }
        .weui-form-preview__hd .weui-form-preview__label{
            font-size: 22px;
            color: #fd5555;
        }
        .detail{
            padding: 15px;
        }
        a{
            color: #fcb02b;
        }

        #gou_mai_tishi{
            position: fixed;
            top: 15px;
            left: 15px;
            height: 25px;
            padding-right: 15px;
            padding-left: 15px;
            line-height: 25px;
            background-color: #3daefd;
            color: #fff;
            border-radius: 15px;
            overflow: hidden;
            display: none;
            z-index: 555;
        }
        #gou_mai_tishi img{width: 25px; height: 25px; border-radius: 50%; margin-right: 5px; float: left;}

        .pay-selector .close{
            background-image: url({{ asset('images/close-product.png') }}); 

        }
        .pay-weixin{background-image: url({{ asset('images/pay-weixin.png') }})}
        .pay-ali{background-image: url({{ asset('images/pay-alipay.png') }})}
        .pay-union{background-image: url({{ asset('images/pay-union.png') }})}

      /*  .weui-btn_disabled.weui-btn_primary {
            background-color: rgb(236, 211, 165);
        }*/

        .member-card{display: flex; padding: 10px 10px; align-items: center; font-size: 14px;}
        .member-card.active{color: #fff; background-color: #3583e8;}
        .member-card .checker{
            width: 34px; 
            height: 34px; 
            background-image: url('{{ asset('images/check.png') }}'); 
            background-size: 25px 25px;
            background-repeat: no-repeat;
            background-position: center;
        }
        .member-card.active .checker{
            background-image: url('{{ asset('images/check-on.png') }}'); 
        }
        .member-card .price{
            -webkit-box-flex: 1; 
            flex: 1; 
            -webkit-flex: 1; 
            padding-left: 10px;
        }
        .member-card .name{
            -webkit-box-flex: 2; flex: 2; -webkit-flex: 2; text-align: right; padding-right: 15px;
        }
        .member-card .name .des{
            font-size: 10px;
        }
        .member-card .timer{
            width: 34px; 
            height: 34px; 
            background-image: url('{{ asset('images/time-on.png') }}'); 
            background-size: 25px 25px;
            background-repeat: no-repeat;
            background-position: center;
        }
        .member-card.active .timer{
            background-image: url('{{ asset('images/time.png') }}'); 
        }
    }
    </style>
@endsection

@section('title')
    <title>{{ $setting->name }}</title>
@endsection

@section('content')
    @if(empty($user->mobile))
        <div>
            需要验证手机号
        </div>
    @endif

    <img src="{{ asset($product->image) }}" style="width: 100%;">
    <div class="content-wrapper" style="padding-left: 0; padding-right: 0;">
        <div class="weui-panel__bd">
            <div class="weui-media-box weui-media-box_text" style="padding-bottom: 0;">
                <h4 class="weui-media-box__title" style="white-space: normal; line-height: 22px;">{{$product->name}}</h4>
                <p class="weui-media-box__desc" style="white-space: normal; display: block; line-height: 20px;">{{$product->des}}</p>
            </div>
        </div>
        <!--div class="weui-form-preview" style="padding-top: 0;">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">¥{{$product->price}}</label>
                    <em class="weui-form-preview__value">销量：{{$product->sales}}</em>
                </div>
            </div>
        </div-->

        <div class="weui-cells weui-cells_radio" style="padding: 15px; margin-top: 0; border-top: 0;">
            @foreach($userLevels as $userLevel)
            <div class="member-card" card-id='{{ $userLevel->id }}'>
                <div class="checker"></div>
                <div class="price">¥{{ $userLevel->money }}</div>
                <div class="name"><div>{{ $userLevel->name }}</div>@if($userLevel->des) <div class="des">{{ $userLevel->des }}</div> @endif</div>
                <div class="timer"></div>
            </div>
            @endforeach
        </div>
        <div class="page__bd page__bd_spacing" style="padding: 15px;">
            <button class="weui-btn weui-btn_primary weui-btn_disabled" onclick="showPay()" id="buy_button" disabled>立刻购买</button>
        </div>

        <div style="padding: 15px; padding-top: 0;"><label><input name="law" type="checkbox" value="" id="btnCheckReverse" />同意  <a href="/law">《用户购买协议》</a> </label> </div>

        <div class="detail">{!!$product->intro!!}</div>
    </div>

    <div id="gou_mai_tishi">最新订单来自<span id="name">佳子</span> <span id="time">15</span>秒前</div>

    <div class="pay" style="display: none;">
      <div class="pay-selector">
        <div class="header">请选择支付方式 <div class="close" onclick="closePay()"></div></div>
        <div class="body">
            <!-- 微信公众号支付 -->
            @if ($open_wechat_pay)
            <div class="pay-item pay-weixin" onclick="buyCard()">微信支付</div>
            @endif
            <!-- 微信支付，个人转账 -->
            @if ($open_weixin_pay)
                <div class="pay-item pay-weixin" onclick="paysApi()">微信支付</div>
            @endif

            @if ($open_ali_pay)
              <div class="pay-item pay-ali" onclick="paysApiAli()">支付宝支付</div>
            @endif

            @if ($open_ali_pay_mobile)
              <div class="pay-item pay-ali" onclick="aliPay()">支付宝支付</div>
            @endif
            <!--div class="pay-item pay-union" onclick="pingpay('union')">银联支付</div-->
        </div>
      </div>
    </div>
    
    <form style='display:none;' id='formpay' name='formpay' method='post' action='https://pay.paysapi.com'>
        <input name='goodsname' id='goodsname' type='text' value='' />
        <input name='istype' id='istype' type='text' value='' />
        <input name='key' id='key' type='text' value=''/>
        <input name='notify_url' id='notify_url' type='text' value=''/>
        <input name='orderid' id='orderid' type='text' value=''/>
        <input name='orderuid' id='orderuid' type='text' value=''/>
        <input name='price' id='price' type='text' value=''/>
        <input name='return_url' id='return_url' type='text' value=''/>
        <input name='uid' id='uid' type='text' value=''/>
        <input type='submit' id='submitdemo1'>
    </form>
@endsection


@section('js')
    <script src="{{ asset('ap.js') }}"></script>
    <script type="text/javascript">
        var users = [];
        var index = 0;
        var cardId = 0;
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/members_justnow',
                type: 'GET',
                success: function(data) {
                    users = data.message;
                    if (users.length == 0) {return;}
                    $('#name').text(users[index].nickname);
                    //$('#gou_mai_tishi img').attr('src', users[index++].header);
                    $('#time').text(parseInt(59*Math.random()));
                    $('#gou_mai_tishi').fadeIn().delay(4000).fadeOut('slow');
                    if (index >= users.length) {
                        index = 0;
                    }

                    setInterval(function(){
                        $('#name').text(users[index].nickname);
                        //$('#gou_mai_tishi img').attr('src', users[index++].header);
                        $('#time').text(parseInt(59*Math.random()+1));
                        $('#gou_mai_tishi').fadeIn().delay(4000).fadeOut('slow');
                        if (index >= users.length) {
                            index = 0;
                        }
                    }, 8000)
                },
            });
        });


        $("#btnCheckReverse").change(function() { 
            if ($("#btnCheckReverse").is(':checked')) {
                $('#buy_button').removeAttr("disabled"); 
                $('#buy_button').removeClass("weui-btn_disabled"); 
            }else{
                $('#buy_button').attr("disabled",true); 
                $('#buy_button').addClass("weui-btn_disabled"); 
            }
        });

        function showPay() {
            if (cardId == 0) {
                alert('请选择订阅类型');
                return;
            }
            $('.pay').show();
        }

        function closePay() {
            $('.pay').hide();
        }

        //PAYS API
        function paysApi() {
            event.preventDefault();
            closePay()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/pays_api?type=2&card_id='+cardId,
                type: 'GET',
                success: function(data) {
                    //提示成功消息
                    if (data.code == 1) {
                        var $toast = $('#toast');
                        $('#toast-info').text(data.message);
                        $toast.fadeIn(100);
                        setTimeout(function () {
                            $toast.fadeOut(100);
                        }, 2000);
                        return;
                    }
                    //调起支付
                    //data = JSON.parse(data.message);
                    $("#goodsname").val(data.message.goodsname);
                    $("#istype").val(data.message.istype);
                    $('#key').val(data.message.key);
                    $('#notify_url').val(data.message.notify_url);
                    $('#orderid').val(data.message.orderid);
                    $('#orderuid').val(data.message.orderuid);
                    $('#price').val(data.message.price);
                    $('#return_url').val(data.message.return_url);
                    $('#uid').val(data.message.uid);
                    $('#submitdemo1').click();
                },
            });
        }

        function paysApiAli() {
            event.preventDefault();
            closePay()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/pays_api?type=1&card_id='+cardId,
                type: 'GET',
                success: function(data) {
                    //提示成功消息
                    if (data.code == 1) {
                        var $toast = $('#toast');
                        $('#toast-info').text(data.message);
                        $toast.fadeIn(100);
                        setTimeout(function () {
                            $toast.fadeOut(100);
                        }, 2000);
                        return;
                    }
                    //调起支付
                    //data = JSON.parse(data.message);
                    $("#goodsname").val(data.message.goodsname);
                    $("#istype").val(data.message.istype);
                    $('#key').val(data.message.key);
                    $('#notify_url').val(data.message.notify_url);
                    $('#orderid').val(data.message.orderid);
                    $('#orderuid').val(data.message.orderuid);
                    $('#price').val(data.message.price);
                    $('#return_url').val(data.message.return_url);
                    $('#uid').val(data.message.uid);
                    $('#submitdemo1').click();
                },
            });
        }

        function buyCard() {
            event.preventDefault();
            closePay()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/buy_card',
                type: 'GET',
                success: function(data) {
                    //提示成功消息
                    if (data.code == 1) {
                        //alert(data.message);
                        var $toast = $('#toast');
                        $('#toast-info').text(data.message);
                        $toast.fadeIn(100);
                        setTimeout(function () {
                            $toast.fadeOut(100);
                        }, 2000);
                        return;
                    }

                    data = JSON.parse(data.message);

                    /* global WeixinJSBridge:true */
                    WeixinJSBridge.invoke(
                      'getBrandWCPayRequest', {
                        'appId': data.appId, // 公众号名称，由商户传入
                        'timeStamp': data.timeStamp, // 时间戳，自1970年以来的秒数
                        'nonceStr': data.nonceStr, // 随机串
                        'package': data.package,
                        'signType': data.signType, // 微信签名方式：
                        'paySign': data.paySign // 微信签名
                      },
                      function (res) {
                        // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
                        if (res.err_msg === 'get_brand_wcpay_request:ok') {
                            //alert('支付成功');
                            var $toast = $('#toast');
                            $('#toast-info').text('支付成功');
                            $toast.fadeIn(100);
                            setTimeout(function () {
                                $toast.fadeOut();
                                window.location.href = '/hkj';
                            }, 2000);
                            
                        } else {
                          //alert('支付失败,错误信息: ' + res.err_msg)
                          $('#g_iosDialog2_text').text('支付失败,错误信息: ' + res.err_msg);
                          $('#g_iosDialog2').fadeIn(200);
                        }
                      }
                    )
                },
            });
        }

        function aliPay() {
            event.preventDefault();
            closePay();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/buy_card_alipay?card_id='+cardId,
                type: 'GET',
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        _AP.pay(data.message);
                    }else{
                        var $toast = $('#toast');
                        $('#toast-info').text(data.message);
                        $toast.fadeIn(100);
                        setTimeout(function () {
                            $toast.fadeOut(100);
                        }, 2000);
                    }
                },
            });
        }

        function buyCard3rd() {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/buy_card_third',
                type: 'GET',
                success: function(data) {
                    //提示成功消息
                    if (data.code == 1) {
                        var $toast = $('#toast');
                        $('#toast-info').text(data.message);
                        $toast.fadeIn(100);
                        setTimeout(function () {
                            $toast.fadeOut(100);
                        }, 2000);
                        return;
                    }
                    /* global WeixinJSBridge:true */
                    WeixinJSBridge.invoke(
                      'getBrandWCPayRequest', {
                        'appId': data.message.appId, // 公众号名称，由商户传入
                        'timeStamp': data.message.timeStamp, // 时间戳，自1970年以来的秒数
                        'nonceStr': data.message.nonceStr, // 随机串
                        'package': data.message.pack,
                        'signType': data.message.signType, // 微信签名方式：
                        'paySign': data.message.paySign // 微信签名
                      },
                      function (res) {
                        // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
                        if (res.err_msg === 'get_brand_wcpay_request:ok') {
                            window.location.href = '/hkj';
                        } else {
                          //alert('支付失败,错误信息: ' + res.err_msg)
                          $('#g_iosDialog2_text').text('支付失败,错误信息: ' + res.err_msg);
                          $('#g_iosDialog2').fadeIn(200);
                        }
                      }
                    )
                },
            });
        }

        $('.member-card').on('click', function(){
            $('.member-card').removeClass('active');
            $(this).addClass('active');
            cardId = $(this).attr('card-id');
        })
    </script>
@endsection

