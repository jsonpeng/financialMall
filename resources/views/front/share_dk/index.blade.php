@extends('front.base')

@section('css')
    <style>
      body{
        background-color:#efefef;
      }
      .container .all-product {
        margin-top: 10px;
        padding: 12.5px 10px;
        background-color: #fff;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
            -ms-flex-pack: justify;
                justify-content: space-between;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
      }
      .container .all-product .icon1 {
        width: 25px;
        height: 25px;
      }
      .container .all-product .product-sum {
        font-size: 15px;
        font-weight: bold;
        line-height: 25px;
        height: 25px;
        padding-left: 30px;
        background: url({{ asset('images/sharedk/icon2.png') }}) no-repeat left center;
        background-size: 30px 25px;
      }
      .container .all-product .product-sum span {
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
        color: #3da5e0;
        height: 25px;
        line-height: 25px;
      }
      
      .container .product-list {
        margin: 15px 10px 0 10px;
        
        position: relative;
        
      }
      .container .product-list .product-grid {
        width: 33.33333%;
        float: left;
        padding: 0 8px;
        margin-bottom: 24px;
        -webkit-box-sizing: border-box;
                box-sizing: border-box;
        position: relative;
        border-radius: 5px;
      }
      .container .product-list .product-grid .grid-box {
        border-radius: 6px;
        background-color: #fff;
      }
      .container .product-list .product-grid .grid-box .product-name {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
       padding-left: 8px;
       padding-top: 16px;
      }
      .container .product-list .product-grid .grid-box .product-name img {
        display: block;
        width: 30px;
        height: 30px;
        margin-right: 8px;
      }
      .container .product-list .product-grid .grid-box .product-name p {
        font-size: 14px;
        font-weight: 600;
        line-height: 30px;
        white-space: nowrap;
        overflow: hidden;
      }
      .container .product-list .product-grid .grid-box .sell-num {
        font-size: 12px;
        color: #999;
        text-align: center;
        margin: 6px 0;
      }
      .container .product-list .product-grid .grid-box .sell-price {
        font-size: 12px;
        color: #999;
        text-align: center;
      }
      .container .product-list .product-grid .grid-box .sell-price span {
        font-size: 20px;
        font-weight: 600;
        color: #fe5d4f;
        padding-left: 6px;
      }
      .container .product-list .product-grid .account {
        position: absolute;
        left: 6px;
        top: -10px;
        font-size: 12px;
        width: 50px;
        height: 24px;
        line-height: 20px;
        text-align: center;
        color: #fff;
        background: url({{ asset('images/sharedk/icon3.png') }}) no-repeat;
        background-size: cover;
      }
      .container .link-line {
        margin: 0 10px 18px 10px;
        padding: 10px 14px;
        background: -webkit-gradient(linear, left top, right top, from(#60b3f8), to(#527ee0));
        background: linear-gradient(left, #60b3f8, #527ee0);
        border-radius: 63px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
            -ms-flex-pack: justify;
                justify-content: space-between;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
      }
      .container .link-line .gou {
        padding: 8px 6px;
        border-radius: 50%;
        background-color: #fff;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
      }
      .container .link-line .gou img {
        display: block;
        width: 24px;
        height: 20px;
      }
      .container .link-line p {
        font-size: 18px;
        font-weight: 600;
        color: #fff;
      }
      .container .link-line .finger img{
          width:30px;
          height:35px;
      }
    </style>
@endsection

@section('title')
    <title>码上贷</title>
@endsection

@section('content')
  <div class="header">
      <a href="javascript:history.go(-1)" class="go_return">返回</a><p>码上贷</p>
  </div>
    <div class="container">
        <div class="index-banner">
            <img src="{{ asset('images/sharedk/banner1.jpg') }}" class="lazy"  alt="" style="display:block;width:100%; height:auto; display: block;">
        </div>
        <div class="all-product" style="margin-top: 0;">
            <img src="{{ asset('images/sharedk/icon1.png') }}" alt="" class="icon1">
            <div class="product-sum">
                信用卡产品 <span>( 共{!! $share_xyks->count() !!}款 )</span>
            </div>
            <div> </div>
        </div>
        <div class="product-list">
            @foreach($share_xyks as $element)
                <a class="product-grid" href="/share_dk/{!! $element->id !!}">
                    <div class="grid-box">
                        <div class="product-name">
                            <img src="{!! $element->image !!}" alt="">
                            <p>{!! $element->name !!}</p>
                        </div>
                        <p class="sell-num">{!! $element->applied !!}人已代理</p>
                        <div class="sell-price">佣金<span>@if($element->return_type == '固定金额') {!! $element->money_level1 !!}元 @else {!! $element->money_level1 !!}% @endif</span></div>
                    </div>
                    <div class="account">{!! $element->period !!}</div>
                </a>
            @endforeach
            <div class="cb"></div>
        </div>
        <a style="width: 100%; clear: both; display: block;" @if ($user->can_share == '是' || $user->member) href="/share_common" @else onclick="shareCommon()"  @endif>
            <div class="link-line" >
                <div class="gou">
                    <img src="{{ asset('images/sharedk/icon10.png') }}" alt="">
                </div>
                <p>一 键 生 成 我 的 专 属 贷 超</p>
                <div class="finger">
                    <img src="{{ asset('images/sharedk/icon9.png') }}" alt="">
                </div>
            </div>
        </a>
        <div class="all-product">
            <img src="{{ asset('images/sharedk/icon1.png') }}" alt="" class="icon1">
            <div class="product-sum" style="background:url('images/sharedk/icon11.png') no-repeat left center;    background-size: 30px 25px;">
                贷款产品 <span>( 共{!! $share_dks->count() !!}款 )</span>
            </div>
            <div> </div>
        </div>
        <div class="product-list">
            @foreach($share_dks as $element)
                <a class="product-grid" href="/share_dk/{!! $element->id !!}">
                    <div class="grid-box">
                        <div class="product-name">
                            <img src="{!! $element->image !!}" alt="">
                            <p>{!! $element->name !!}</p>
                        </div>
                        <p class="sell-num">{!! $element->applied !!}人已代理</p>
                        <div class="sell-price">佣金<span>@if($element->return_type == '固定金额') {!! $element->money_level1 !!}元 @else {!! $element->money_level1 !!}% @endif</span></div>
                    </div>
                    <div class="account">{!! $element->period !!}</div>
                </a>
            @endforeach
            <div class="cb"></div>
        </div>
@endsection


@section('js')
  <script>
    function shareCommon(){
      $('#g_iosDialog1').fadeIn(200);
    }
    
  </script>
@endsection
