@extends('front.base')

@section('css')
	@include('front.share_dk.css')
@endsection

@section('title')
    <title>{!! $daikuan->name !!}</title>
@endsection

@section('content')
	<div class="header">
      <a href="javascript:history.go(-1)" class="go_return">返回</a><p>码上贷</p>
  	</div>
	<div class="container">
		{{-- <h4 class="product-title">{!! $daikuan->name !!}</h4> --}}
		<div class="product-banner">
			<img src="{!! $daikuan->image !!}" alt="">
			<p>{!! $daikuan->name !!}</p>
			<div class="sell-sum">{!! $daikuan->applied !!}人已代理</div>
			<div class="sell-style">
				{!! $daikuan->period !!}
			</div>
		</div>
		<div class="profit">
			<div class="profit-model">
				<div class="profit-head">
					<img src="{{ asset('images/sharedk/icon13.png') }}" alt="">
					<p>佣金获得方式</p>
				</div>
				<div class="profit-remark">
					( 奖励规则：仅限<span>新用户</span>注册申请 )
				</div>
			</div>
			<div class="profit-flow">
				<div class="step">
					<img src="{{ asset('images/sharedk/step1.png') }}" alt="">
					<p>填写申请资料</p>
				</div>
				<img src="{{ asset('images/sharedk/arrow.png') }}" alt="" class="arrow">
				<div class="step">
					<img src="{{ asset('images/sharedk/step2.png') }}" alt="">
					<p>在码上贷申请审批</p>
				</div>
				<img src="{{ asset('images/sharedk/arrow.png') }}" alt="" class="arrow"> 
				<div class="step">
					<img src="{{ asset('images/sharedk/step3.png') }}" alt="">
					<p>审核后佣金到账</p>
				</div>
			</div>
		</div>
		<div class="reward" style="background-color: #fff;">
			<div class="profit-model">
				<div class="profit-head">
					<img src="{{ asset('images/sharedk/icon13.png') }}" alt="">
					<p>奖励佣金</p>
				</div>
			</div>
			<div class="reward-list">
				@if ($daikuan->money_level1)
					<div class="reward-item">
						<h4>{!! $daikuan->money_level1 !!} @if($daikuan->return_type == '固定金额') 元 @else % @endif</h4>
						<p>一级合伙人</p>
					</div>
				@endif

				@if ($daikuan->money_level2)
					<div class="reward-item">
						<h4>{!! $daikuan->money_level2 !!} @if($daikuan->return_type == '固定金额') 元 @else % @endif</h4>
						<p>二级合伙人</p>
					</div>
				@endif

				@if ($daikuan->money_level3)
					<div class="reward-item">
						<h4>{!! $daikuan->money_level3 !!} @if($daikuan->return_type == '固定金额') 元 @else % @endif</h4>
						<p>三级合伙人</p>
					</div>
				@endif
			</div>
		</div>
		<div class="skip-bottom">
			<a @if ($user->can_share == '是' || $user->member) href="/share_dk/code/{!! $daikuan->id !!}" @else onclick="shareCommon()"  @endif >生成链接或二维码</a>
		</div>
	</div>

@endsection

@section('js')
  <script>
    function shareCommon(){
      $('#g_iosDialog1').fadeIn(200);
    }
  </script>
@endsection
