@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            POS机申请
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($posIntro, ['route' => ['posIntros.update', $posIntro->id], 'method' => 'patch']) !!}

                        @include('pos_intros.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection