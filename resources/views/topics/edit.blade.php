@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑试卷{!!  a_link($paper->name,route('paperLists.edit', [$paper->id])) !!}的试题
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($topics, ['route' => ['topics.update',$paper->id,$topics->id], 'method' => 'patch']) !!}

                        @include('topics.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection