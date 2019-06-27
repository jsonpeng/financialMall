@extends('layouts.app')

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($hkj, ['route' => ['hkjs.update', $hkj->id], 'method' => 'patch']) !!}

                        @include('hkjs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partial.imagemodel')
@endsection