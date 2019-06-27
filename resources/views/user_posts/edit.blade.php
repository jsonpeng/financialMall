@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Post
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($userPost, ['route' => ['userPosts.update', $userPost->id], 'method' => 'patch']) !!}

                        @include('user_posts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection