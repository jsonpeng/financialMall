@extends('layouts.app')

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($advertorial, ['route' => ['advertorials.update', $advertorial->id], 'method' => 'patch']) !!}

                        @include('advertorials.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection