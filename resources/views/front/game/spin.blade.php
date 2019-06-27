@extends('front.base')

@section('css')
	<style type="text/css">
        body{
            height: 100%;
            background: #fbe3cc;
        }
        @charset "utf-8";
        /* CSS Document */
        /* reset */
        html,body,h1,h2,h3,h4,h5,h6,div,dl,dt,dd,ul,ol,li,p,blockquote,pre,hr,figure,table,caption,th,td,form,fieldset,legend,input,button,textarea,menu{margin:0;padding:0;}
        header,footer,section,article,aside,nav,hgroup,address,figure,figcaption,menu,details{display:block;}
        table{border-collapse:collapse;border-spacing:0;}
        caption,th{text-align:left;font-weight:normal;}
        html,body,fieldset,img,iframe,abbr{border:0;}
        i,cite,em,var,address,dfn{font-style:normal;font-weight:normal;}
        [hidefocus],summary{outline:0;}
        ol,ul,li{list-style:none;}
        h1,h2,h3,h4,h5,h6,small{font-size:100%;font-weight:normal;}
        sup,sub{font-size:83%;}
        pre,code,kbd,samp{font-family:inherit;}
        q:before,q:after{content:none;content:'';}
        textarea{overflow:auto;resize:none;}
        label,summary{cursor:default;}
        a,button{cursor:pointer;}
        h1,h2,h3,h4,h5,h6,strong,b{font-weight:bold;}
        del,ins,u,s,a,a:hover{text-decoration:none;}
        body,textarea,input,button,select,keygen,legend{font:12px/1.14 arial,\5b8b\4f53;color:#333;outline:0;}
        a,a:hover{color:#333;}
        .clearfix:after{content:'\20';display:block;height:0;clear:both}
        .clearfix{zoom:1}



        html,body{
            height:100%;
        }
        body{
            background-image: url({{ asset('images/20190031.jpg') }});
            background-repeat: no-repeat;
            background-position: left top;
            background-size:cover; 
        }
        .app{
            background-color:#f2de8b;
        }
        .g-content {
            width: 100%;
            height: auto;
            font-family: "微软雅黑", "microsoft yahei";
        }
        .g-content .g-lottery-case {
           
            margin: 0 auto;
            overflow: hidden;
        }
        
        .g-content .g-lottery-case .g-left h2 {
            font-size:14px;
            line-height: 32px;
            font-weight: normal;
            margin-left: 20px;
            margin-bottom: 10px;
        }
        
        .g-content .g-lottery-case .g-left {
            width: 300px;
            margin: 0 auto;
        }
        
        .g-lottery-box {
            width: 300px;
            height: 300px;
            /*margin-left: 30px;*/
            position: relative;
            background: url(http://www.jsdaima.com/Upload/1469870863/ly-plate-c.gif) no-repeat;
            background-position: center;
            background-size: contain;
        }
        /*http://www.jsdaima.com/Upload/1469870863/bg-lottery.png*/
        .g-lottery-box .g-lottery-img {
            width: 255px;
            height: 255px;
            position: relative;
            background: url('{{ asset('images/spin/content.png') }}') no-repeat;
            left: 22px;
            top: 22px;
            background-position: center;
            background-size: contain;
        }
        
        .g-lottery-box .playbtn {
            width: 120px;
            height: 120px;
            position: absolute;
            top: 68px;
            left: 68px;
            background: url('{{ asset('images/playbtn.png') }}') no-repeat;
            background-position: center;
            background-size: contain;
        }
        .top_pic img{
            display: block;
            width:100%;
        }
        .ad{
            padding:10px 100px;
        }
        .ad .weui-cell__bd{
            background-color:#fff;
            white-space: nowrap;
            overflow: hidden;
        }
        ul,li{
            list-style: none;
        }
        .ad {position:relative;}
        .ad .weui-cell__bd{ display: flex;align-items: center;padding:2px 10px;  background-color:#fff;box-shadow: 0px 2px 4px 0px rgba(171, 129, 3, 0.4);}
        .ad .weui-cell__bd .tempWrap{ height:24px; width: 100% !important;}/* 用 !important覆盖SuperSlide自动生成的宽度，这样就可以手动控制可视宽度。 */
        .ad .weui-cell__bd ul{ overflow:hidden; zoom:1;width:100%;}
        .ad .weui-cell__bd ul li{ margin-right:20px;  float:left; height:24px; line-height:24px;  text-align:left; display:inline; width:auto !important;font-size: 14px;color: rgb(242, 48, 50);display: flex; align-items: center;justify-content:center;}/* 用 width:auto !important 覆盖SuperSlide自动生成的宽度，解决文字不衔接问题 */
        .ad .weui-cell__bd ul li span{
            color:#000;
            margin-right: 5px;
        }
        .ad .weui-cell__bd ul li img{
            width:14px;
            display:inline-block;
            margin-left: 3px;
        }
        .pact{
            padding:0 20px;
            margin-top: 5px;
        }
        .pact .content{
            background-color:#fff;
        }
        .pact .title{
            height:auto;
            line-height: 1.7em;
            margin-bottom: 5px;
        }
        .pact .title .weui-cell__bd{
            padding:0 40px;
        }
        .pact .title .weui-cell__bd img{
            display: block;
            width:100%;
        }
        .question{
            font-size: 11px;
            color: rgb(150, 147, 141);
            line-height: 1.7em;
        }
        .question .weui-cell__bd>div{
            margin-bottom: 1em;
            font-size: 11px;
        }
        .question span{
            width:5px;
            height:5px;
        }
        #container{
            padding-bottom: 0;
        }
	</style>
     <link rel="stylesheet" href="{{ asset('vendor/weui.min.css') }}">
     <style type="text/css">
               input::-ms-input-placeholder{text-align: left;padding-left:10px;font-size: 14px;}
      input::-webkit-input-placeholder{text-align: left;padding-left:10px;font-size: 14px;}
      .form-control{
            width: 95%;
            padding-top: 8px;
            padding-bottom: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
      
     </style>
@endsection

@section('title')
	<title>小游戏</title>
@endsection

@section('content')
 
{{--     <div class="header">
        <a href="/coin" class="go_return">后退</a><p>小游戏</p>
    </div> --}}

    <div class="app">
        <div class="weui-cell top_pic">
            <div class="weui-cell__bd"><img src="{{ asset('images/20190030.png') }}" alt=""></div>
        </div>
        <div class="g-content">
                <div class="g-lottery-case">
                    <div class="g-left">
                        <!-- <h2>您已拥有<span class="playnum">0</span>次抽奖机会，点击立刻抽奖！~</h2> -->
                        <div class="g-lottery-box">
                            <div class="g-lottery-img">
                                <a class="playbtn" href="javascript:;" title="开始抽奖" style="transform: rotate(120deg); transform-origin: 50% 50% 0px;"></a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="ad weui-cell">
            <div class="weui-cell__bd">
                <ul class="infoList">
                    {{-- <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li> --}}
                </ul>
            </div>
        </div>
        <div class="weui-cell pact">
            <div class="content">
                <div class="title weui-cell">
                    <div class="weui-cell__bd"><img src="{{ asset('images/20190032.jpg') }}" alt=""></div>
                </div>
                <div class="question weui-cell" style="padding: 0 30px;">
                    <div class="weui-cell__bd">
                        <div> 
                            <p>活动内容：</p>
                            <p>1、玩家需要使用10积分在幸运大转盘进行抽奖。</p>
                            <p>2、每个ID每天可多次抽奖。</p>
                            <p>3、玩家获得的奖品在60秒后自动加入到积分账户中。</p>
                            <p>活动步骤：</p>
                            <p>1、进入幸运大转盘先查看自己是否拥有足够的积分。</p>
                            <p>2、确认积分后可直接进入幸运大转盘抽奖页面，进行抽奖，获取的积分可进入商城兑换相应的商品，点击“我的”“积分商城”中查看积分数据后再进行抽奖。</p>
                        </div>
                        {{-- <div><span></span>活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须须知</div>
                        <div><span></span>活动须知活动须知活动须知活动须知活动须</div>
                        <div><span></span>活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须须知 商品说明商品说明商品说明商品说明</div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="saveInfo">
          <div class="weui-mask" id="iosMask" style="display: none"></div>
          <div class="weui-actionsheet" id="certBox" style="    background: #fff;    padding-left: 15px;
    padding-top: 15px;padding-bottom: 3px;">
           <div >
              <div style="font-size: 16px;padding-bottom: 15px;text-align: left">
                  填写收货信息
              </div>
              <p style="    color: #aaa;
    font-size: 14px;
    padding-bottom: 10px;">您已获得奖项<span style="color: red;">请填写信息后方便我们送货给您!</span></p>
              <input type="text" name="rec_name" class="form-control" placeholder="收货人姓名" />
              <input type="text" name="rec_mobile" class="form-control" placeholder="收货人联系方式" />
              <input type="text" name="rec_address" class="form-control" placeholder="收货人地址" />
               <a class="obzy_btn bind_mobile_btn" style="    background: red;
    color: white;
    padding: 10px 150px;
    display: inline-block;
    margin: 0 auto;
    text-align: center;
    margin-top: 10px;" href="javascript:;" onclick="certSubmit()">提交</a>
          </div>
         </div>
    </form>
@endsection

@section('js')
    <script src="{{ asset('vendor/jquery.rotate.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.SuperSlide.2.1.1.js') }}"></script>
    <script type="text/javascript">
        window.alert = function(name){
            var iframe = document.createElement("IFRAME");
            iframe.style.display="none";
            iframe.setAttribute("src", 'data:text/plain,');
            document.documentElement.appendChild(iframe);
            window.frames[0].window.alert(name);
            iframe.parentNode.removeChild(iframe);
        }
        var $iosMask = $('#iosMask');
        var $iosActionsheet = $('#iosActionsheet');
        var spinId;
        function certSubmit()
        {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/game/ajax/spin_save_info/'+spinId,
                    type: 'POST',
                    data: $('#saveInfo').serialize(),
                    success: function(data) {
                        if (data.code == 0) {
                           hideActionSheet();
                        }
                        alert(data.message);
                    }
                });
        }

        function openCert()
        {
          $('#certBox').addClass('weui-actionsheet_toggle');
          $iosMask.fadeIn(200);
        }

        function hideActionSheet() {
          $('#certBox').removeClass('weui-actionsheet_toggle');
            $iosActionsheet.removeClass('weui-actionsheet_toggle');
            $iosMask.fadeOut(200);
        }
        $(function() {
            var $btn = $('.playbtn');
            var playnum = 1; //初始次数，由后台传入
            $('.playnum').html(playnum);
            var isture = 0;
            var clickfunc = function() {

                // 向程序后台发起抽奖请求
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/game/ajax/spin',
                    type: 'POST',
                    data: {
                        token : '{!! $token !!}'
                    },
                    success: function(data) {
                        //提示成功消息
                        if (data.code == 0) {
                            if (data.message.data && data.message.data != '谢谢参与') {
                                spinId = data.message.spinresult;
                                rotateFunc(data.message.result, (data.message.result - 1) * 60, '恭喜您获得'+data.message.data+'奖项,当前剩余积分:'+data.message.credits);
                                // setTimeout(function(){
                                //      openCert();
                                // },1500);
                            } else {
                                var rate_arr = [2,5];
                                rate = rate_arr[Math.floor(Math.random()*rate_arr.length)];
                                //alert('这次运气不好，再试一试肯定会有好运的');
                                rotateFunc(data.message.result, (rate - 1) * 60, '这次运气不好，再试一试肯定会有好运的,当前剩余积分:'+data.message.credits);
                            }
                            
                        } else {
                            alert(data.message);
                        }                   
                    },
                });
                // var data = [1, 2, 3, 4, 5, 6];
                // //data为随机出来的结果，根据概率后的结果
                // data = data[Math.floor(Math.random() * data.length)];
                // switch(data) {
                //     case 1:
                //         rotateFunc(1, 0, '恭喜您获得2000元理财金!');
                //         break;
                //     case 2:
                //         rotateFunc(2, 60, '谢谢参与~再来一次吧~');
                //         break;
                //     case 3:
                //         rotateFunc(3, 120, '恭喜您获得5200元理财金!');
                //         break;
                //     case 4:
                //         rotateFunc(4, 180, '恭喜您获得100元京东E卡，将在次日以短信形式下发到您的手机上，请注意查收!');
                //         break;
                //     case 5:
                //         rotateFunc(5, 240, '谢谢参与~再来一次吧~');
                //         break;
                //     case 6:
                //         rotateFunc(6, 300, '恭喜您获得1000元理财金!');
                //         break;
                // }
            }
            $btn.click(function() {
                if(isture) return; // 如果在执行就退出
                isture = true; // 标志为 在执行
                clickfunc();
                //先判断是否登录,未登录则执行下面的函数
                // if(1 == 2) {
                //     $('.playnum').html('0');
                //     alert("请先登录");
                //     isture = false;
                // } else { //登录了就执行下面
                //     if(playnum <= 0) { //当抽奖次数为0的时候执行
                //         alert("没有次数了");
                //         $('.playnum').html(0);
                //         isture = false;
                //     } else { //还有次数就执行
                //         playnum = playnum - 1; //执行转盘了则次数减1
                //         if(playnum <= 0) {
                //             playnum = 0;
                //         }
                //         $('.playnum').html(playnum);
                //         clickfunc();
                //     }
                // }
            });
            var rotateFunc = function(awards, angle, text) {
                isture = true;
                $btn.stopRotate();
                $btn.rotate({
                    angle: 0,
                    duration: 4000, //旋转时间
                    animateTo: angle + 1440, //让它根据得出来的结果加上1440度旋转
                    callback: function() {
                        isture = false; // 标志为 执行完毕
                        alert(text);
                    }
                });
            };
        });
        
        jQuery(".ad").slide({mainCell:".weui-cell__bd ul",autoPlay:true,effect:"leftMarquee",vis:1,interTime:50});
    </script>
@endsection