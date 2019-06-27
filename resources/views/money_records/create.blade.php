@extends('layouts.app')

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'moneyRecords.store']) !!}

                        @include('money_records.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
