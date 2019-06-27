<?php
	#订单管理
    $order_active = Request::is('shop/orders*') || Request::is('shop/orderCancels*') || Request::is('shop/orderRefunds*') || Request::is('shop/refundMoneys*');
    #产品管理
    $product_active = Request::is('shop/products*') || Request::is('shop/all_products*') || Request::is('shop/categories*') || Request::is('shop/brands*')  || Request::is('shop/word_products*')   || Request::is('shop/specs*');
    #规格管理
    $spec_active = Request::is('shop/productTypes*') || Request::is('shop/specs*') || Request::is('shop/productAttrs*');
    #商品促销
    $product_promp_active = Request::is('shop/productPromps*');
    #订单促销
   	$order_promp_active = Request::is('shop/orderPromps*');
    #优惠券
    $coupon_active = Request::is('shop/coupons*') || Request::is('shop/couponRules*');
    #秒杀抢购
    $flashsales_active = Request::is('shop/flashSales*');
    #拼团
    $teamsales_active = Request::is('shop/teamSales*');
?>

<ul class="nav nav-pills nav-stacked nav-email">
@if($order_active)
	<li class="{{ Request::is('shop/orders*') && empty(Request::get('menu_type'))? 'active' : '' }}">
	    <a href="{!! route('orders.index') !!}"><i class="fa fa-edit"></i><span>全部订单</span></a>
	</li>
	@if(funcOpen('FUNC_FLASHSALE'))
	<li class="{{ Request::get('menu_type')=='1'?'active':'' }}">
		<a href="{!! route('orders.index').varifyOrderType('秒杀订单') !!}"><i class="fa fa-edit"></i><span>秒杀订单</span></a>
	</li>
	@endif

	@if(funcOpen('FUNC_TEAMSALE'))
	<li class="{{ Request::get('menu_type')=='5'?'active':'' }}">
		<a href="{!! route('orders.index').varifyOrderType('拼团订单') !!}"><i class="fa fa-edit"></i><span>拼团订单</span></a>
	</li>
	@endif

	<li class="{{ Request::get('menu_type')=='6'?'active':'' }}">
		<a href="{!! route('orders.index').varifyOrderType('发货单') !!}"><i class="fa fa-edit"></i><span>发货单</span></a>
	</li>
{{-- 	<li class="{{ Request::is('shop/orderCancels*') ? 'active' : '' }}">
		<a href="{!! route('orderCancels.index') !!}"><i class="fa fa-edit"></i><span>退款单</span></a>
	</li> --}}

	@if(funcOpen('FUNC_AFTERSALE'))
	<li class="{{ Request::is('shop/orderRefunds*') ? 'active' : '' }}">
		<a href="{!! route('orderRefunds.index') !!}"><i class="fa fa-edit"></i><span>退换货</span></a>
	</li>
	@endif

	<li class="{{ Request::is('shop/refundMoneys*') ? 'active' : '' }}">
		<a href="{!! route('refundMoneys.index') !!}"><i class="fa fa-edit"></i><span>退款查询</span></a>
	</li>
@elseif($product_active)
	<li class="{{ Request::is('shop/products*') && !Request::is('shop/products/create') ? 'active' : '' }}">
	    <a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>产品列表</span></a>
	</li>
	<li class="{{ Request::is('shop/products/create') ? 'active' : '' }}">
	    <a href="{!! route('products.create') !!}"><i class="fa fa-edit"></i><span>添加产品</span></a>
	</li>
	<li class="{{ Request::is('shop/all_products/allLowGoods*')?'active':'' }}">
	    <a href="{!! route('products.alllow') !!}"><i class="fa fa-edit"></i><span>库存报警</span></a>
	</li>
	<li class="{{ Request::is('shop/categories*') ? 'active' : '' }}">
	    <a href="{!! route('categories.index') !!}"><i class="fa fa-edit"></i><span>分类信息</span></a>
	</li>
	@if(funcOpen('FUNC_BRAND'))
	<li class="{{ Request::is('shop/brands*') ? 'active' : '' }}">
	    <a href="{!! route('brands.index') !!}"><i class="fa fa-edit"></i><span>品牌</span></a>
	</li>
	@endif
	<li class="{{ Request::is('shop/word_products*') ? 'active' : '' }}">
	    <a href="{!! route('wordlist.index') !!}"><i class="fa fa-edit"></i><span>产品保障</span></a>
	</li>
