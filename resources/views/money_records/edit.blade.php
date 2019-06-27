@extends('layouts.app')

@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($moneyRecord, ['route' => ['moneyRecords.update', $moneyRecord->id], 'method' => 'patch']) !!}

                        @include('money_records.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection