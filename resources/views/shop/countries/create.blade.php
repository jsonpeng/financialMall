@extends('shop.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            添加国家馆
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'countries.store']) !!}

                        @include('shop.countries.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('shop.partial.imagemodel')
@endsection
