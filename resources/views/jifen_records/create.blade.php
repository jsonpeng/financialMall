@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Jifen Record
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'jifenRecords.store']) !!}

                        @include('jifen_records.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
