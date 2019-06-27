<li class="header">内容管理</li>
@if(adminCan('文章编辑', 'admin'))

<li class="treeview @if( Request::is('zcjy/banners*') || Request::is('zcjy/soundPostCats*') || Request::is('zcjy/soundPosts*') || Request::is('zcjy/*/bannerItems*') || Request::is('zcjy/categories*') || Request::is('zcjy/posts*') || Request::is('zcjy/hkjCats*') || Request::is('zcjy/hkjs*') || Request::is('zcjy/platFormCats*') || Request::is('zcjy/platForms*') || Request::is('zcjy/creditCardBanks*') || Request::is('zcjy/creditCardThemes*') || Request::is('zcjy/creditCards*') || Request::is('zcjy/middleLevelInfos*') || Request::is('zcjy/highLevelInfos*') || Request::is('zcjy/tools*') || Request::is('zcjy/toolCats*') || Request::is('zcjy/super_kecheng*') || Request::is('zcjy/lives*')|| Request::is('zcjy/notices*') || Request::is('zcjy/advertorials*') || Request::is('zcjy/paperTypes*') ||  Request::is('zcjy/paperLists*') || Request::is('zcjy/testRecords*') || Request::is('zcjy/topics*') || Request::is('zcjy/selectionsTopics*')) || Request::is('zcjy/gaobaos*')) active @endif " >

  <a href="#">
    <i class="fa fa-cogs"></i>
    <span>内容管理</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>  
  <ul class="treeview-menu">

  @if(adminCan('网站设置'))
    <li class="{{ Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems*') ? 'active' : '' }}">
      <a href="{!! route('banners.index') !!}"><i class="fa fa-object-group"></i><span>横幅管理</span></a>
    </li>
  @endif
  
  @if (Config::get('zcjy.OPEN_SHARE'))
{{--   <li class="treeview @if(Request::is('zcjy/categories*') || Request::is('zcjy/posts*') ) active @endif " >
    <a href="#">
      <i class="fa fa-flag"></i>
      <span>文章管理</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li class="{{ Request::is('zcjy/categories*') ? 'active' : '' }}">
          <a href="{!! route('categoriescat.index') !!}"><i class="fa fa-edit"></i><span>文章分类</span></a>
      </li>

      <li class="{{ Request::is('zcjy/posts*') ? 'active' : '' }}">
          <a href="{!! route('posts.index') !!}"><i class="fa fa-edit"></i><span>文章</span></a>
      </li>
    </ul>
  </li>   --}}


  @if (Config::get('zcjy.EDIT_HKJ'))
  <li class="treeview @if(Request::is('zcjy/hkjCats*') || Request::is('zcjy/hkjs*') ) active @endif " >
    <a href="#">
      <i class="fa fa-fire"></i>
      <span>黑科技</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

      @if(adminCan('网站设置'))
        <li class="{{ Request::is('zcjy/hkjCats*') ? 'active' : '' }}">
          <a href="{!! route('hkjCats.index') !!}"><i class="fa fa-edit"></i><span>黑科技分类</span></a>
        </li>
       @endif

      <li class="{{ Request::is('zcjy/hkjs*') ? 'active' : '' }}">
          <a href="{!! route('hkjs.index') !!}"><i class="fa fa-edit"></i><span>黑科技</span></a>
      </li>
    </ul>
  </li>
  @endif
  @endif   

  @if(adminCan('网站设置'))
    <li class="treeview @if(Request::is('zcjy/paperTypes*') ||  Request::is('zcjy/paperLists*') || Request::is('zcjy/testRecords*') ||  Request::is('zcjy/*/topics*') || Request::is('zcjy/*/selectionsTopics*')) active @endif " >
    <a href="#">
      <i class="fa fa-fire"></i>
      <span>试题考试</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

   {{--    <li class="{{ Request::is('zcjy/paperTypes*') ? 'active' : '' }}">
        <a href="{!! route('paperTypes.index') !!}"><i class="fa fa-edit"></i><span>试卷分类</span></a>
      </li> --}}

      <li class="{{ Request::is('zcjy/paperLists*') || Request::is('zcjy/*/topics*') || Request::is('zcjy/*/selectionsTopics*')  ? 'active' : '' }}">
          <a href="{!! route('paperLists.index') !!}"><i class="fa fa-edit"></i><span>试卷管理</span></a>
      </li>

      <li class="{{ Request::is('zcjy/testRecords*') ? 'active' : '' }}">
          <a href="{!! route('testRecords.index') !!}"><i class="fa fa-edit"></i><span>考试记录</span></a>
      </li>
      
    </ul>
  </li>
  @endif
{{--   @if (Config::get('zcjy.OPEN_SHARE'))
    <li class="treeview @if(Request::is('zcjy/paperTypes*') ||  Request::is('zcjy/paperLists*') || Request::is('zcjy/testRecords*') ||  Request::is('zcjy/*/topics*') || Request::is('zcjy/*/selectionsTopics*')) active @endif " >
    <a href="#">
      <i class="fa fa-fire"></i>
      <span>试题考试</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

      <li class="{{ Request::is('zcjy/paperTypes*') ? 'active' : '' }}">
        <a href="{!! route('paperTypes.index') !!}"><i class="fa fa-edit"></i><span>试卷分类</span></a>
      </li>

      <li class="{{ Request::is('zcjy/paperLists*') || Request::is('zcjy/*/topics*') || Request::is('zcjy/*/selectionsTopics*')  ? 'active' : '' }}">
          <a href="{!! route('paperLists.index') !!}"><i class="fa fa-edit"></i><span>试卷管理</span></a>
      </li>

      <li class="{{ Request::is('zcjy/testRecords*') ? 'active' : '' }}">
          <a href="{!! route('testRecords.index') !!}"><i class="fa fa-edit"></i><span>考试记录</span></a>
      </li>
      
    </ul>
  </li>
  @endif --}}
@if(adminCan('分化平台'))
  @if (Config::get('zcjy.EDIT_CREDIT_CARD'))
    <li class="treeview @if( Request::is('zcjy/platFormCats*') || Request::is('zcjy/platForms*') ) active @endif " >
      <a href="#">
        <i class="fa fa-usd"></i>
        <span>贷款</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>  
      <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/platFormCats*') ? 'active' : '' }}">
            <a href="{!! route('platFormCats.index') !!}"><i class="fa fa-edit"></i><span>平台分类</span></a>
        </li>
        <li class="{{ Request::is('zcjy/platForms*') ? 'active' : '' }}">
            <a href="{!! route('platForms.index') !!}"><i class="fa fa-edit"></i><span>借贷平台</span></a>
        </li>
      </ul>
    </li>

{{--     <li class="{{ Request::is('zcjy/gonglues*') ? 'active' : '' }}">
      <a href="{!! route('gonglues.index') !!}"><i class="fa fa-edit"></i><span>攻略</span></a>
    </li> --}}
  @endif

  @if (Config::get('zcjy.OPEN_SHARE'))
  <li class="treeview @if( Request::is('zcjy/creditCardBanks*') || Request::is('zcjy/creditCardThemes*') || Request::is('zcjy/creditCards*') ) active @endif " >
    <a href="#">
      <i class="fa fa-credit-card"></i>
      <span>信用卡</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>  
    <ul class="treeview-menu">
      {{-- <li class="{{ Request::is('zcjy/creditCardBanners*') ? 'active' : '' }}">
          <a href="{!! route('creditCardBanners.index') !!}"><i class="fa fa-edit"></i><span>信用卡横幅</span></a>
      </li> --}}
      <li class="{{ Request::is('zcjy/creditCardBanks*') ? 'active' : '' }}">
          <a href="{!! route('creditCardBanks.index') !!}"><i class="fa fa-edit"></i><span>银行</span></a>
      </li>

  {{--     <li class="{{ Request::is('zcjy/creditCardThemes*') ? 'active' : '' }}">
          <a href="{!! route('creditCardThemes.index') !!}"><i class="fa fa-edit"></i><span>主题</span></a>
      </li> --}}

      <li class="{{ Request::is('zcjy/creditCards*') ? 'active' : '' }}">
          <a href="{!! route('creditCards.index') !!}"><i class="fa fa-edit"></i><span>信用卡</span></a>
      </li>
    </ul>
  </li>

  @else 

  @endif
  @endif
    
  @if (Config::get('zcjy.OPEN_SHARE'))
{{--   <li class="{{ Request::is('zcjy/gaobaos*') ? 'active' : '' }}">
    <a href="{!! route('gaobaos.index') !!}"><i class="fa fa-edit"></i><span>高爆口子</span></a>
  </li> --}}
  <li class="treeview @if( Request::is('zcjy/soundPosts*') || Request::is('zcjy/middleLevelInfos*')  || Request::is('zcjy/soundPostCats*') )  active @endif " >
    <a href="#">
      <i class="fa fa-edit"></i>
      <span>音频课程管理</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a> 

    <ul class="treeview-menu">

      @if(adminCan('网站设置'))
        <li class="{{ Request::is('zcjy/soundPostCats*') ? 'active' : '' }}">
            <a href="{!! route('soundPostCats.index') !!}"><i class="fa fa-edit"></i><span>系列分类</span></a>
        </li>
  <!--       <li class="{{ Request::is('zcjy/soundPosts*') ? 'active' : '' }}">
          <a href="{!! route('soundPosts.index') !!}"><i class="fa fa-edit"></i><span>系列</span></a>
        </li> -->
      @endif

      <li class="{{ Request::is('zcjy/middleLevelInfos*') ? 'active' : '' }}">
          <a href="{!! route('middleLevelInfos.index') !!}"><i class="fa fa-edit"></i><span>课程</span></a>
      </li>
    </ul>
  </li>
{{--   <li class="{{ Request::is('zcjy/super_kecheng') ? 'active' : '' }}">
      <a href="/zcjy/super_kecheng"><i class="fa fa-edit"></i><span>特级课程</span></a>
  </li> --}}
  @if(adminCan('网站设置'))
  <li class="{{ Request::is('zcjy/lives*') ? 'active' : '' }}">
    <a href="{!! route('lives.index') !!}"><i class="fa fa-edit"></i><span>直播</span></a>
  </li>
  <li class="{{ Request::is('zcjy/notices*') ? 'active' : '' }}">
      <a href="{!! route('notices.index') !!}"><i class="fa fa-edit"></i><span>通知消息</span></a>
  </li>

  <li class="{{ Request::is('zcjy/toolCats*') ? 'active' : '' }}">
      <a href="{!! route('toolCats.index') !!}"><i class="fa fa-edit"></i><span>工具分类</span></a>
  </li>
  <li class="{{ Request::is('zcjy/tools*') ? 'active' : '' }}">
      <a href="{!! route('tools.index') !!}"><i class="fa fa-edit"></i><span>工具</span></a>
  </li>

{{--   
  <li class="{{ Request::is('zcjy/advertorials*') ? 'active' : '' }}">
    <a href="{!! route('advertorials.index') !!}"><i class="fa fa-edit"></i><span>推广软文</span></a>
  </li> --}}
  @endif

  @endif
</ul>
</li>

@endif

@if (Config::get('zcjy.OPEN_SHARE'))
  @if(adminCan('分化平台', 'admin'))
  <li class="header">分化平台</li>
  <li class="{{ Request::is('zcjy/shareDks*') ? 'active' : '' }}">
    <a href="{!! route('shareDks.index') !!}"><i class="fa fa-edit"></i><span>码上贷口子</span></a>
  </li>
  @endif

  @if(adminCan('会员管理', 'admin'))
  <li class="{{ Request::is('zcjy/shareDkRecords*') ? 'active' : '' }}">
      <a href="{!! route('shareDkRecords.index') !!}"><i class="fa fa-edit"></i><span>申请记录</span></a>
  </li>
  <li class="{{ Request::is('zcjy/cashWithdraws*') ? 'active' : '' }}">
    <a href="{!! route('cashWithdraws.index') !!}"><i class="fa fa-edit"></i><span>提现申请</span></a>
  </li>
  {{-- <li class="{{ Request::is('zcjy/submitForms*') ? 'active' : '' }}">
      <a href="{!! route('submitForms.index') !!}"><i class="fa fa-edit"></i><span>贷款记录</span></a>
  </li> --}}
  @endif

