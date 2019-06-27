
<li class="header">统计</li>
<li class="{{ Request::is('shop/stat*') ? 'active' : '' }}">
    <a href="{!! route('stat.index') !!}"><i class="fa fa-edit"></i><span>统计信息</span></a>
</li>
<li class="header">管理</li>
<?php
    $active = Request::is('shop/orders*') || Request::is('shop/orderCancels*') || Request::is('shop/orderRefunds*') || Request::is('shop/refundMoneys*');
?>

<li class="{{ $active ? 'active' : '' }}">
        <a href="{!! route('orders.index') !!}"><i class="fa fa-laptop"></i><span>订单管理</span></a>
</li>

<?php
    $active2 = Request::is('shop/products*') || Request::is('shop/all_products*') || Request::is('shop/categories*') || Request::is('shop/brands*')  || Request::is('shop/word_products*') ;
?>

<li class="{{ $active2 ? 'active' : '' }}">
        <a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>产品管理</span></a>
</li>

<li class="{{ Request::is('shop/productTypes*') || Request::is('shop/specs*') || Request::is('shop/productAttrs*') ? 'active' : '' }}">
            <a href="{!! route('productTypes.index') !!}"><i class="fa fa-edit"></i><span>规格管理</span></a>
</li>



{{-- <li class="treeview @if($active2) active @endif">
    <a href="#">
    <i class="fa fa-laptop"></i>
        <span>产品管理</span>
    <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" @if($active2) style="display: block;" @else style="display: none;" @endif >
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
        <li class="{{ Request::is('shop/productTypes*') || Request::is('shop/specs*') || Request::is('shop/productAttrs*') ? 'active' : '' }}">
            <a href="{!! route('productTypes.index') !!}"><i class="fa fa-edit"></i><span>规格属性</span></a>
        </li>
        <li class="{{ Request::is('shop/word_products*') ? 'active' : '' }}">
            <a href="{!! route('wordlist.index') !!}"><i class="fa fa-edit"></i><span>产品保障</span></a>
        </li>
    </ul>
</li> --}}


<!--li class="{{ Request::is('shop/themes*') ? 'active' : '' }}">
    <a href="{!! route('themes.index') !!}"><i class="fa fa-edit"></i><span>专题</span></a>
</li-->
<!--
<li class="header">规格属性</li>
<li class="{{ Request::is('shop/productTypes*') ? 'active' : '' }}">
    <a href="{!! route('productTypes.index') !!}"><i class="fa fa-edit"></i><span>模型</span></a>
</li>
<li class="{{ Request::is('shop/specs*') ? 'active' : '' }}">
    <a href="{!! route('specs.index') !!}"><i class="fa fa-edit"></i><span>规格</span></a>
</li>
<li class="{{ Request::is('shop/productAttrs*') ? 'active' : '' }}">
    <a href="{!! route('productAttrs.index') !!}"><i class="fa fa-edit"></i><span>属性</span></a>
</li>
-->