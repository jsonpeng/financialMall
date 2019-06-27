@extends('layouts.app')

@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($toolCat, ['route' => ['toolCats.update', $toolCat->id], 'method' => 'patch']) !!}

                        @include('tool_cats.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection