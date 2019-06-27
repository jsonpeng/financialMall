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
                   {!! Form::model($level, ['route' => ['levels.update', $level->id], 'method' => 'patch']) !!}

                        @include('levels.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection