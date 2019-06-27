@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Product Level Price
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($productLevelPrice, ['route' => ['productLevelPrices.update', $productLevelPrice->id], 'method' => 'patch']) !!}

                        @include('product_level_prices.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection