@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            信用卡代还业务介绍
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'xykIntros.store']) !!}

                        @include('xyk_intros.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
