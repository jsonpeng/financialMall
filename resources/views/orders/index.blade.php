@extends('layouts.app')

@section('content')
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
                    <div class="form-group col-md-4">
                        <label>手机号</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="手机号"  @if (array_key_exists('mobile', $input))value="{{$input['mobile']}}"@endif >
                    </div>
                    <div class="form-group col-md-4">
                        <label>商户号</label>
                        <input type="text" class="form-control" name="pay_no" id="pay_no" placeholder="商户号"  @if (array_key_exists('pay_no', $input))value="{{$input['pay_no']}}"@endif >
                    </div>

                    <div class="form-group col-md-4">
                        <label>交易号</label>
                        <input type="text" class="form-control" name="trade_no" id="trade_no" placeholder="交易号"  @if (array_key_exists('trade_no', $input))value="{{$input['trade_no']}}"@endif >
                    </div>

               {{--      <div class="form-group col-md-4">
                        <label>支付状态</label>
                        
                    </div> --}}

                    <div class="form-group col-md-1">
                        <label>操作</label>
                        <button type="submit" class="btn btn-primary pull-right form-control" onclick="search()">查询</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body">
                    @include('orders.table')
            </div>
        </div>
    </div>
    <div style="text-align: center;">{!! $orders->appends($input)->links() !!}</div>
@endsection

