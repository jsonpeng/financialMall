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
    background-color: #fff;
    border-radius: 5px;
  }
  .container .product-list .product-grid .grid-box {
    border-radius: 6px;
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
  }
  .container .product-list .product-grid .grid-box .sell-num {
    font-size: 12px;
    color: #999;
    text-align: center;
    margin: 6px 0;
  }
  .container .product-list .product-grid .grid-box .apply-price {
  /*font-size: 12px;
  color: #999;
  text-align: center;*/
    font-size: 12px;
    color: #8493a3;
    line-height: 19px;
    text-align: center;
  }
  .container .product-list .product-grid .grid-box .apply-price span {
    /*font-size: 20px;
    font-weight: 600;
    color: #fe5d4f;
    padding-left: 6px;*/
      color: #fe5b4f;
      margin-left: 5px;
  }
  .container .product-list .product-grid .grid-box .apply-price span:nth-of-type(2){
    margin-left: 2px;
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


  .agent-title{
    background: #fff;
      height: 35px;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-align: center;
      align-items: center;
      padding-left: 20px;
      font-size: 15px;
      color: #505153;
  }
  .agent-title img{
      width: 25px;
      height: 25px;
      border-radius: 50%;
      margin-right: 5px;
  }
</style>
@endsection

@section('title')
    <title>贷款平台</title>
@endsection

@section('content')
{{--   <div class="header">
      <a href="/" class="go_return">返回首页</a><p>码上贷</p>
  </div> --}}
    <div class="container">
        <div class="index-banner">
            <img src="{{ asset('images/sharedk/banner1.jpg') }}" class="lazy"  alt="" style="display:block;width:100%; height:auto; display: block;">
        </div>
        <div class="agent-title">
          {!! $user->nickname !!}的专属贷超
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
              <div class="product-grid">
                <a class="grid-box" href="/share_xyk/view/{!! $element->id !!}?i={!! $user->id !!}">
                  <div class="product-name">
                    <img src="{!! $element->image !!}" alt="">
                    <p>{!! $element->name !!}</p>
                  </div>
                  <div class="product-content">
                    <p class="sell-num">{!! $element->applied !!}人已申请</p>
                    <p class="apply-price">最高额度
                      <span>¥</span><span>{!! $element->max_mount !!}</span>
                    </p>
                    </p>
                  </div>
                </a>
              </div>
            @endforeach
            <div class="cb"></div>
        </div>

        <div style="clear: both;"></div>
        
        <div class="all-product">
            <img src="{{ asset('images/sharedk/icon1.png') }}" alt="" class="icon1">
            <div class="product-sum" style="background:url('images/sharedk/icon11.png') no-repeat left center;    background-size: 30px 25px;">
                贷款产品 <span>( 共{!! $share_dks->count() !!}款 )</span>
            </div>
            <div> </div>
        </div>
        <div class="product-list">
            @foreach($share_dks as $element)
              <div class="product-grid">
                <a class="grid-box" href="/share_dk/view/{!! $element->id !!}?i={!! $user->id !!}">
                  <div class="product-name">
                    <img src="{!! $element->image !!}" alt="">
                    <p>{!! $element->name !!}</p>
                  </div>
                  <div class="product-content">
                    <p class="sell-num">{!! $element->applied !!}人已申请</p>
                    <p class="apply-price">最高额度
                      <span>¥</span><span>{!! $element->max_mount !!}</span>
                    </p>
                    </p>
                  </div>
                </a>
              </div>
            @endforeach
            <div class="cb"></div>
        </div>
@endsection


{{-- @section('js')
  <script>
    function GetQueryString(name) {
       var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
       var r = window.location.search.substr(1).match(reg);
       if (r!=null) return unescape(r[2]); 
       return null;
    }
    var invitor = GetQueryString('i');
    if (invitor) {
      localStorage.setItem('zcjy_invitor_id', invitor);
    }
  </script>
@endsection --}}
