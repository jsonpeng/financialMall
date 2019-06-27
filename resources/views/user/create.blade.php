@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            添加会员
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'user.createAction','method' => 'POST']) !!}

                        <div class="form-group col-sm-12">
                            {!! Form::label('name', '用户名称:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('email', '邮箱:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('password', '密码:') !!}
                            {!! Form::text('password', null, ['class' => 'form-control']) !!}
                        </div>

                         <div class="form-group col-sm-12">
                            {!! Form::label('mobile', '手机号:') !!}
                            {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
                        </div>

                         <div class="form-group col-sm-12">
                            {!! Form::label('mobile_enter', '确认手机号:') !!}
                            {!! Form::text('mobile_enter', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('level_id', '会员等级:') !!}
                            <div style="overflow: hidden;">
                                <?php 
                                    $active = 0;
                                    foreach ($levels as $key => $value) 
                                    {
                                        if(isset($value->active))
                                        {
                                            $active = 1;
                                        }
                                    }
                                ?>
                                <select name="level_id" class="form-control">
                                    
                                     <option value="0" @if($active) selected="selected" @endif>无</option>
                                    @foreach ($levels as $level)
                                        <option value="{{$level->id}}" @if(isset($level->active)) selected="selected" @endif>{!! $level->name !!}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('user.user_list') !!}" class="btn btn-default">取消</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @include('partial.imagemodel')
@endsection

@include('layouts.js')