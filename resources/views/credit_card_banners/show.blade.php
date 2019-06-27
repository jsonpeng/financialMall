@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('credit_card_banners.show_fields')
                    <a href="{!! route('creditCardBanners.index') !!}" class="btn btn-default">后退</a>
                </div>
            </div>
        </div>
    </div>
@endsection
