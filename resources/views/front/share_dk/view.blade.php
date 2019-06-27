@extends('front.base')

@section('css')

	@include('front.share_dk.css')

 	<style>

 		/*.page .applyWindow{
		    position: fixed;
		    left: 0;
		    top: 0;
		    z-index: 999;
		    width: 100%;
		    height: 100%;
		    background-color: rgba(0,0,0,.3);
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: column;
		    justify-content: flex-end;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage {
		    width: 90%;
		    background-color: #fff;
		    border-radius: 5px;
		    margin-bottom: 30px;
		    position: relative;
		}
		.page .applyWindow .applyBtn {
		    width: 80%;
		    line-height: 45px;
		    color: #fff;
		    font-size: 16px;
		    border-radius: 12px;
		    text-align: center;
		    background-color: #0195ff;
		    margin-bottom: 14px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgTop {
		    width: 200px;
		    line-height: 35px;
		    text-align: center;
		    color: #fff;
		    font-size: 14px;
		    background-color: #0195ff;
		    margin: 0 auto;
		    border-radius: 12px;
		    border-top-left-radius: 0;
		    border-top-right-radius: 0;
		    margin-bottom: 28px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle {

		    padding-right: 20px;
		    padding-left: 20px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom {
		    padding: 15px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName , .input-area{
		    height: 60px;

		    border-bottom: 1px solid #e0e0e0;
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .birthday, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .city, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .dai-money, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .identityCardNumber, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber {
		    height: 60px;
		    width: 100%;
		    border-bottom: 1px solid #e0e0e0;
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName .userNameIcon, .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber .phoneNumberIcon {
		    width: 57px;
		    height: 100%;
		    display: flex;
		    display: -webkit-flex;
		    justify-content: center;
		    -webkit-justify-content: center;
		    align-items: center;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName .userNameIcon .icon {
		    width: 18px;
		    height: 20px;
		    background: url({{ asset('images/xuebitu.png') }}) no-repeat;
		    background-size: 180px 55px;
		    background-position: -95px 0;
		}

		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber .phoneNumberIcon .icon {
		    width: 14px;
		    height: 20px;
		    background: url({{ asset('images/xuebitu.png') }}) no-repeat;
		    background-size: 180px 55px;
		    background-position: -114px 0;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName .line {
		    height: 2px;
		    width: 1px;
		    background-color: #e0e0e0;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .userName input, .page .applyWindow .applyWindowMessage .applyWindowMsgMiddle .phoneNumber input {
		    margin: 0;
		    border: 0;
		    color: #000;
		    line-height: 14px;
		    width: 100%;
		    padding: 10px 5px;
		    -webkit-user-select: text;
		    border-radius: 3px;
		    outline: 0;
		    background-color: #fff;
		    -webkit-appearance: none;
		    font-family: Helvetica Neue,Helvetica,sans-serif;
		    font-size: 14px;
		    -webkit-tap-highlight-color: transparent;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopDes p {
		    color: #aaa;
		    font-size: 12px;
		    line-height: 18px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol {
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		    -webkit-flex-direction: row;
		    align-items: center;
		    -webkit-align-items: center;
		    justify-content: flex-start;
		    -webkit-justify-content: flex-start;
		    color: #aaa;
		    font-size: 12px;
		}
		.agreeProtocolText{padding-left: 5px;}

		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .agreeProtocolIcon, .page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .disagreeProtocolIcon {
		    width: 16px;
		    height: 16px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .disagreeProtocolIcon {
		    background: url({{ asset('images/disagree.jpg') }}) no-repeat 0 0;
		    background-size: 16px 16px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .agreeProtocolIcon {
		    background: url({{ asset('images/agree.jpg') }}) no-repeat 0 0;
		    background-size: 16px 16px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .agreeProtocol .agreeProtocolText a {
		    color: #0195ff;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopTitle{
			margin-top: 10px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopTitle .title {
		    color: #0195ff;
		    font-size: 14px;
		}
		.page .applyWindow .applyWindowMessage .applyWindowMsgBottom .applyWindowMsgTopDes .p_one {
		    color: #e9232c;
		}

		.page .footer {
		    width: 100%;
		    height: 46px;
		    position: fixed;
		    left: 0;
		    bottom: 0;
		    display: flex;
		    display: -webkit-flex;
		    flex-direction: row;
		}
		.page .footer .apply {
		    width: 100%;
		    height: 100%;
		    background-color: #ffa201;
		    text-align: center;
		    line-height: 46px;
		    color: #fff;
		    font-size: 14px;
		}*/
 	</style>
@endsection

@section('title')
    <title>{!! $daikuan->name !!}</title>
@endsection

