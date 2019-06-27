@extends('front.base')

@section('css')
	<style type="text/css">
		.alert ul{list-style: none;}
        #zhichen{display: none;}
	</style>
@endsection

@section('title')
	<title>推荐人</title>
@endsection

@section('content')
    
    <div class="header">
        <a href="/user_center" class="go_return">个人中心</a><p>推荐人</p>
    </div>

    @include('flash::message')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- <div class="weui-cells__title">推荐人列表</div> --}}
    <div class="weui-tab" style="height: 40px; margin-top: 10px;">
        <div class="weui-navbar">
            <a href="/members?level=1" class="weui-navbar__item @if($level == 1) weui-bar__item_on @endif">
                一级合伙人
            </a>
            <a href="/members?level=2" class="weui-navbar__item @if($level == 2) weui-bar__item_on @endif">
                二级合伙人
            </a>
        </div>
    </div>
    @if (count($members) > 0)
    <div class="weui-cells scroll-container">
        @foreach ($members as $member)
            <div class="weui-cell scroll-post">
                <div class="weui-cell__bd">
                    <p>{{$member->nickname}} @if($member->member) ({{$member->level_name}}) @endif</p> 
                </div>
                <div class="weui-cell__ft">{{$member->created_at->format('Y-m-d')}}</div>
            </div>
        @endforeach
        {{$members->links()}}
    </div>
    @else
    <div class="weui-cells__title">您还没有合伙人，加油哦</div>
    @endif

@endsection


@section('js')
    
@endsection