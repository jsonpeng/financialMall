@extends('front.base')

@section('css')
    <style type="text/css">
        
      .paper-list{display: flex; background-color: #e6f8ff; margin: 5px 0;}


      .btn-area a{color: #fff; background-color: #0e83f0; height: 25px; line-height: 25px; border-radius: 13px; padding: 0 10px; justify-content: center; font-size: 14px;}
      .btn-area{display: flex; justify-content: center; align-items: center; padding: 0 15px;}
      .paper-header{flex-grow: 1; padding: 5px;}
      .paper-header span{font-size: 14px; color: #999; margin-left: 15px;}
    </style>
@endsection

@section('title')
    <title>考试库</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>考试库</p>
    </div>
    <div id="tiku-list">
      @foreach ($paper_list as $element)
        <div class="paper-list">
          <div class="paper-header">
            <div>{{ $element->name }}</div>
            <div style="font-size: 14px;">难度等级：{{ $element->level }} <span>题目数:{{ $element->topic_num }}</span> <span>达标数:{{ $element->pass_grade }}</span></div>
          </div>
          <div class="btn-area"><a href="/question/{{ $element->id }}">考试</a></div>
        </div>
      @endforeach
    </div>
    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')

@endsection