@else
  <li class="{{ Request::is('submitInfoLogs*') ? 'active' : '' }}">
    <a href="{!! route('submitInfoLogs.index') !!}"><i class="fa fa-edit"></i><span>用户信息</span></a>
  </li>
@endif

{{-- memOrders --}}

@if(adminCan('会员管理', 'admin'))
<li class="header">会员卡订单管理</li>
 <li class="{{ Request::is('zcjy/memOrders*') ? 'active' : '' }}">
    <a href="{!! route('memOrders.index') !!}"><i class="fa fa-edit"></i><span>订单管理</span></a>
  </li>
  <li class="{{ Request::is('zcjy/stat/tongji*') ? 'active' : '' }}">
    <a href="{!! route('tongji.index') !!}"><i class="fa fa-edit"></i><span>会员卡统计</span></a>
  </li>
 
<li class="header">会员管理</li>
<li class="treeview @if( Request::is('zcjy/user_list*') || Request::is('zcjy/levels*') || Request::is('zcjy/products*') || Request::is('zcjy/userLevels*') || Request::is('zcjy/orders*')  ) active @endif " >
  <a href="#">
    <i class="fa fa-cogs"></i>
    <span>会员管理</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>  
  <ul class="treeview-menu">
{{--     @if (!Config::get('zcjy.OPEN_SHARE'))
    <li class="{{ Request::is('zcjy/products*') ? 'active' : '' }}">
      <a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>会员介绍</span></a>
    </li>
    @endif --}}
    <li class="{{ Request::is('zcjy/levels*') ? 'active' : '' }}">
      <a href="{!! route('levels.index') !!}"><i class="fa fa-edit"></i><span>会员等级管理</span></a>
  </li>
    <li class="{{ Request::is('zcjy/user_list*') ? 'active' : '' }}">
      <a href="{!! route('user.user_list') !!}"><i class="fa fa-edit"></i><span>会员列表</span></a>
    </li>
    <li class="{{ Request::is('zcjy/userLevels*') ? 'active' : '' }}">
      <a href="{!! route('userLevels.index') !!}"><i class="fa fa-edit"></i><span>会员卡</span></a>
    </li>
  {{--   <li class="{{ Request::is('zcjy/orders*') ? 'active' : '' }}">
      <a href="{!! route('orders.index') !!}"><i class="fa fa-edit"></i><span>会员卡订单</span></a>
    </li> --}}
  </ul>
</li>

<li class="header">达人管理</li>
<li class="{{ Request::is('zcjy/amazingMen*') ? 'active' : '' }}">
    <a href="{!! route('amazingMen.index') !!}"><i class="fa fa-user"></i><span>达人管理</span></a>
</li>

@endif



{{-- <li class="treeview @if( Request::is('zcjy/user_list*') || Request::is('zcjy/moneyRecords*') || Request::is('zcjy/orders*') ) active @endif " >
  <a href="#">
    <i class="fa fa-users"></i>
    <span>会员信息</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>  
  <ul class="treeview-menu">


  </ul>
</li>
<li class="treeview @if( Request::is('zcjy/userLevels*') || Request::is('zcjy/products*') || Request::is('zcjy/orders*') ) active @endif " >
  <a href="#">
    <i class="fa fa-users"></i>
    <span>会员卡信息</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>  
  <ul class="treeview-menu">
      
  </ul>
</li> --}}

