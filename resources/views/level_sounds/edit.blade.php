@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Level Sound
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($levelSound, ['route' => ['levelSounds.update', $levelSound->id], 'method' => 'patch']) !!}

                        @include('level_sounds.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection