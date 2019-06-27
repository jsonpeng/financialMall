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
                            {!! Form::label('intro_text', '首页音频文字:') !!}
                            {!! Form::text('intro_text', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Name Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('intro_voice', '首页音频链接:') !!}
                            {!! Form::text('intro_voice', null, ['class' => 'form-control']) !!}
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


$table->dropColumn('intro_text');
                $table->dropColumn('intro_voice');