@elseif($spec_active)
	<li class="{{ Request::is('shop/productTypes*') ? 'active' : '' }}">
	    <a href="{!! route('productTypes.index') !!}">
	        <span class="badge pull-right"></span>
	        <i class="fa fa-user"></i> 模型
	    </a>
	</li>
	<li class="{{ Request::is('shop/specs*') ? 'active' : '' }}">
	    <a href="{!! route('specs.index') !!}">
	        <span class="badge pull-right"></span>
	        <i class="fa fa-users"></i> 规格
	    </a>
	</li>
	<li class="{{ Request::is('shop/productAttrs*') ? 'active' : '' }}">
	    <a href="{!! route('productAttrs.index') !!}">
	        <span class="badge pull-right"></span>
	        <i class="fa fa-key"></i> 属性
	    </a>
	</li>
@elseif($product_promp_active)
	<li class="{{ Request::is('shop/productPromps') ? 'active' : '' }}">
	    <a href="{!! route('productPromps.index') !!}"><i class="fa fa-edit"></i><span>商品促销</span></a>
	</li>
	<li class="{{ Request::is('shop/productPromps/create*') ? 'active' : '' }}">
	    <a href="{!! route('productPromps.create') !!}"><i class="fa fa-edit"></i><span>添加促销</span></a>
	</li>
@elseif($order_promp_active)
	<li class="{{ Request::is('shop/orderPromps') ? 'active' : '' }}">
	        <a href="{!! route('orderPromps.index') !!}"><i class="fa fa-edit"></i><span>订单促销</span></a>
	    </li>
	<li class="{{ Request::is('shop/orderPromps/create') ? 'active' : '' }}">
	<a href="{!! route('orderPromps.create') !!}"><i class="fa fa-edit"></i><span>添加促销</span></a>
	</li>
@elseif($coupon_active)
	<li class="{{ Request::is('shop/coupons') ? 'active' : '' }}">
	    <a href="{!! route('coupons.index') !!}"><i class="fa fa-edit"></i><span>优惠券</span></a>
	</li>
	 <li class="{{ Request::is('shop/coupons/create') ? 'active' : '' }}">
	    <a href="{!! route('coupons.create') !!}"><i class="fa fa-edit"></i><span>添加优惠券</span></a>
	</li>
	<li class="{{ Request::is('shop/couponRules*') ? 'active' : '' }}">
	    <a href="{!! route('couponRules.index') !!}"><i class="fa fa-edit"></i><span>自动发放</span></a>
	</li>
	<li class="{{ Request::is('shop/coupons/given*') ? 'active' : '' }}">
	    <a href="{!! route('coupons.integer') !!}"><i class="fa fa-edit"></i><span>手动发放</span></a>
	</li>
@elseif($flashsales_active)
	<li class="{{ Request::is('shop/flashSales') ? 'active' : '' }}">
	    <a href="{!! route('flashSales.index') !!}"><i class="fa fa-edit"></i><span>活动管理</span></a>
	</li>
	<li class="{{ Request::is('shop/flashSales/create') ? 'active' : '' }}">
	    <a href="{!! route('flashSales.create') !!}"><i class="fa fa-edit"></i><span>添加秒杀</span></a>
	</li>
@elseif($teamsales_active)
	<li class="{{ Request::is('shop/teamSales') ? 'active' : '' }}">
	    <a href="{!! route('teamSales.index') !!}"><i class="fa fa-edit"></i><span>拼团管理</span></a>
	</li>
	<li class="{{ Request::is('shop/teamSales/create') ? 'active' : '' }}">
	    <a href="{!! route('teamSales.create') !!}"><i class="fa fa-edit"></i><span>添加拼团</span></a>
	</li>
@endif
</ul>