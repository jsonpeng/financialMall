@extends('shop.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
          添加店铺
        </h1>
    </section>
    <div class="content">
        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'stores.store']) !!}

                        @include('shop.stores.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('shop.partial.imagemodel')
@endsection

@include('shop.stores.js')
