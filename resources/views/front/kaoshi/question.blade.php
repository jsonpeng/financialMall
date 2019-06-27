@extends('front.base')

@section('css')
    <style type="text/css">
        .question-name{
            padding: 15px;
            font-weight: bold;
            color: orange;
        }
        .weui-cell{padding: 20px 15px;}
        .weui-cells{margin-top: 0;}
        #result{
            padding: 15px;
            color: orange;
        }
    </style>
@endsection

@section('title')
    <title>考试库</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>考试库</p>
    </div>
    <div id="scroll-container">
        
    </div>

    <div id="result">
        
    </div>

    <div style="padding: 15px;"><div class="weui-btn weui-btn_default" onclick="next()">下一题</div></div>
    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')
    <script src="{{ asset('vendor/doT.min.js') }}"></script>

    <script type="text/template" id="template">
        <div class="weui-cell__bd question-name">@{{=it.name}}</div>
        @{{~it.selections:value:index}}
            <div class="weui-cells weui-cells_checkbox">
                <label class="weui-cell weui-check__label" for="@{{=value.type}}">
                    <div class="weui-cell__bd">
                        <p>@{{=value.type}}: @{{=value.content}}</p>
                    </div>
                    <div class="weui-cell__hd">
                        <input type="checkbox" class="weui-check" name="checkbox1" id="@{{=value.type}}" answer='@{{=value.is_result}}'/>
                        <i class="weui-icon-checked"></i>
                    </div>
                </label>
            </div>
        @{{~}}
    </script>


    <script>
        var index = 0;
        var correct = 0;
        var total = 0;
        var finish = false;
        function loadQuestion() {

            //加载函数
            $.ajaxSetup({ 
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/ajax_question/{{ $id }}?skip="+index++,
                type:"GET",
                success:function(data){
                    $('#result').text('');
                    if (data.code) {
                        alert(data.data);
                        return;
                    } else {
                        if (data.data == null) {
                            //题目做完了
                            if (total) {
                                //alert(parseInt(correct/total*100));
                                alert('已经是最后一道题，考试完成。查看成绩');
                                submitResult();
                            }else{
                                alert('还没有开始做试题');
                                return;
                            }
                        } else {
                            // 编译模板函数
                            var tempFn = doT.template( $('#template').html() );

                            // 使用模板函数生成HTML文本
                            var resultHTML = tempFn(data.data);

                            // 否则，直接替换list中的内容
                            $('#scroll-container').html(resultHTML);
                        }
                    }
                }
            });
        }

        function submitResult() {
            finish = true;
            //加载函数
            $.ajaxSetup({ 
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/ajax_store_record?paper_id={{ $id }}&topic_num="+total+'&grade='+parseInt(correct/total*100),
                type:"GET",
                success:function(data){
                    if (data.code) {
                        alert(data.data);
                        return;
                    } else {
                        $('#result').text('');
                        window.location.href="/kaoshi_records";
                    }
                }
            });
        }

        function next() {
            if (finish) {
                submitResult();
            }
            //正规答案
            var correct_answer = '';
            $("input[answer='1']").each(function(i){
                correct_answer += $(this).attr('id');
            });

            var user_answer = '';
            $("input[type='checkbox']:checked").each(function(i){
                user_answer += $(this).attr('id');
            });

            if (correct_answer == user_answer) {
                correct++;
                $('#result').text('回答正确');
            } else {
                $('#result').text('回答错误，正确答案：'+correct_answer);
            }
            total++;
            setTimeout(function function_name() {
                loadQuestion();
            }, 1500);
        }

        $(document).ready(function(){
            loadQuestion();
        });

       
    </script>
@endsection