@section('content')
{{-- 	<div class="header">
      	<a href="/" class="go_return">返回首页</a><p>码上贷</p>
  	</div> --}}
	<div class="page">
		<div class="container">
			<div class="product-banner">
				<img src="{!! $daikuan->image !!}" alt="">
				<p>{!! $daikuan->name !!}</p>
				<div class="sell-sum">{!! $daikuan->applied !!}人已申请</div>
				<p style="padding: 0 15px; font-size: 12px;">{!! $daikuan->des !!}</p>
			</div>
			<div class="profit">
				<div class="profit-model">
					<div class="profit-head">
						<img src="{{ asset('images/sharedk/icon13.png') }}" alt="">
						<p>申请流程</p>
					</div>
				</div>
				<div class="profit-flow">
					<div class="step">
						<img src="{{ asset('images/sharedk/step1.png') }}" alt="">
						<p>填写用户信息</p>
					</div>
					<img src="{{ asset('images/sharedk/arrow.png') }}" alt="" class="arrow">
					<div class="step">
						<img src="{{ asset('images/sharedk/step2.png') }}" alt="">
						<p>获取专属申请通道</p>
					</div>
					<img src="{{ asset('images/sharedk/arrow.png') }}" alt="" class="arrow"> 
					<div class="step">
						<img src="{{ asset('images/sharedk/step3.png') }}" alt="">
						<p>提交申请资料</p>
					</div>
				</div>
			</div>
		</div>
	    
		<div class="footer" onclick="openApplyWindow()">
			<div class="apply">新用户独家申请通道</div>
		</div>

	    <div class="applyWindow" id="applyWindow" style="display: none;">
	    	<div class="applyWindowMessage">
	    		<img src="{{ asset('images/close-product.png') }}" alt="placeholder+image" style="position: absolute; right: 0; top: -40px;" onclick="closeApplyWindow()">
	    		<div class="applyWindowMsgTop">请正确填写您的信息</div> 
	    		<div class="applyWindowMsgMiddle">
		    		<div class="userName input-area">
		    			<div class="userNameIcon">
		    				<div class="icon"></div>
		    			</div> 
		    			<div class="line"></div> 
		    			<input type="text" placeholder="请输入您的姓名" id="name">
		    		</div> 
	    			<div class="phoneNumber input-area">
	    				<div class="phoneNumberIcon">
	    					<div class="icon"></div>
	    				</div> 
	    				<div class="line"></div> 
	    				<input type="number" placeholder="请输入您的手机号" id="mobile" oninput="if(value.length>11)value=value.slice(0,11)">
	    			</div>
	    		</div> 
				<div class="applyWindowMsgBottom">
					<div class="agreeProtocol">
						<div class="disagreeProtocolIcon" onclick="greeBtn(1)"></div> 
						<div class="agreeProtocolIcon" onclick="greeBtn(0)" style="display: none;"></div> 
						<div class="agreeProtocolText">阅读知晓并同意 
							<a href="/law" class="">《服务协议》</a>
						</div>
					</div> 
					<div class="applyWindowMsgTopTitle">
						<div class="logo"></div> 
						<div class="title">注意事项</div>
					</div> 
					<div class="applyWindowMsgTopDes">
						<p class="p_one">1.新用户申请通过率高</p> 
						<p>2.请务必填写本人真实个人信息</p> 
						<p>2.银行审核通知将以短信形式直接发送到手机</p>
					</div>
				</div>
			</div> 
			<div class="applyBtn">申&nbsp; 请</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		var agree = 0;
		function greeBtn(index) {
			if (index) {
				$('.disagreeProtocolIcon').hide();
				$('.agreeProtocolIcon').show();
				agree = 1;
			} else {
				$('.disagreeProtocolIcon').show();
				$('.agreeProtocolIcon').hide();
				agree = 0;
			}
		}

		function closeApplyWindow() {
			$('#applyWindow').css('display', 'none');
		}

		function openApplyWindow() {
			$('#applyWindow').css('display', 'flex');
		}
		function GetQueryString(name) {
           var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
           var r = window.location.search.substr(1).match(reg);
           if (r!=null) return unescape(r[2]); 
           return null;
        }

        // if (GetQueryString('i') != null) {
        //     localStorage.zcjy_kadaren_intitor = GetQueryString('i');
        // }
        $('.applyBtn').on('click', function(){
        	//检查参数
        	if(agree == 0){
        		alert('请先阅读并同意服务协议');
        		return;
        	}
        	var invitor = GetQueryString('i');
        	var name = $('#name').val();
        	var mobile = $('#mobile').val();
        	if(name == ''){
        		alert('请填写姓名');
        		return;
        	}
        	if(mobile == ''){
        		alert('请填写手机号');
        		return;
        	}

        	event.preventDefault();
	        $.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        });
	        $.ajax({
	            url: '/ajax/dk_apply/{!! $daikuan->id !!}',
	            type: 'POST',
	            data: 'invitor='+invitor+'&name='+name+'&mobile='+mobile,
	            success: function(data) {
	                if (data.code == 1) {
	                    alert(data.message);
	                    return;
	                }
	                if (data.code == 0) {
	                    //alert(JSON.stringify(data.message));
	                    location.href=data.message['url'];
	                }
	            },
	        });
        	
        });
	</script>
@endsection