@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            会员信息
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch']) !!}

                        @include('products.fields', ['product' => $product])

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>

   @include('partial.imagemodel')
@endsection