@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            平台介绍
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
                            {!! Form::label('intro', '平台介绍:') !!}
                            {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('tishi', '温馨提示:') !!}
                            {!! Form::textarea('tishi', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('share_intro', '分享赚钱:') !!}
                            {!! Form::textarea('share_intro', null, ['class' => 'form-control intro']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('earn_intro', '推广赚钱:') !!}
                            {!! Form::textarea('earn_intro', null, ['class' => 'form-control intro']) !!}
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