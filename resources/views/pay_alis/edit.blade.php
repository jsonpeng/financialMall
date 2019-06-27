@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            支付宝
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($payAli, ['route' => ['payAlis.update', $payAli->id], 'method' => 'patch']) !!}

                        @include('pay_alis.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection