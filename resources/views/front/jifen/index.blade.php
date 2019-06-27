@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-label{width: 40px;}
        .weui-cells{font-size: 13px;}
        .weui-select{
            height: 35px;
            line-height: 35px;
        }
        .weui-cells:after{
            border-bottom: none;
        }
        .weui-cell_select .weui-select{color: #fff;}
        .weui-cell_select .weui-select option{color: #000;}
        .apply-btn{
            background-color: transparent;
            color: #fff;
            border: 1px solid #fff;
            padding: 5px 20px;
            border-radius: 15px;
        }
    </style>
@endsection

@section('title')
    <title>科技</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>积分兑换</p>
    </div>
    <div style="padding-bottom: 30px; background-image: url('images/share_theme/jifen/jifen.jpg'); background-size: cover;">
        <div>
            <div class="weui-cells" style="padding-top: 50px; margin-top: 0; background-color: transparent;">
                <div class="weui-cell weui-cell_select" style="
                    margin: 0 80px;
                    border: 1px solid #ccc;
                    font-size: 14px;
                ">
                    <div class="weui-cell__bd">
                        <select class="weui-select" name="select1">
                            
                        </select>
                    </div>
                </div>
            </div>
            <div style="padding: 30px 15px; font-size: 14px; line-height: 24px; color: #fff;" id="intro">
                信息加载中...
            </div>
        </div>
        <div style="text-align: center;"><button onclick="duihuan()" class="apply-btn">立即兑换</button></div>
    </div>
    <div style="padding: 30px; font-size: 14px; border: 1px solid #eee;">
        <div style="color: #0e83f0;font-weight: bold;">为您算一算</div>
        <div id="price_text">信息加载中...</div>
        <div style="margin: 30px;">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell weui-cell_vcode">
                    <div class="weui-cell__hd">
                        <label class="weui-label">积分</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="number" id="jifen_count" placeholder="请输入需兑换积分数目">
                    </div>
                    <div class="weui-cell__ft">
                        <button class="weui-vcode-btn" style="font-size: 13px;" onclick="calc_price()">算一算</button>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">金额</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="number" id="money_count" pattern="[0-9]*" placeholder="">
                    </div>
                </div>
                
            </div>

            <div id="notice" style="margin-top: 20px;">信息加载中...</div>
        </div>
    </div>
    
    @include('front.bottom-bar', ['index' => 2])
@endsection


@section('js')
    
    <script type="text/javascript">
        var banks = [];
        var price = 0;
        var curBank = null;

        $(document).ready(function(){
            getBanks()

            $("select").change(function(){
                price = 0;
                //alert($("select").val());
                banks.forEach( function(element, index) {
                    if (element.id  == $("select").val()) {
                        setCurrent(element);
                    }
                });
            });
        });

        function duihuan(){
            if (curBank == null || price <= 0) {
                return;
            }

            window.location.href = '/gifts/'+curBank.channelId+'?price='+price;
        }

        function checkType(element) {
             return element.platformChannel.type == 'EXCHANGE_CODE';
        }


        function getBanks(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/bankList',
                type: 'GET',
                success: function(data) {
                    // banks = JSON.parse(data).result;
                    // banks = banks.filter(checkType);
                    banks = data;

                    localStorage.setItem('zcjy_banks', JSON.stringify(banks));
                    //alert(banks.length);
                    banks.forEach( function(element, index) {

                        $('select[name=select1]').append("<option value='"+element.id+"'>"+element.platformProduct.name+"-"+element.platformChannel.name+"</option>");
                        if (index  == 0) {
                            setCurrent(element);
                        }
                        
                    });
                },
            });
        }

        function setCurrent(element){
            curBank = element;
            localStorage.setItem('zcjy_curBank', JSON.stringify(curBank));
            $('#intro').text("【"+element.platformProduct.name+"】"+element.platformChannel.remark);
            $('#notice').text("注："+element.platformProduct.name+"最小起兑积分为" + element.minPrice);
            getPrice(element.id);
        }

        function getPrice(oemid){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/price/'+oemid,
                type: 'GET',
                success: function(data) {
                    if (data.status == 200) {
                        // statement
                        $('#price_text').text(data.result.productName+"每一万积分可以兑换"+data.result.price/100+"元");
                        price = data.result.price/100;
                        $('input.weui-input').val('');
                    } else {
                        alert(data.message);
                    }
                },
            });
        }

        function calc_price(){
            $('#money_count').val( parseInt($('#jifen_count').val()/10000*price) );
        }
    </script>
    
@endsection

