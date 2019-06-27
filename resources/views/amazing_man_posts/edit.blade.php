@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Amazing Man Post
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($amazingManPost, ['route' => ['amazingManPosts.update', $amazingManPost->id], 'method' => 'patch']) !!}

                        @include('amazing_man_posts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection