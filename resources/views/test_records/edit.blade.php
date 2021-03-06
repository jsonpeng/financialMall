@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Test Records
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($testRecords, ['route' => ['testRecords.update', $testRecords->id], 'method' => 'patch']) !!}

                        @include('test_records.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection