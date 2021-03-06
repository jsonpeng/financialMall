@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">申请记录</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('submit_forms.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>

        <div style="text-align: center;">{!! $submitForms->links() !!}</div>
    </div>
@endsection

