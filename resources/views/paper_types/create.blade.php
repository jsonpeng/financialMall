@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           添加试题分类
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'paperTypes.store']) !!}

                        @include('paper_types.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
     @include('partial.imagemodel')
@endsection
