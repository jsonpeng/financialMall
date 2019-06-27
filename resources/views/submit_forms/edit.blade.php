@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Submit Form
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($submitForm, ['route' => ['submitForms.update', $submitForm->id], 'method' => 'patch']) !!}

                        @include('submit_forms.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection