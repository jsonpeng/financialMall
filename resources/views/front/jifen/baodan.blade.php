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
        .gift .title span{float: right; padding: 0 5px; border-radius: 15px; border: 1px solid blue; color: blue; font-size: 12px;}
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


        #products span{margin-left: 15px; font-size: 14px; border: 1px solid #666; padding: 3px 5px; margin-bottom: 15px; display: inline-block;}
        #products span.active{color: red; border: 1px solid red;}

        .item{
            position: relative;
            height:auto;
            width:50%;
            float: left;
        }
        .item > img{
            width: 100%;
            height: auto;
        }
        .item > a{
            position: absolute;bottom: -10px;left: 30%;
        }

    </style>
@endsection

@section('title')
    <title>选择兑换产品</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>保单</p>
    </div>
    <div style="padding: 15px;">
        <div style="color: red; font-size: 12px;">请提交正确信息，恶意提交无关信息，将严肃处理！</div>

        <div style="margin-top: 20px; margin-bottom: 20px;">选择兑换产品</div>
        <div id="products">


        </div>
        
        <div style="margin-top: 20px; margin-bottom: 20px;">请输入兑换码</div>
        <div id="tiaoxingma" style="text-align: center;">
            <input type="text" name="qcode" style="width: 90%; height: 50px; font-size: 18px;" >
        </div>

        <div  id="success_image_box" >
            <div class="item" >
                <img src="http://shop-model.yunlike.cn/images/logo.png" /> 
                <a>示例图片</a>
            </div>
            <div class="item uploads_image">
                <input name="image" type="hidden" value="">
                <img src="http://shop-model.yunlike.cn/images/logo.png" /> 
                <a  href="javascript:;"  style="">添加图片</a>
            </div>
         </div>
    </div>
    
    
    <div style="position: fixed; bottom: 0; left: 0; right: 0; height: 50px; line-height: 50px; text-align: center; display: flex;">
        <div style="flex: 1;" id="showIOSActionSheet">客服</div>
        <div style="flex: 1;" onclick="submit()">提交</div>
    </div>

    <div>
        <div class="weui-mask" id="iosMask" style="display: none"></div>
        <div class="weui-actionsheet" id="iosActionsheet">
            <div class="weui-actionsheet__title">
                <p class="weui-actionsheet__title-text">请选择联系方式</p>
            </div>
            <div class="weui-actionsheet__menu">
                <div class="weui-actionsheet__cell">QQ：3472115495</div>
                <div class="weui-actionsheet__cell">电话：4000665298</div>
            </div>
            <div class="weui-actionsheet__action">
                <div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div>
            </div>
        </div>
    </div>
@endsection


@section('js')

    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script type="text/javascript">
        var $iosActionsheet = $('#iosActionsheet');
        var $iosMask = $('#iosMask');

        function hideActionSheet() {
            $iosActionsheet.removeClass('weui-actionsheet_toggle');
            $iosMask.fadeOut(200);
        }

        $iosMask.on('click', hideActionSheet);
        $('#iosActionsheetCancel').on('click', hideActionSheet);
        $("#showIOSActionSheet").on("click", function(){
            $iosActionsheet.addClass('weui-actionsheet_toggle');
            $iosMask.fadeIn(200);
        });

        var tagId = null;
        var gifts = null;
        var bank = null;

        $(document).ready(function(){
            //alert(localStorage.getItem('zcjy_curBank'));
            gifts = JSON.parse(localStorage.getItem('zcjy_gifts'));
            bank = JSON.parse(localStorage.getItem('zcjy_curBank'));
            if (!gifts || !bank) {
                window.location.href = '/xyk_jifen';
            }

            //列出兑换列表
            for(let k = 0, length3 = gifts.length; k < length3; k++){
                $('#products').append("<span attr-id='"+gifts[k].id+"' attr-channel='"+gifts[k].channelId+"'>"+gifts[k].title+"</span>");
            }

            //选择兑换产品
            $('#products').on('click', 'span', function(event) {
                event.preventDefault();
                /* Act on the event */
                $('#products span').removeClass('active');
                $(this).addClass('active');
                tagId = $(this).attr('attr-id');
            });

            if (bank['platformChannel'].type == 'EXCHANGE_CODE') {
                //alert('code');
                $('#tiaoxingma').show();
                $('#success_image_box').hide();
            }else{
                //alert('image');
                $('#tiaoxingma').hide();
                $('#success_image_box').show();
            }

        });


        function submit(){
            if (tagId ==  null) {
                $('#g_iosDialog2_text').text('请选择需兑换的产品');
                $('#g_iosDialog2').fadeIn(200);
                return;
            }
            if ($('input[name=qcode]').val() == '') {
                $('#g_iosDialog2_text').text('请输入兑换码');
                $('#g_iosDialog2').fadeIn(200);
                return;
            }
            var oemId = bank['id'];

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/ajax/gift_apply',
                type: 'POST',
                data: {
                    oemId: oemId,
                    tagId: tagId,
                    code: $('input[name=qcode]').val(),
                    type: bank['platformChannel'].type,
                    image: $('input[name=image]').val()
                },
                success: function(data) {
                    if (data.code) {
                        alert(data.message);
                    } else {

                        window.location.href = '/xyk_jifen_records';
                    }
                },
                error: function(data){

                }
            });
        }

         //template模板
      // var previewTemplate='<div class="dz-preview dz-file-preview item"><img  data-dz-thumbnail/><input type="hidden" name="post_images[]" value=""><span class="dz-progress"></span><div class="zhezhao" data-status="none"></div></div>';
      //上传的dom对象
      var progress_dom;
      var myDropzone = $(document.body).dropzone({
        url:'/ajax/upload_images',
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        addRemoveLinks:false,
        maxFiles:100,
        autoQueue: true, 
        previewsContainer: "#success_image_box", 
        clickable: ".uploads_image",
        headers: {
         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        addedfile:function(file){
            console.log(file);
        },
        success:function(file,data){
            console.log('上传成功:'+data.message.src);
            $('.uploads_image > img').attr('src',data.message.src);
            $('.uploads_image > input').val(data.message.src);
            $('.uploads_image > a').remove();

         }
      });
</script>
@endsection

