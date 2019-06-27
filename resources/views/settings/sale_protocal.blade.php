@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            销售服务协议
        </h1>
   </section>
   <div class="content">
       @include('flash::message')
       <div class="box box-primary" style="max-width: 500px;">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($settingAdmin, ['route' => ['settings.update', $settingAdmin->id], 'method' => 'patch']) !!}

                        <!-- Name Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('law_sale', '销售服务协议:') !!}
                            {!! Form::textarea('law_sale', null, ['class' => 'form-control intro']) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                        </div>


                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection