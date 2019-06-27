@extends('layouts.app')

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'platFormCats.store']) !!}

                        @include('plat_form_cats.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('partial.imagemodel')
@endsection
