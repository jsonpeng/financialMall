@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
          编辑
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($amazingMan, ['route' => ['amazingMen.update', $amazingMan->id], 'method' => 'patch']) !!}

                        @include('amazing_men.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partial.imagemodel')
@endsection