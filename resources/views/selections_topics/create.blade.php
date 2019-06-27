@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
          为试题{!! a_link($topic->name,route('topics.index',[$topic->paper_id])) !!} 添加选项
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['selectionsTopics.store',$topic->id]]) !!}

                        @include('selections_topics.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
