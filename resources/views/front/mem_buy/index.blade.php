@extends('front.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
    <style type="text/css">
        .pay-selector .close{
            background-image: url({{ asset('images/close-product.png') }}); 

        }
        .pay-weixin{background-image: url({{ asset('images/pay-weixin.png') }})}
        .pay-ali{background-image: url({{ asset('images/pay-alipay.png') }})}
        .pay-union{background-image: url({{ asset('images/pay-union.png') }})}
        
        body {
            background-color: #272727;
            margin: 0;
        }

    }
    </style>
@endsection

@section('title')
    <title>VIP订阅</title>
@endsection

@section('content')
    <div class="nav_tip">
      <div class="img" style="margin-left: 15px;">
        <a href="javascript:history.go(-1)"><i class="backTo"></i></a>
      </div>
      <p class="titile">升级会员</p>
    </div>

    <div class="user_info">
        <div class="user_name">{{ $user->nickname }}</div>
        <div class="user_level">@if($user->level_name) {{ $user->level_name }} @else 普通用户 @endif</div>
    </div>
    <div class="box">
        <div class="wrap">
            <?php $index  = 1; ?>
            @foreach($userLevels as $userLevel)

                @if ($index  == 1)
                    <div class="item">
                        <div class="pic">
                            <img src="{{ asset('images/card/level.png') }}" alt="">
                            <p class="user_txt">{{ $userLevel->name }}</p>
                        </div>
                        {{-- <div class="tip">{{ $userLevel->name }}</div> --}}
                        <ul>
                            <li><i class="icon1"></i>1.最新口子浏览权限</li>
                            <li><i class="icon1"></i>2.直播教学学习权限</li>
                            <li><i class="icon1"></i>3.会员推广权限</li>
                            <li><i class="icon2"></i>4.中级会员音视频课程</li>
                            <li><i class="icon2"></i>5.高级级会员音视频课程</li>
                        </ul>
                        <div class="time">有效期：{{ $userLevel->days }}天</div>
                        <div class="price">价格：<span>¥{{ $userLevel->money }}</span></div>

                        @if ($user->member && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($user->member_end_time)))

                            @if ($user->mem_level > $userLevel->level)
                                <div class="btn">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        已拥有
                                    </p>
                                </div>
                            @endif

                            @if ($user->mem_level == $userLevel->level)
                                <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        续费
                                    </p>
                                </div>
                            @endif

                            @if ($user->mem_level < $userLevel->level)
                                <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        立即升级
                                    </p>
                                </div> 
                            @endif
                        @else 
                            {{-- 不是会员 --}}
                            <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                <img src="{{ asset('images/card/buy.png') }}" alt="">
                                <p class="btn_txt">
                                    立即购买
                                </p>
                            </div>
                        @endif
                        
                    </div>
                @endif

                @if ($index  == 2)
                    <div class="item">
                        <div class="pic">
                            <img src="{{ asset('images/card/level.png') }}" alt="">
                            <p class="user_txt">{{ $userLevel->name }}</p>
                        </div>
                        {{-- <div class="tip">{{ $userLevel->name }}</div> --}}
                        <ul>
                            <li><i class="icon1"></i>1.最新口子浏览权限</li>
                            <li><i class="icon1"></i>2.直播教学学习权限</li>
                            <li><i class="icon1"></i>3.会员推广权限</li>
                            <li><i class="icon1"></i>4.中级会员音视频课程</li>
                            <li><i class="icon2"></i>5.高级级会员音视频课程</li>
                        </ul>
                        <div class="time">有效期：{{ $userLevel->days }}天</div>
                        <div class="price">价格：<span>¥{{ $userLevel->money }}</span></div>
                        @if ($user->member && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($user->member_end_time)))

                            @if ($user->mem_level > $userLevel->level)
                                <div class="btn">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        已拥有
                                    </p>
                                </div>
                            @endif

                            @if ($user->mem_level == $userLevel->level)
                                <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        续费
                                    </p>
                                </div>
                            @endif

                            @if ($user->mem_level < $userLevel->level)
                                <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        立即升级
                                    </p>
                                </div>
                            @endif
                        @else 
                            {{-- 不是会员 --}}
                            <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                <img src="{{ asset('images/card/buy.png') }}" alt="">
                                <p class="btn_txt">
                                    立即购买
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($index  == 3)
                    <div class="item">
                        <div class="pic">
                            <img src="{{ asset('images/card/level.png') }}" alt="">
                            <p class="user_txt">{{ $userLevel->name }}</p>
                        </div>
                        {{-- <div class="tip">{{ $userLevel->name }}</div> --}}
                        <ul>
                            <li><i class="icon1"></i>1.最新口子浏览权限</li>
                            <li><i class="icon1"></i>2.直播教学学习权限</li>
                            <li><i class="icon1"></i>3.会员推广权限</li>
                            <li><i class="icon1"></i>4.中级会员音视频课程</li>
                            <li><i class="icon1"></i>5.高级级会员音视频课程</li>
                        </ul>
                        <div class="time">有效期：{{ $userLevel->days }}天</div>
                        <div class="price">价格：<span>¥{{ $userLevel->money }}</span></div>
                        @if ($user->member && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($user->member_end_time)))

                            @if ($user->mem_level > $userLevel->level)
                                <div class="btn">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        已拥有
                                    </p>
                                </div>
                            @endif

                            @if ($user->mem_level == $userLevel->level)
                                <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        续费
                                    </p>
                                </div>
                            @endif

                            @if ($user->mem_level < $userLevel->level)
                                <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                    <img src="{{ asset('images/card/buy.png') }}" alt="">
                                    <p class="btn_txt">
                                        立即升级
                                    </p>
                                </div>
                            @endif
                        @else 
                            {{-- 不是会员 --}}
                            <div class="btn" onclick="buy_mem({{ $userLevel->id }})">
                                <img src="{{ asset('images/card/buy.png') }}" alt="">
                                <p class="btn_txt">
                                    立即购买
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <?php $index++; ?>
            @endforeach
        </div>
    </div>



    <div class="pay" style="display: none;">
      <div class="pay-selector">
        <div class="header">请选择支付方式 <div class="close" onclick="closePay()"></div></div>
        <div class="body">
            @if ($open_wechat_pay)
            <div class="pay-item pay-weixin" onclick="buyCard()">微信支付</div>
            @endif
            <!-- 微信支付，个人转账 -->
            {{-- @if ($open_weixin_pay)
                <div class="pay-item pay-weixin" onclick="paysApi()">微信支付</div>
            @endif --}}

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
        var cardId = 0;
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
        
        /**
         * 微信公众号支付
         * @return {[type]} [description]
         */
        function buyCard() {
            event.preventDefault();
            closePay()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/buy_card?cardId='+cardId,
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
                                window.location.href = '/';
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

        /**
         * 支付宝支付
         * @return {[type]} [description]
         */
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

        function buy_mem(id){
            cardId = id;
            showPay();
        }

    </script>
@endsection

