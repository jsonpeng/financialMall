@extends('shop.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            新建团购
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'groupSales.store']) !!}

                        @include('shop.group_sales.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('shop.group_sales.partial.js')
@endsection