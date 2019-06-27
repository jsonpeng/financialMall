@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Bank Card
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bankCard, ['route' => ['bankCards.update', $bankCard->id], 'method' => 'patch']) !!}

                        @include('bank_cards.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection