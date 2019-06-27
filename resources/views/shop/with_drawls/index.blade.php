@extends('shop.layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">钱包用户操作记录</h1>
        <h1 class="pull-right">
        
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('shop.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('shop.with_drawls.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

