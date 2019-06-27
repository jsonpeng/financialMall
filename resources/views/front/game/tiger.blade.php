@extends('front.base')

@section('css')
	<style type="text/css">
        *{margin:0;padding:0}img{vertical-align:bottom}.game-header{width:100%}.game-header img{width:100%}.game-content{position:relative;width:100%}.game-content img{width:100%}.game-goods-wrap{position:absolute;margin:0 auto;top:12%;left:0;right:0;bottom:0;width:64%;height:50%;border-top-left-radius:.1875rem;border-top-right-radius:.1875rem;border-bottom-left-radius:.25rem;border-bottom-right-radius:.25rem;overflow:hidden}.game-goods-wrap:before{position:absolute;top:-1px;right:0;bottom:1px;left:-1px;border-top-left-radius:.25rem;border-top-right-radius:.25rem;width:101%;height:100%;content:"";box-shadow:0 1.25rem 1.25rem -1.25rem #000 inset;z-index:12}.game-goods-wrap:after{position:absolute;top:1px;right:0;bottom:-1px;left:-1px;width:101%;height:100%;box-shadow:0 -1.25rem 1.25rem -1.25rem #000 inset;z-index:12;content:"";border-bottom-left-radius:.25rem;border-bottom-right-radius:.25rem}.game-goods-list{height:100%;overflow:hidden}.game-goods{position:absolute;width:32%;height:100%;z-index:10;overflow:hidden}.game-goods:first-child{left:-32%;transform:translateX(100%);-ms-transform:translateX(100%);-moz-transform:translateX(100%);-webkit-transform:translateX(100%);-o-transform:translateX(100%)}.game-goods:nth-child(2){left:50%;transform:translateX(-50%);-ms-transform:translateX(-50%);-moz-transform:translateX(-50%);-webkit-transform:translateX(-50%);-o-transform:translateX(-50%)}.game-goods:last-child{left:100%;transform:translateX(-100%);-ms-transform:translateX(-100%);-moz-transform:translateX(-100%);-webkit-transform:translateX(-100%);-o-transform:translateX(-100%)}.game-goods-box{height:70%;position:absolute;top:0;right:0;bottom:0;left:0;margin:auto}.game-goods-ul{position:relative;top:0;font-size:0;z-index:10}.game-goods-ul li{position:relative;width:100%}.game-goods-ul li img{position:absolute;top:0;right:0;bottom:0;left:0;margin:auto;height:90%;width:auto}.play{transition-duration:5500ms;transform:translate(0px,-3263.91px) translateZ(0px)}.game-rule{position:absolute;top:71%;left:15%;width:8%;height:18%}.no-login-game-btn{position:absolute;margin:0 auto;left:0;right:0;bottom:0;width:40%;height:32%}.game-btn{position:absolute;margin:0 auto;left:0;right:0;bottom:0;width:40%;height:32%}.game-prize{position:absolute;top:20%;right:2%;width:12%;height:30%}
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
            padding-top: 30px;
            padding-bottom: 0;
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
        .ad .weui-cell__bd .tempWrap{ height:24px; }/* 用 !important覆盖SuperSlide自动生成的宽度，这样就可以手动控制可视宽度。 */
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
	</style>
@endsection

@section('title')
	<title>小游戏</title>
@endsection

@section('content')
 
    <div class="header">
        <a href="/coin" class="go_return">后退</a><p>小游戏</p>
    </div>

    <div class="app">
        <a class="game-header" href="javascript:void(0);"><img src="{{ asset('images/1p.png') }}"></a>
        <div class="game-content">
            <img src="{{ asset('images/2p.png') }}">
            <div class="game-goods-wrap">
                <div class="game-goods-list">
                    <div class="game-goods" style="background: #ffffff;">
                        <div class="game-goods-box" id="game1">
                            <ul class="game-goods-ul" style=""></ul>
                        </div>
                    </div>
                    <div class="game-goods" style="background: #ffffff;">
                        <div class="game-goods-box" id="game2">
                            <ul class="game-goods-ul" style=""></ul>
                        </div>
                    </div>
                    <div class="game-goods" style="background: #ffffff;">
                        <div class="game-goods-box" id="game3">
                            <ul class="game-goods-ul"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <a class="game-rule" href="javascript:void(0);"></a>
            <span class="game-btn"></span>
            <a class="game-prize" href="javascript:void(0);" js-href="/index/myActiveDraw"></a>
        </div>
        <div class="ad weui-cell">
            <div class="weui-cell__bd">
                <ul class="infoList">
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                    <li class="swiper-slide">用户9999<span>抽中</span> 100 <img src="{{ asset('images/20190014.png') }}" alt=""></li>
                </ul>
            </div>
        </div>
        <div class="weui-cell pact">
            <div class="content">
                <div class="title weui-cell">
                    <div class="weui-cell__bd"><img src="{{ asset('images/20190032.jpg') }}" alt=""></div>
                </div>
                <div class="question weui-cell">
                    <div class="weui-cell__bd">
                        <div><span></span>活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须须知</div>
                        <div><span></span>活动须知活动须知活动须知活动须知活动须</div>
                        <div><span></span>活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须知活动须须知 商品说明商品说明商品说明商品说明</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/jquery.rotate.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.SuperSlide.2.1.1.js') }}"></script>
    <script type="text/javascript">
        $.extend({
            luckGame: function(options) {
                var defaults = {
                        'gameLen': '6',
                        'game_pagesize':10,//生成多少圈同样的东西
                        'zj_arr': { //中奖数组，第一个表示是否中奖，第二个中奖号码
                            'is_win':0,
                            'number':0
                        }
                    };
                 var settings = $.extend(defaults, options);
                 w_config={
                    'w':$(window).width(),
                    'h':$(window).height()
                 }
                 var gameArr=[];
                 var gameLen=settings.gameLen;
                 var game_list_h='';
                 var game_init=[];
                 var game_list_item_h=0;

                  //每次进来随机3个数字，来启动当前的选择的状态
                  for (var i = 0; i < 3; i++) {
                    
                    game_init.push(Math.floor(Math.random() * gameLen));
                  }
                  createGame();
                  $(window).resize(function(){
                    
                     createGame();
                 })
                  function createGame(){
                    getHeight();
                    setLi();
                    pushLi(gameArr);
                    start();
                  }


                  function getHeight(){
                    w_config={
                        'w':$(window).width(),
                        'h':$(window).height()
                    }
                     game_list_item_h=(w_config.w*320/750*0.5*0.7).toFixed(2);
                  }


                  //设置奖品
                  function setLi(){
                    
                    for (var j = 1; j <= settings.game_pagesize; j++) {
                        for (var i = 1; i <= gameLen; i++) {
                            gameArr.push({'type':j,'index':i,'src':'../images/slot/'+i+'.png'});
                        }
                    }

                    
                  }
                  //写入，初始化奖品的滚动
                  function pushLi(arr){
                    console.log(game_list_item_h);
                    var html_str='';
                    for (var i = 0; i < arr.length; i++) {
                        html_str+='<li style="height:'+game_list_item_h+'px" data-index="'+arr[i]['index']+'" data-type="'+arr[i]['type']+'"><img src="'+arr[i]['src']+'"></li>';
                    }
                    $(".game-goods-ul").each(function(e){
                        $(this).empty().append(html_str);
                        game_list_h=$(this).height();
                        console.log('game_list_item_h',game_init);
                        y=game_list_item_h*game_init[e];
                        
                        $(this).css({
                            'transition-duration': '0ms',
                            'transform':'translate(0px, -'+y+'px) translateZ(0px)'
                        })
                    });
                    
                    
                  }
                  
                  function start(){
                    $(".game-btn").click(function(){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/game/ajax/tiger',
                            type: 'POST',
                            data: {
                            },
                            success: function(data) {
                                //提示成功消息
                                if (data.code == 0) {
                                    // 设置中奖结果
                                    settings.zj_arr.is_win = (1 != data.message.result);
                                    settings.zj_arr.number = data.message.result - 2;

                                    //如果中奖
                                    if(settings.zj_arr.is_win==1)
                                    {
                                        
                                        $(".game-goods-ul").each(function(e){

                                            setTimeout(function(){
                                                y=(settings.zj_arr.number+settings.gameLen*(settings.game_pagesize-1))*game_list_item_h;
                                                $(".game-goods-ul").eq(e).css({
                                                    'transition-duration': '5000ms',
                                                    'transform':'translate(0px, -'+y+'px) translateZ(0px)'
                                                })
                                            }, e*300);
                                            //判断最后面是否完毕
                                            $("#game3").find(".game-goods-ul").on("webkitTransitionEnd", function() {
                                                y=settings.zj_arr.number*game_list_item_h;
                                                $(".game-goods-ul").css({
                                                    'transition-duration': '0ms',
                                                    'transform':'translate(0px, -'+y+'px) translateZ(0px)'
                                                })
                                                $("#game3").find(".game-goods-ul").unbind("webkitTransitionEnd");
                                            })
                                        })
                                        setTimeout(function(){
                                            jqtoast('恭喜您赢得'+data.message.data+'金币！');
                                        }, 6000);
                                        
                                        
                                    } else {
                                        numrand=randNum2();
                                        console.log(numrand);
                                        //不中奖的时候
                                        $(".game-goods-ul").each(function(e){
                                            y2=(numrand[0])*game_list_item_h;
                                            y3=(numrand[1])*game_list_item_h;
                                            y4=(numrand[2])*game_list_item_h;
                                            setTimeout(function(){
                                                y=(numrand[e]+settings.gameLen*(settings.game_pagesize-1))*game_list_item_h;
                                                $(".game-goods-ul").eq(e).css({
                                                    'transition-duration': '5000ms',
                                                    'transform':'translate(0px, -'+y+'px) translateZ(0px)'
                                                })
                                            }, e*300);
                                            //判断最后面是否完毕
                                            $("#game3").find(".game-goods-ul").on("webkitTransitionEnd", function() {
                                                
                                                $(".game-goods-ul").eq(2).css({
                                                    'transition-duration': '00ms',
                                                    'transform':'translate(0px, -'+y4+'px) translateZ(0px)'
                                                })
                                                $("#game3").find(".game-goods-ul").unbind("webkitTransitionEnd");
                                            })
                                            $("#game2").find(".game-goods-ul").on("webkitTransitionEnd", function() {
                                                
                                                $(".game-goods-ul").eq(1).css({
                                                    'transition-duration': '00ms',
                                                    'transform':'translate(0px, -'+y3+'px) translateZ(0px)'
                                                })
                                                $("#game2").find(".game-goods-ul").unbind("webkitTransitionEnd");
                                            })
                                            $("#game1").find(".game-goods-ul").on("webkitTransitionEnd", function() {
                                                
                                                $(".game-goods-ul").eq(0).css({
                                                    'transition-duration': '00ms',
                                                    'transform':'translate(0px, -'+y2+'px) translateZ(0px)'
                                                })
                                                $("#game1").find(".game-goods-ul").unbind("webkitTransitionEnd");
                                            })
                                        })
                                        setTimeout(function(){
                                            jqtoast('这次运气不好，再试一试肯定会有好运的');
                                        }, 6000);
                                        
                                    }
                                } else {
                                    jqtoast(data.message);
                                }                   
                            },
                        });                        
                    })
                  }
                  function randNum2(){
                    a=Math.floor(Math.random() * gameLen);
                    b=Math.floor(Math.random() * gameLen);
                    c=Math.floor(Math.random() * gameLen);
                    arr=[];
                    if(a==b)
                    {
                        return randNum2();
                    }else
                    {
                        return arr=[a,b,c];
                    }
                  }
            }
        })
        
        $(function(){
         $.luckGame({
            'zj_arr': {
                'is_win':0,
                'number':0//从0算起，就是10了
            },
            gameLen:6,//产品抽奖数量，
            game_pagesize:4
         }); 
        })
        jQuery(".ad").slide({mainCell:".weui-cell__bd ul",autoPlay:true,effect:"leftMarquee",vis:1,interTime:50});
    </script>
@endsection