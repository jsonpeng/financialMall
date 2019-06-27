@extends('front.base')

@section('css')
    <style type="text/css">
      #tiku-list{
        padding: 5px;
      }
        
      .paper-list{display: flex; background-color: #e6f8ff; margin: 5px 0;}


      .btn-area span{color: #fff; background-color: #0e83f0; height: 25px; line-height: 25px; border-radius: 13px; padding: 0 10px; justify-content: center;}
      .btn-area{display: flex; justify-content: center; align-items: center; padding: 0 15px;}
      .paper-header{flex-grow: 1; padding: 5px;}
      .paper-header span{font-size: 14px; color: #999; margin-left: 15px;}
      }
    </style>
@endsection

@section('title')
    <title>考试库</title>
@endsection

@section('content')
    <div class="header">
        <a href="/kaoshis" class="go_return">返回</a><p>考试库</p> 
    </div>
    <div id="tiku-list">
      @foreach ($records as $element)
        <div class="paper-list">
          <div class="paper-header">
            <div>{{ $element->paper->name }} <span style="float: right">{{ $element->created_at->format('Y-m-d') }}</span></div>
            <div style="font-size: 14px;">难度等级：{{ $element->paper->level }} <span>题目数:{{ $element->topic_num }}</span> <span>成绩:{{ $element->grade }}</span> <span style="float: right; color: #333;">@if($element->is_pass) 通过 @else 不通过 @endif</span></div>
          </div>
        </div>
      @endforeach
    </div>
    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')

@endsection

