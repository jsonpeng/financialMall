@extends('layouts.app')

@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($creditCardBank, ['route' => ['creditCardBanks.update', $creditCardBank->id], 'method' => 'patch']) !!}

                        @include('credit_card_banks.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partial.imagemodel')
@endsection