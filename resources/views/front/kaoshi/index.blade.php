@extends('front.base')

@section('css')
    <style type="text/css">
        
        .bg-img{
            width: 100%;
            height: auto;
          }
          a.img-container{
            position: relative;
            color: #fff;
            font-weight: bold;
            font-size: 24px;
            display: block;
          }
          .img-container .no{position: absolute; top: 30px; left: 25px; font-size: 42px;}
          .img-container .title{position: absolute; top: 80px; left: 25px;}

          a.header-right{
            position: absolute;
            color: #fff;
            right: 15px;
            top: 0;
            font-size: 14px
          }
    </style>
@endsection

@section('title')
    <title>考试库</title>
@endsection

@section('content')
    <div class="header">
        <a href="javascript:history.go(-1)" class="go_return">返回</a><p>考试库</p> <a class="header-right" href="/kaoshi_records" >考试记录</a>
    </div>
    <div id="tiku-list">
        <?php $index  = 1; ?>
        @foreach ($paper_type as $element)
            <a class="img-container" href="/kaoshi/{{ $element->id }}">
              <img class="bg-img" src="{{ $element->image }}" alt="placeholder+image">
              <div class="no">{{ $index++ }}</div>
              <div class="title">{{ $element->name }}</div>
            </a>
        @endforeach
    </div>
    
    @include('front.bottom-bar', ['index' => 4])
@endsection


@section('js')

@endsection

