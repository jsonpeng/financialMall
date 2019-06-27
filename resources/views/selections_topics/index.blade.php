@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">试题{!! a_link($topic->name,route('topics.index',[$topic->paper_id])) !!} 的选项</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('selectionsTopics.create',$topic->id) !!}">添加选项</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('selections_topics.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

