@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-label{width: 40px;}
        .weui-cells{font-size: 13px;}
        .gift{
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .gift .title{font-size: 14px; }
        .gift .title span{float: right; padding: 0 5px; border-radius: 15px; border: 1px solid #0e83f0; color: #0e83f0; font-size: 12px;}
        .gift .price{color: red; font-size: 16px;}
        .gift .des{font-size: 12px; color: #999;}

        #cover{
            position: fixed;
            z-index: 99999;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            background-color: rgba(0,0,0,0.5);
            padding: 10px;
        }
        #inner{
            position: fixed;
            top: 50px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            overflow-y: auto;
            background-color: #fff;
        }
        #content{
            padding: 15px;
        }
    </style>
@endsection

@section('title')
    <title>选择兑换产品</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>选择兑换产品</p>
    </div>
    <div id="products">
    </div>
    
    <div id="cover">
        <img onclick="closeW()" src="{{ asset('images/close-product.png') }}" style="position: absolute; right: 20px;top: 15px;width: 30px">
        <div id="inner">
            <div id="content">
                
            </div>
        </div>
    </div>
    <a style="position: fixed; bottom: 0; left: 0; right: 0; height: 50px; line-height: 50px; text-align: center; background-color: #0e83f0; color: #fff;" href="/baodan/{!! $id !!}">报单</a>
@endsection


@section('js')
    
    <script type="text/javascript">
        var price = {!! $price !!};

        var gifts = [];

        $(document).ready(function(){
            getProducts();
        });

        function closeW(){
            $('#cover').hide();
        }

        function getProducts(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/ajax/gifts/{!! $id !!}',
                type: 'GET',
                success: function(data) {
                    gifts = JSON.parse(data).result;
                    localStorage.setItem('zcjy_gifts', JSON.stringify(gifts));
                    gifts.forEach( function(element, index) {
                        $('#products').append("<div class='gift' onclick='giftdetail("+element.id+")'>\
                            <div class='title'>"+element.title+"  <span>"+element.credit+"积分</span> </div>\
                            <div class='price'>￥"+Math.round(element.credit/10000*price)+"</div>\
                            <div class='des'>兑换限制："+element.conversionCount+"/月</div>\
                        </div>");
                    });
                },
            });
        }

        function giftdetail(id){
            $('#content').html();
            gifts.forEach( function(element, index) {
                if (element.id == id) {
                    $('#content').html(element.remark);
                }
            });
            $('#cover').show();
        }

        
    </script>
    
@endsection

