@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">信用卡</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('creditCards.create') !!}">添加</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-default box-solid" style="margin-top:20px;">
            <div class="box-header with-border">
              <h3 class="box-title">查询</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="form_search">
                    <div class="form-group col-md-2">
                        <label>信用卡名称</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder=""  @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif >
                    </div>

      {{--                <div class="form-group col-md-2">
                        <label>主题</label>
                        <select class="form-control" name="theme">
                            <option value="全部" @if (!array_key_exists('theme', $input) || $input['theme'] == '全部') selected="selected" @endif>全部</option>
                            @foreach ($creditCardThemes as $creditCardTheme)
                                <option value="{{$creditCardTheme->id}}" @if (array_key_exists('theme', $input) && $input['theme'] == $creditCardTheme->id) selected="selected" @endif>{{$creditCardTheme->name}}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="form-group col-md-2">
                        <label>银行</label>
                        <select class="form-control" name="bank">
                            <option value="全部" @if (!array_key_exists('bank', $input) || $input['bank'] == '全部' ) selected="selected" @endif>全部</option>
                            @foreach ($creditCardBanks as $creditCardBank)
                                <option value="{{$creditCardBank->id}}" @if (array_key_exists('bank', $input) && $input['bank'] == $creditCardBank->id) selected="selected" @endif>{{$creditCardBank->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label>操作</label>
                        <button type="submit" class="btn btn-primary pull-right form-control">查询</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <div class="box box-primary">
            <div class="box-body">
                    @include('credit_cards.table')
            </div>
        </div>
        <div class="text-center">
            {!! $creditCards->appends($input)->links() !!}
        </div>
    </div>
@endsection

