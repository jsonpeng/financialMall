@extends('front.base')

@section('css')
	<style type="text/css">
		#zhichen{display: none;}
        /*.user-header{
            background-image: url('{{ asset('images/user-header-bg.png') }}');
            background-size: cover;
            text-align: center;
            color: #fff;
            padding-bottom: 15px;
        }
        .user-header img{margin-top: 25px; margin-bottom: 5px;}
        .user-header h4{font-size: 20px;}
        .user-header p{font-size: 14px; color: #fff;}*/

        .sec-wrapper{display: flex; font-size: 14px; line-height: 30px; width: 100%; margin-top: 15px;}
        .sec-wrapper .sec{flex: 1; text-align: center;}
        .weui-media-box_appmsg .weui-media-box__hd{width: 40px; height: 40px;}
        .user-header{
            color: #fff;
            padding-bottom: 15px;

            background: -webkit-linear-gradient(left, #61b6f9, #527edf); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(right, #61b6f9, #527edf); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(right, #61b6f9, #527edf); /* Firefox 3.6 - 15 */
            background: linear-gradient(to right, #61b6f9, #527edf); /* 标准的语法（必须放在最后） */
        }

        .member_end_time{
            background-image: url('{{ asset('images/vip-gold.png') }}');
            background-position: left center;
            background-size: 14px;
            background-repeat: no-repeat;
            font-size: 12px;
        }
        
	</style>
@endsection

@section('title')
	<title>用户中心</title>
@endsection

@section('content')
    <div class="user-header">
        {{-- <img class="weui-media-box__thumb" style="border-radius: 50%; height: 100px; width: 100px;" src="@if ($user->header)
            {{$user->header}}
            @else
            {{ asset('images/header.png') }}
        @endif" alt="">
        <h4 class="weui-media-box__title">{{ $user->nickname }}</h4>
 --}}
        <div class="weui-panel__bd">
            <div class="weui-media-box weui-media-box_appmsg" style="color: #fff; border-bottom: none; padding: 20px 30px; padding-bottom: 0;">
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">
                        {{ $user->nickname }} </br>
                        @if ($user->member && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($user->member_end_time)))
                            <span class="member_end_time">推荐码:{{ $user->share_code }} | 会员到期:{{ $user->member_end_time->format('Y-m-d') }}</span>

                            <a href="/member_buy_v2" style="font-size: 12px; color: #fff; font-weight: bold; color: yellow;">续费升级</a>
                        @else
                            <a href="/member_buy_v2" style="font-size: 12px; color: #fff; font-weight: bold; color: yellow;">开通会员</a>
                        @endif
                    </h4>
                </div>
            </div>
        </div>
        <div class="sec-wrapper">
            <div class="sec">金币余额</br>{{ $user->money }}</div>
            <div class="sec">待审核金币</br>{{ $withdraw_pendding }}</div>
            <div class="sec">已提金币</br>{{ $withdraw_done }}</div>
        </div>
    </div>

    <div>   
        <a class="weui-cell weui-cell_access" href="/user_info">
            <div class="weui-cell__hd"><img src="{{ asset('images/usercenter/02.png') }}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>个人信息</p>
            </div>
            <span class="weui-cell__ft"></span>
        </a>
        <a class="weui-cell weui-cell_access" href="/members">
            <div class="weui-cell__hd"><img src="{{ asset('images/usercenter/03.png') }}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>我的会员</p>
            </div>
            <span class="weui-cell__ft"></span>
        </a>
        <a class="weui-cell weui-cell_access" href="/wallet">
            <div class="weui-cell__hd"><img src="{{ asset('images/usercenter/04.png') }}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>钱包</p>
            </div>
            <span class="weui-cell__ft"></span>
        </a>
        

        {{-- <div class="weui-cells__title">信用卡积分兑换</div>
        <a class="weui-cell weui-cell_access" href="/xyk_jifen">
            <div class="weui-cell__hd"><img src="{{ asset('images/usercenter/04.png') }}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>积分兑换</p>
            </div>
            <span class="weui-cell__ft"></span>
        </a>
        <a class="weui-cell weui-cell_access" href="/xyk_jifen_records">
            <div class="weui-cell__hd"><img src="{{ asset('images/usercenter/04.png') }}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>兑换记录</p>
            </div>
            <span class="weui-cell__ft"></span>
        </a> --}}
        
        <div class="weui-cells__title">分享得佣金</div>
        <a class="weui-cell weui-cell_access" href="/share_dks">
            <div class="weui-cell__hd"><img src="{{ asset('images/usercenter/04.png') }}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>推广赚钱</p>
            </div>
            <span class="weui-cell__ft">VIP会员享有终身推广权益</span>
        </a>
        <a class="weui-cell weui-cell_access" href="/share">
            <div class="weui-cell__hd"><img src="{{ asset('images/usercenter/01.png') }}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>分享赚钱</p>
            </div>
            <span class="weui-cell__ft">VIP会员享有终身推广权益</span>
        </a>
        <!--a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII=" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>我的收藏</p>
            </div>
            <span class="weui-cell__ft"></span>
        </a>
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII=" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd weui-cell_primary">
                <p>设置</p>
            </div>
            <span class="weui-cell__ft"></span>
        </a-->
    </div>

    <div style="padding: 30px 15px;">
        <form id="logout-form" action="{{ url('/logout') }}" method="POST">
            {{ csrf_field() }}
            <input type="submit" name="" value="退出登录" class="weui-btn weui-btn_primary">
        </form>
        
    </div>

    @include('front.bottom-bar', ['index' => 5])
@endsection
