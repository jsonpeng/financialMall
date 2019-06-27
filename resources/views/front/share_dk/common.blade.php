@extends('front.base')

@section('css')
	<style type="text/css">
		.main-bg{
		  margin:0 26px;
		}
		.container .product-title {
		  padding: 16px 0;
		  font-size: 18px;
		  text-align: center;
		  background-color: #fff;
		}
		.tabbar{
		  display: flex;
		  position:fixed;
		  background-color:#fff;
		  z-index: 500;
		  left:0;
		  bottom: 0;
		  width: 100%;
		}
		.tabbar .tabbar-item{
		  display: block;
		  flex:1;
		  text-align:center;
		  padding:4px 0;
		}
		
		.tabbar .tabbar-item img{
			display: inline-block;
			width:15px;
		  	height:15px;
		}
		.tabbar .tabbar-item .tabbar-label{
		  font-size: 14px;
		  color:#2c2c2c;
		}
		#zhezhao{
		  position:fixed;
		  top:0;
		  bottom:0;
		  left:0;
		  right:0;
		  z-index: 1000;
		  background-color: rgba(0,0,0,0.7);
		}
		.link-box {
			position:fixed;
			z-index: 1001;
			width:80%;
			max-width: 300px;
			top:50%;
			left:50%;
			transform: translate(-50%, -50%);
		  	border-radius: 20px;
		  	background: -webkit-gradient(linear, left top, right top, from(#60b3f8), to(#527ee0));
		}
		.link-box h4{
			font-size: 18px;
			line-height: 37px;
			height:37px;
			text-align:center;
			background-color: #fff;
			border-top-left-radius: 18.5px;
			border-top-right-radius: 18.5px;
		}
		.link-box .kuang{
		  	height:175px;
		  	margin:22px 18px 18px 18px;
		  	border:2px solid #fff;
		  	border-radius: 18.5px;
		  	padding: 15px;
    		word-wrap: break-word;
		}
	</style>
@endsection

@section('title')
    <title>我的专属超贷</title>
@endsection

@section('content')
	<div class="header">
      <a href="javascript:history.go(-1)" class="go_return">返回</a><p>码上贷</p>
  	</div>
	<div class="container">
		<h4 class="product-title">我的专属超贷</h4>
		<div class="main-bg">
			<img src="{{ $img_url }}" alt="" style="display:block;width:100%; height:auto;">
		</div>
		<div class="tabbar">
			<a href="javascript:;" class="tabbar-item" id="copy" onclick="popup()">
				<span style="display: inline-block;">
					<img src="{{ asset('images/sharedk/copy.png') }}" alt="">
				</span>
				<p class="tabbar-label">复制链接</p>
			</a>
			<a href="" class="tabbar-item">
				<span style="display: inline-block;">
					<img src="{{ asset('images/sharedk/zhuanfa.png') }}" alt="">
				</span>
				<p class="tabbar-label">分享给朋友</p>
			</a>
		</div>
	</div>
	<div class="zhezhao-box" style="display: none;">
		<div id="zhezhao"></div>
		<div class="link-box">
			<h4>请手动复制下方链接</h4>
			<div class="kuang">{!! $share_link !!}</div>
		</div>
	</div>

@endsection

@section('js')
	<script>
		var zhezhao=document.getElementById('zhezhao');
		function popup(){
			zhezhao.parentNode.style.display="block";

		}
		zhezhao.onclick=function(e){
			this.parentNode.style.display="none";
		}

		function runShare(title, desc, link, imgUrl, sig) {
			wx.config({
				debug: true,
				appId: sig.appId,
				timestamp: sig.timestamp,
				nonceStr: sig.nonceStr,
				signature: sig.signature,
				jsApiList: ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo"]
			}), 
			wx.error(function(e) {
				alert(JSON.parse(e))
			}), 
			wx.ready(function() {
				wx.onMenuShareTimeline({
					title: title,
					link: link,
					desc: desc,
					imgUrl: imgUrl,
					success: function() {
						
					},
					cancel: function() {}
				}), wx.onMenuShareAppMessage({
					title: title,
					desc: desc,
					link: link,
					imgUrl: imgUrl,
					type: "",
					dataUrl: "",
					success: function() {
						
					},
					cancel: function() {}
				}), wx.onMenuShareQQ({
					title: title,
					desc: desc,
					link: link,
					imgUrl: imgUrl,
					success: function() {
						
					},
					cancel: function() {}
				}), wx.onMenuShareWeibo({
					title: title,
					desc: desc,
					link: link,
					imgUrl: imgUrl,
					success: function() {
						
					},
					cancel: function() {}
				})
			})
		}

		$(document).ready(function() {

		});
	</script>
@endsection
