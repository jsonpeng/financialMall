@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Complaint Log
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($complaintLog, ['route' => ['complaintLogs.update', $complaintLog->id], 'method' => 'patch']) !!}

                        @include('complaint_logs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection