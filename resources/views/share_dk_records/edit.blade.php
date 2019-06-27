@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Share Dk Record
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($shareDkRecord, ['route' => ['shareDkRecords.update', $shareDkRecord->id], 'method' => 'patch']) !!}

                        @include('share_dk_records.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection