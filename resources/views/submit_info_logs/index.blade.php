@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">用户申请信息</h1>
     {{--    <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('submitInfoLogs.create') !!}">Add New</a>
        </h1> --}}
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('submit_info_logs.table')
            </div>
        </div>
        <div class="text-center">
            <div style="text-align: center;">{!! $submitInfoLogs->links() !!}</div>
        </div>
    </div>
@endsection

