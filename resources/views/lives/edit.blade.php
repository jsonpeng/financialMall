@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/datatimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($live, ['route' => ['lives.update', $live->id], 'method' => 'patch']) !!}

                        @include('lives.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partial.imagemodel')

@endsection


@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/datatimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatimepicker/locales/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script type="text/javascript">
         $('#time_start, #time_end').datetimepicker({
            format: "yyyy-mm-dd hh:mm",
            language: "zh-CN",
            autoclose: true,
            todayHighlight: true
          });
    </script>
@endsection