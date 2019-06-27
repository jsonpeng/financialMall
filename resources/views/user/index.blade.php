@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">会员列表</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('user.create') !!}">添加</a>
        </h1>
    </section>


  
    <div class="content">
              <div class="box box-default box-solid" style="">
                <div class="box-header with-border">
                  <h3 class="box-title">查询</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form id="form_search">
                        <div class="form-group col-md-2">
                            <label>会员昵称</label>
                            <input type="text" class="form-control" name="nickname" id="nickname" placeholder="会员昵称"  @if (array_key_exists('nickname', $input))value="{{$input['nickname']}}"@endif >
                        </div>

                        <div class="form-group col-md-2">
                            <label>电话</label>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="电话"  @if (array_key_exists('mobile', $input))value="{{$input['mobile']}}"@endif >
                        </div>

                         <div class="form-group col-md-2">
                            <label>是否会员</label>
                            <select class="form-control" name="member">
                                <option value="全部" @if (!array_key_exists('member', $input)) selected="selected" @endif>全部</option>
                                <option value="是" @if (array_key_exists('member', $input) && $input['member'] == '是') selected="selected" @endif>是</option>
                                <option value="否" @if (array_key_exists('member', $input) && $input['member'] == '否') selected="selected" @endif>否</option>
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label>操作</label>
                            <button type="submit" class="btn btn-primary pull-right form-control" onclick="search()">查询</button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('user.table')
            </div>
        </div>
    </div>
    {!! $users->appends($input)->links() !!}
@endsection

@include('user.js')

