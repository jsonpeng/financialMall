@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cash Withdraw
        </h1>
    </section>
    {{-- <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'cashWithdraws.store']) !!}

                        @include('cash_withdraws.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div> --}}
@endsection
