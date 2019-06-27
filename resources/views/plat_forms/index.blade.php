@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">平台列表</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('platForms.create') !!}">添加</a>
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
                        <label>标题</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder=""  @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif >
                    </div>

                     <div class="form-group col-md-2">
                        <label>分类</label>
                        <select class="form-control" name="category">
                            <option value="全部" @if (!array_key_exists('category', $input) || $input['category'] == '全部') selected="selected" @endif>全部</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" @if (array_key_exists('category', $input) && $input['category'] == $category->id) selected="selected" @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label>排序</label>
                        <select name="order" class="form-control">
                            <option value="1" @if (array_key_exists('order', $input) && $input['order'] == '1') selected="selected" @endif>时间</option>
                            <option value="2" @if (array_key_exists('order', $input) && $input['order'] == '2') selected="selected" @endif>热门</option>
                            <option value="3" @if (array_key_exists('order', $input) && $input['order'] == '3') selected="selected" @endif>推荐</option>
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
                    @include('plat_forms.table')
            </div>
        </div>
        <div style="text-align: center;">{!! $platForms->appends($input)->links() !!}</div>
    </div>
@endsection

