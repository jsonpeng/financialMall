@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('share_dk_records.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>

        <div style="text-align: center;">{!! $shareDkRecords->links() !!}</div>
    </div>
@endsection

