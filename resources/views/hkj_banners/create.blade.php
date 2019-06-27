@extends('layouts.app')

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'hkjBanners.store']) !!}

                        @include('hkj_banners.fields', ['hkj_banner' => null])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('partial.imagemodel')
@endsection
