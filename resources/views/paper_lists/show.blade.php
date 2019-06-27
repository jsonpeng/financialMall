@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Paper List
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('paper_lists.show_fields')
                    <a href="{!! route('paperLists.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
