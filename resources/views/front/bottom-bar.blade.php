<style type="text/css">
    .weui-tabbar{position: fixed; background-color: #fff;}
    .weui-tabbar .weui-tabbar__item{
        width: 20%;
    }
</style>

<div class="weui-tabbar">
    <!--a href="/" class="weui-tabbar__item">
        @if (Request::is('/'))
            <img src="{{ asset('images/share_theme/tabbar/1-2.png') }}" alt="" class="weui-tabbar__icon">
        @else
            <img src="{{ asset('images/share_theme/tabbar/1.png') }}" alt="" class="weui-tabbar__icon">
        @endif
        
        <p class="weui-tabbar__label">首页</p>
    </a-->
    <a href="/" class="weui-tabbar__item">
        @if ($index == 1)
            <img src="{{ asset('images/share_theme/tabbar/1-2.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label active">首页</p>
        @else
            <img src="{{ asset('images/share_theme/tabbar/1.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">首页</p>
        @endif
    </a>
    <a href="/all_level" class="weui-tabbar__item">
        @if ($index == 2)
            <img src="{{ asset('images/share_theme/tabbar/2-2.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label active">学习</p>
        @else
            <img src="{{ asset('images/share_theme/tabbar/2.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">学习</p>
        @endif
    </a>
    <a href="/lives" class="weui-tabbar__item">
        @if ($index == 3)
            <img src="{{ asset('images/share_theme/tabbar/3-2.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label active">直播</p>
        @else
            <img src="{{ asset('images/share_theme/tabbar/3.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">直播</p>
        @endif
    </a>
    <a href="/tools" class="weui-tabbar__item">
        @if ($index == 4)
            <img src="{{ asset('images/share_theme/tabbar/4-2.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label active">工具</p>
        @else
            <img src="{{ asset('images/share_theme/tabbar/4.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">工具</p>
        @endif
    </a>
    <a href="/user_center" class="weui-tabbar__item">
        @if ($index == 5)
            <img src="{{ asset('images/share_theme/tabbar/5-2.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label active">个人中心</p>
        @else
            <img src="{{ asset('images/share_theme/tabbar/5.png') }}" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">个人中心</p>
        @endif
        
    </a>
</div>