@extends('front.base')

@section('css')
    <style type="text/css">
        #panel_2, #panel_3{
            display: none;
        }
        .weui-tab__panel{
            padding-top: 50px;
            padding-bottom: 0;
        }
        .weui-navbar__item:after{
            border-right: none;
        }
        .weui-navbar__item.weui-bar__item_on{
            background-color: transparent;
            color: #13c065;
            border-bottom: 1px solid #13c065;
        }
    </style>
@endsection

@section('title')
    <title>{{ $platForm->name }}</title>
@endsection

@section('content')
    <div style="text-align: center; padding: 50px 0 0 0;">
        <img src="{{$platForm->image}}" style="width: 72px; height: 72px;">
    </div>
    <div style="text-align: center; font-size: 22px;">{{$platForm->name}}</div>
    <?php 
        $features = explode(',',$platForm->remark);
    ?>
    <div class="feature_box" style="position: relative; right: auto; text-align: center; top: auto; margin-top: 5px; margin-bottom: 20px;">
        @foreach($features as $feature)
            <span>{{ $feature }}</span>
        @endforeach
    </div>
    <!--div style="text-align: center; font-size: 16px; color: #808080; margin-bottom: 20px;">{{$platForm->remark}}</div-->

    <div class="page">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-navbar">
                    <div class="weui-navbar__item weui-bar__item_on" id="1">
                        基本信息
                    </div>
                    <div class="weui-navbar__item" id="2">
                        申请条件
                    </div>
                    <div class="weui-navbar__item" id="3">
                        申请材料
                    </div>
                </div>
                <div class="weui-tab__panel" id="panel_1">
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <p>额度范围</p>
                            </div>
                            <div class="weui-cell__ft">{{$platForm->edu_min}}-{{$platForm->edu_max}}元</div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <p>参考利率</p>
                            </div>
                            <div class="weui-cell__ft">{{$platForm->rate}}%/{{$platForm->time}}</div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <p>期限范围</p>
                            </div>
                            <div class="weui-cell__ft">{{$platForm->time_min}}-{{$platForm->time_max}}{{$platForm->time}}</div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <p>放款时间</p>
                            </div>
                            <div class="weui-cell__ft">{{$platForm->fangkuan}}</div>
                        </div>
                    </div>
                    <div class="content-wrapper">
                        {!!$platForm->jiehao!!}
                    </div>
                </div>
                <div class="weui-tab__panel" id="panel_2">
                    <div class="content-wrapper">
                        {!!$platForm->tiaojian!!}
                    </div>
                    
                </div>
                <div class="weui-tab__panel" id="panel_3">
                    <div class="content-wrapper">
                        {!!$platForm->cailiao!!}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


    <a class="shenqing-btn" href="{{$platForm->link}}">立即申请</a>
@endsection


@section('js')
    <script type="text/javascript">
        
        $(function(){
                $('.weui-navbar__item').on('click', function () {
                    $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
                    $('.weui-tab__panel').hide(); 
                    console.log('#panel_'+$(this).attr('id'));
                    $('#panel_'+$(this).attr('id')).show(); 
                });
            });
    </script>
    
@endsection

