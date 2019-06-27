@extends('shop.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           添加项目
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'projects.store']) !!}

                        @include('shop.projects.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('shop.projects.js')
