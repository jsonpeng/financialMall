@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑试卷
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($paperList, ['route' => ['paperLists.update', $paperList->id], 'method' => 'patch']) !!}

                        @include('paper_lists.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection