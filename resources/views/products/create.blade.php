@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            会员信息
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'products.store']) !!}

                        @include('products.fields', ['product' => null])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @include('partial.imagemodel')
@endsection
