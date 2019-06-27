

{{-- <li class="treeview {{ Request::is('shop/settings/setting*') || Request::is('shop/wechat/menu*') || Request::is('shop/wechat/reply*') || Request::is('shop/cities*') || Request::is('shop/freightTems*') || Request::is('shop/freightTems*') || Request::is('shop/customerServices*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-commenting"></i> <span>设置</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        
    </ul>
</li> --}}

<li class="header">设置</li>
<li class="{{ Request::is('shop/settings/setting*') ? 'active' : '' }}">
    <a href="{!! route('settings.setting') !!}"><i class="fa fa-edit"></i><span>商城设置</span></a>
</li>

@if(funcOpen('FUNC_MANY_SHOP'))
<li class="header">店铺管理</li>
{{-- <li class="{{ Request::is('shop/cats*') ? 'active' : '' }}">
    <a href="{!! route('cats.index') !!}"><i class="fa fa-edit"></i><span>店铺分类管理</span></a>
</li> --}}
<li class="{{ Request::is('shop/stores*') ? 'active' : '' }}">
    <a href="{!! route('stores.index') !!}"><i class="fa fa-edit"></i><span>店铺管理</span></a>
</li>
@endif

{{-- <li class="header">商务需求</li>
<li class="{{ Request::is('shop/projects*') ? 'active' : '' }}">
    <a href="{!! route('projects.index') !!}"><i class="fa fa-edit"></i><span>商务需求管理</span></a>
</li> --}}

{{-- <li class="header">{{ getSettingValueByKeyCache('credits_alias') }}卡</li>
<li class="{{ Request::is('shop/cards*') ? 'active' : '' }}">
    <a href="{!! route('cards.index') !!}"><i class="fa fa-edit"></i><span>{{ getSettingValueByKeyCache('credits_alias') }}卡管理</span></a>
</li> --}}
<li class="header">其他设置</li>
{{-- @if(Config::get('web.FUNC_WECHAT'))
<li class="{{ Request::is('shop/wechat/menu*') || Request::is('shop/wechat/reply*') ? 'active' : '' }}">
    <a href="{!! route('wechat.menu') !!}"><i class="fa fa-weixin"></i><span>微信设置</span></a>
</li>
@endif --}}
<li class="{{ Request::is('shop/cities*') || Request::is('shop/freightTems*') || Request::is('shop/freightTems*') ? 'active' : '' }}">
    <a href="{!! route('cities.index') !!}"><i class="fa fa-edit"></i><span>物流设置</span></a>
</li>

{{-- 
<li class="{{ Request::is('shop/customerServices*') ? 'active' : ''  }}">
    <a href="{!! route('customerServices.index') !!}"><i class="fa fa-edit"></i><span>客服设置</span></a>
</li>

<li class="{{ Request::is('shop/keFuFeedBacks*') ? 'active' : ''  }}">
    <a href="{!! route('keFuFeedBacks.index') !!}"><i class="fa fa-edit"></i><span>客服反馈</span></a>
</li> --}}

<li class="">
    <a href="javascript:;" id="refresh"><i class="fa fa-trash-o"></i><span>清理缓存</span></a>
</li>
{{-- <li class="header">管理</li> --}}
{{-- @if(funcOpen('AUTH_CERTS'))
<li class="{{ Request::is('shop/certs*') ? 'active' : '' }}">
    <a href="{!! route('certs.index') !!}"><i class="fa fa-edit"></i><span>实名认证管理</span></a>
</li>
@endif --}}
{{-- <li class="{{ Request::is('shop/banners*') || Request::is('shop/*/bannerItems*') ? 'active' : '' }}">
    <a href="{!! route('banners.index') !!}"><i class="fa fa-edit"></i><span>内容管理</span></a>
</li> --}}
{{-- <li class="{{ Request::is('shop/users*') || Request::is('shop/userLevels*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>会员管理</span></a>
</li>
<li class="{{ Request::is('shop/managers*') || Request::is('shop/roles*') || Request::is('shop/permissions*') ? 'active' : '' }}">
    <a href="{!! route('managers.index') !!}"><i class="fa fa-sliders"></i><span>权限管理</span></a>
</li> --}}
{{-- @if(Config::get('web.FUNC_POST'))
<li class="{{ Request::is('shop/articlecats') || Request::is('shop/articlecats/create') || Request::is('shop/posts') || Request::is('shop/posts/create') || Request::is('shop/customPostTypes*') ? 'active' : '' }}">
        <a href="{!! route('articlecats.index') !!}"><i class="fa fa-bars"></i><span>话题管理</span></a>
</li>
@endif --}}
{{-- <li class="header">话题管理</li>
<li class="treeview {{ Request::is('shop/articlecats') || Request::is('shop/articlecats/create') || Request::is('shop/posts') || Request::is('shop/posts/create') || Request::is('shop/customPostTypes*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-commenting"></i> <span>话题管理</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('shop/articlecats') ? 'active' : '' }}">
            <a href="{!! route('articlecats.index') !!}"><i class="fa fa-bars"></i><span>话题分类</span></a>
        </li>
        <li class="{{ Request::is('shop/articlecats/create') ? 'active' : '' }}">
            <a href="{!! route('articlecats.create') !!}"><i class="fa fa-bars"></i><span>添加分类</span></a>
        </li>
        <li class="{{ Request::is('shop/posts') ? 'active' : '' }}">
            <a href="{!! route('posts.index') !!}"><i class="fa fa-newspaper-o"></i><span>话题列表</span></a>
        </li>
        <li class="{{ Request::is('shop/posts/create') ? 'active' : '' }}">
            <a href="{!! route('posts.create') !!}"><i class="fa fa-newspaper-o"></i><span>添加话题</span></a>
        </li>

        <!--li class="{{ Request::is('shop/customPostTypes*') || Request::is('shop/*/customPostTypeItems*') ? 'active' : '' }}">
            <a href="{!! route('customPostTypes.index') !!}"><i class="fa fa-calendar-plus-o"></i><span>自定义文章类型</span></a>
        </li-->
    </ul>
