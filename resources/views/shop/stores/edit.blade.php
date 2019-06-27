@extends('shop.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑店铺
        </h1>
   </section>
   <div class="content">
       @include('flash::message')
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($store, ['route' => ['stores.update', $store->id], 'method' => 'patch']) !!}

                        @include('shop.stores.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('shop.partial.imagemodel')
@endsection

@include('shop.stores.js')