@extends('layouts.app')

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($hkjBanner, ['route' => ['hkjBanners.update', $hkjBanner->id], 'method' => 'patch']) !!}

                        @include('hkj_banners.fields', ['hkjBanner ' => $hkjBanner ])

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partial.imagemodel')
@endsection