</li>
 --}}
{{-- @if(funcOpen('FUNC_MEMBER_LEVEL'))
    <li class="{{ Request::is('shop/userLevels*') ? 'active' : '' }}">
        <a href="{!! route('userLevels.index') !!}"><i class="fa fa-edit"></i><span>会员等级</span></a>
    </li>
@endif --}}

{{-- <li class="treeview {{ Request::is('shop/users*') || Request::is('shop/userLevels*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-diamond"></i> <span>会员管理</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        
    </ul>
</li> --}}
{{-- <li class="{{ Request::is('shop/notices*') ? 'active' : '' }}">
    <a href="{!! route('notices.index') !!}"><i class="fa fa-envelope-o"></i><span>通知消息</span></a>
</li>

@if(Config::get('web.FUNC_FOOTER'))
<li class="{{ Request::is('shop/singelPages*') ? 'active' : '' }}">
    <a href="{!! route('singelPages.index') !!}"><i class="fa fa-edit"></i><span>业务介绍</span></a>
</li>
@endif --}}

{{-- <li class="treeview {{ Request::is('shop/setting*') || Request::is('shop/settings/themeSetting*') || Request::is('shop/banners*') || Request::is('shop/*/bannerItems*') || Request::is('shop/singelPages*') || Request::is('shop/notices*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-cog"></i> <span>基本设置</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('shop/settings/setting*') ? 'active' : '' }}">
            <a href="{!! route('settings.setting') !!}"><i class="fa fa-edit"></i><span>网站设置</span></a>
        </li>
        <li class="{{ Request::is('shop/settings/system') ? 'active' : '' }}">
            <a href="{!! route('settings.system') !!}"><i class="fa fa-edit"></i><span>系统功能</span></a>
        </li>
        @if( Config::get('web.FUNC_THEME') || Config::get('web.FUNC_COLOR'))
        <li class="{{ Request::is('shop/settings/themeSetting*') ? 'active' : '' }}">
            <a href="{!! route('settings.themeSetting') !!}"><i class="fa fa-edit"></i><span>主题设置</span></a>
        </li>
        @endif
    </ul>
</li> --}}

@if(funcOpen('FUNC_PRODUCT_LOCATION'))
<li class="{{ Request::is('shop/countries*') ? 'active' : '' }}">
    <a href="{!! route('countries.index') !!}"><i class="fa fa-edit"></i><span>产地设置</span></a>
</li>
@endif      
        

@if(funcOpen('FUNC_FUNDS'))
<!--li class="{{ Request::is('shop/withDrawls*')? 'active' : '' }}">
    <a href="{!! route('withDrawls.index') !!}"><i class="fa fa-edit"></i><span>钱包用户操作记录</span></a>
</li-->
@endif





{{-- <li class="treeview {{ Request::is('shop/customerServices*') || Request::is('shop/bankSets*') || Request::is('shop/cities*') || Request::is('shop/countries*') || Request::is('shop/freightTems*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-archive"></i> <span>商城设置</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        
        
        @if(funcOpen('FUNC_CASH_WITHDRWA'))
        <li class="{{ Request::is('shop/bankSets*') ? 'active' : '' }}">
            <a href="{!! route('bankSets.index') !!}"><i class="fa fa-edit"></i><span>银行卡设置</span></a>
        </li>
        @endif
        
    </ul>
</li> --}}



