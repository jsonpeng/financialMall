@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pos Apply
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($posApply, ['route' => ['posApplies.update', $posApply->id], 'method' => 'patch']) !!}

                        @include('pos_applies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection