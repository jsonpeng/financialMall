@extends('layouts.app')

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'creditCardThemes.store']) !!}

                        @include('credit_card_themes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('partial.imagemodel')
@endsection
