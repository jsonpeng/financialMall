@extends('layouts.app')

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch']) !!}

                        @include('posts.fields', ['categories' => $categories, 'post' => $post])

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partial.imagemodel')
@endsection