@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sound Post User Log
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($soundPostUserLog, ['route' => ['soundPostUserLogs.update', $soundPostUserLog->id], 'method' => 'patch']) !!}

                        @include('sound_post_user_logs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection