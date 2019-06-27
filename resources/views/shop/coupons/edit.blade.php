@extends('shop.layouts.app_promp')

@include('shop.coupons.partial.css')

@section('content')
    <section class="content-header">
        <h1 class="pb15-xs">
            编辑优惠券
        </h1>
   </section>
   <div class="content pdall0-xs">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary form">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($coupon, ['route' => ['coupons.update', $coupon->id], 'method' => 'patch']) !!}

                        @include('shop.coupons.fields', ['level01' => $level01])

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@include('shop.coupons.partial.js')
