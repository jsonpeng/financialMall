@extends('front.base')

@section('css')
    <style type="text/css">
        .weui-grid{
            width: 25%;
            padding: 10px 10px 10px 10px;
        }
        .weui-grids{margin: 15px 0;}        
    </style>
@endsection

@section('title')
    <title>{{ $category->name }}</title>
@endsection

@section('content')
    <div class="header">
        <a href="/" class="go_return">首页</a><p>{{ $category->name }}</p>
    </div>

    <div class="weui-panel__bd scroll-container">
        @foreach ($posts as $post)
            <a href="/post/{{$post->id}}" class="weui-media-box weui-media-box_appmsg scroll-post">
                <div class="weui-media-box__hd hkj">
                    <img class="weui-media-box__thumb" src="{{$post->image}}" alt="">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title hkj">{{$post->name}}</h4>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">{{$post->view}}人在看</li>
                    </ul>
                </div>
            </a>

        @endforeach
    </div>
    <div style="opacity: 0;position: fixed;">{{$posts->links()}}</div>
    
    @include('front.bottom-bar', ['index' => 1])
@endsection


@section('js')
    <script type="text/javascript">
        $('.scroll-container').infiniteScroll({
          // options
          path: "a[rel='next']",
          append: '.scroll-post',
          history: false,
        });
    </script>
    
@endsection

