@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Advertorial
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('advertorials.show_fields')
                    <a href="{!! route('advertorials.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
