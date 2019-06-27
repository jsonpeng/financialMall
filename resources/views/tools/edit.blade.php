@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            工具
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tool, ['route' => ['tools.update', $tool->id], 'method' => 'patch']) !!}

                        @include('tools.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
       @include('partial.imagemodel')
   </div>
@endsection