{{-- <li class="treeview @if( Request::is('zcjy/posApplies*') || Request::is('zcjy/posIntros*') ) active @endif " >
  <a href="#">
    <i class="fa fa-users"></i>
    <span>POS机领取</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>  
  <ul class="treeview-menu">
    <li class="{{ Request::is('zcjy/posIntros*') ? 'active' : '' }}">
        <a href="{!! route('posIntros.index') !!}"><i class="fa fa-edit"></i><span>POS机业务介绍</span></a>
    </li>
    <li class="{{ Request::is('zcjy/posApplies*') ? 'active' : '' }}">
        <a href="{!! route('posApplies.index') !!}"><i class="fa fa-edit"></i><span>POS申请列表</span></a>
    </li>
  </ul>
</li>

<li class="treeview @if( Request::is('zcjy/xykIntros*') || Request::is('zcjy/xykApplies*') ) active @endif " >
  <a href="#">
    <i class="fa fa-users"></i>
    <span>信用卡代还</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>  
  <ul class="treeview-menu">
    </li><li class="{{ Request::is('zcjy/xykIntros*') ? 'active' : '' }}">
        <a href="{!! route('xykIntros.index') !!}"><i class="fa fa-edit"></i><span>信用卡带还业务介绍</span></a>
    </li>
    <li class="{{ Request::is('zcjy/xykApplies*') ? 'active' : '' }}">
      <a href="{!! route('xykApplies.index') !!}"><i class="fa fa-edit"></i><span>信用卡申请表</span></a>
    </li>
    
  </ul>
</li> --}}


@if(adminCan('网站设置', 'admin'))
<li class="header">设置</li>
<li class="treeview @if( Request::is('zcjy/settings*') || Request::is('zcjy/payAlis*')  ) active @endif " >
  <a href="#">
    <i class="fa fa-cogs"></i>
    <span>网站设置</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>  
  <ul class="treeview-menu">
    <li class="{{ Request::is('zcjy/settings/service_protocal') ? 'active' : '' }}">
      <a href="/zcjy/settings/service_protocal"><i class="fa fa-edit"></i><span>服务协议</span></a>
    </li>
    @if (Config::get('zcjy.OPEN_SHARE'))
    <li class="{{ Request::is('zcjy/settings/sale_protocal') ? 'active' : '' }}">
      <a href="/zcjy/settings/sale_protocal"><i class="fa fa-edit"></i><span>购买协议</span></a>
    </li>

    @endif

    <li class="{{ Request::is('zcjy/settings/intro') ? 'active' : '' }}">
      <a href="/zcjy/settings/intro"><i class="fa fa-edit"></i><span>平台介绍</span></a>
    </li>

    @if(adminCan('网站设置', 'admin'))
    <li class="{{ Request::is('zcjy/settings*') && !Request::is('zcjy/settings/service_protocal') && !Request::is('zcjy/settings/sale_protocal') && !Request::is('zcjy/settings/intro') ? 'active' : '' }}">
        <a href="{!! route('settings.index') !!}"><i class="fa fa-edit"></i><span>网站设置</span></a>
    </li>
    @endif

  </ul>
</li>

<li class="header">反馈管理</li>

<li class="{{ Request::is('zcjy/complaintLogs*') ? 'active' : '' }}">
    <a href="{!! route('complaintLogs.index') !!}"><i class="fa fa-edit"></i><span>反馈记录</span></a>
</li>

@endif

{{-- <li class="{{ Request::is('productLevelPrices*') ? 'active' : '' }}">
    <a href="{!! route('productLevelPrices.index') !!}"><i class="fa fa-edit"></i><span>Product Level Prices</span></a>
</li> --}}



{{-- <li class="{{ Request::is('levelSounds*') ? 'active' : '' }}">
    <a href="{!! route('levelSounds.index') !!}"><i class="fa fa-edit"></i><span>Level Sounds</span></a>
</li>
 --}}


{{-- <li class="{{ Request::is('amazingManPosts*') ? 'active' : '' }}">
    <a href="{!! route('amazingManPosts.index') !!}"><i class="fa fa-edit"></i><span>Amazing Man Posts</span></a>
</li> --}}

{{-- <li class="{{ Request::is('attachUserLevels*') ? 'active' : '' }}">
    <a href="{!! route('attachUserLevels.index') !!}"><i class="fa fa-edit"></i><span>Attach User Levels</span></a>
</li>
 --}}
{{-- <li class="{{ Request::is('userPosts*') ? 'active' : '' }}">
    <a href="{!! route('userPosts.index') !!}"><i class="fa fa-edit"></i><span>User Posts</span></a>
</li> --}}


{{-- <li class="{{ Request::is('soundPostUserLogs*') ? 'active' : '' }}">
    <a href="{!! route('soundPostUserLogs.index') !!}"><i class="fa fa-edit"></i><span>Sound Post User Logs</span></a>
</li> --}}


