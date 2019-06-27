@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sound Post User Log
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('sound_post_user_logs.show_fields')
                    <a href="{!! route('soundPostUserLogs.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
