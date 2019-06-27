@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            为试卷{!!  a_link($paper->name,route('paperLists.edit', [$paper->id])) !!}添加试题
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['topics.store',$paper->id]]) !!}

                        @include('topics.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
