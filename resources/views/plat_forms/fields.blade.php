<div class="form-group col-sm-8">
    <div class="box box-solid">
        <div class="box-body">
            <!-- Name Field -->
            <div class="form-group">
                {!! Form::label('name', '名称:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('name', '分类:') !!}
                <div style="overflow: hidden;">
                    <select name="plat_form_cat_id" class="form-control">
                    @foreach ($categories as $tmp)
                        <option value="{{$tmp->id}}" @if(!empty($platForm) && $platForm->plat_form_cat_id == $tmp->id) selected="selected" @endif>{!! $tmp->name !!}</option>
                    @endforeach
                    </select>
                </div>
            </div>

            <!-- Brief Field -->
            <div class="form-group">
                {!! Form::label('brief', '简介:') !!}
                {!! Form::textarea('brief', null, ['class' => 'form-control', 'maxlength' => 190]) !!}
            </div>

            <!-- Jiehao Field 
            <div class="form-group">
                {!! Form::label('jiehao', '平台介绍(500字以内):') !!}
                {!! Form::textarea('jiehao', null, ['class' => 'form-control', 'maxlength' => 500, 'onkeyup' => "this.value = this.value.substring(0, 500)"]) !!}
            </div>-->

            <!-- Tiaojian Field -->
            <div class="form-group">
                {!! Form::label('tiaojian', '申请条件(500字以内):') !!}
                {!! Form::textarea('tiaojian', null, ['class' => 'form-control', 'maxlength' => 500, 'onkeyup' => "this.value = this.value.substring(0, 500)"]) !!}
            </div>

            <!-- Cailiao Field -->
            <div class="form-group">
                {!! Form::label('cailiao', '申请材料(500字以内):') !!}
                {!! Form::textarea('cailiao', null, ['class' => 'form-control', 'maxlength' => 500, 'onkeyup' => "this.value = this.value.substring(0, 500)"]) !!}
            </div>
        </div><!-- /.box-body -->
    </div>
</div>

<div class="form-group col-sm-4">

    <div class="box box-solid">
        <div class="box-body">
            <!-- Submit Field -->
            <div class="form-group">
                {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                <a href="{!! route('platForms.index') !!}" class="btn btn-default">取消</a>
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-body">
            <!-- Submit Field -->
            <div class="form-group">
                {!! Form::label('edu_min', '最低额度:') !!}
                {!! Form::number('edu_min', null, ['class' => 'form-control', 'min' => 0]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('edu_max', '最高额度:') !!}
                {!! Form::number('edu_max', null, ['class' => 'form-control', 'max' => 10000000]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('time', '借贷周期:') !!}
                {!! Form::select('time', ['日'=>'日', '月'=>'月'], null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('time_min', '最小借贷周期:') !!}
                {!! Form::number('time_min', null, ['class' => 'form-control', 'min' => 1]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('time_max', '最大借贷周期:') !!}
                {!! Form::number('time_max', null, ['class' => 'form-control', 'max' => 100]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('rate', '利率(%,如果周期是日就写日利率，如果周期是月就写月利率)') !!}
                {!! Form::text('rate', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('fangkuan', '放款时间') !!}
                {!! Form::text('fangkuan', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-body">
             <!-- Image Field -->
            <div class="form-group">
                {!! Form::label('image', '图片:') !!}
                <div class="input-append">
                    {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
                    <img src="@if(!empty($platForm)) {{$platForm->image}} @else http://temp.im/75x75/333/EEE @endif" style="width: 75px; height: 75px; display: block; ">
                    <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" style="padding: 0;">设置图片(75x75)</a>
                </div>
            </div>

            <!-- Star Field -->
            <div class="form-group">
                {!! Form::label('star', '评级:') !!}
                {!! Form::number('star', null, ['class' => 'form-control', 'min' => 1, 'max' => 5]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('sort', '排序权重:') !!}
                {!! Form::number('sort', null, ['class' => 'form-control', 'min' => 1, 'max' => 50]) !!}
            </div>

            <!-- Remark Field -->
            <div class="form-group">
                {!! Form::label('remark', '特点(多特点英文逗号,分割):') !!}
                {!! Form::text('remark', null, ['class' => 'form-control']) !!}
            </div>

            <!-- View Field -->
            <div class="form-group">
                {!! Form::label('view', '浏览量:') !!}
                {!! Form::number('view', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Link Field -->
            <div class="form-group">
                {!! Form::label('link', '链接:') !!}
                {!! Form::text('link', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label class="fb">{!! Form::checkbox('hot', 1, null, ['class' => 'field minimal']) !!}热门</label>
            </div>
        </div>
    </div>
    
</div>
