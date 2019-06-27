<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', '姓名:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Mobile Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mobile', '手机号:') !!}
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Mobile Lg Half Year Field -->
<div class="form-group col-sm-4">
    {!! Form::label('whether_mobile_lg_half_year', '电话是否半年以上:') !!}
    {!! Form::text('whether_mobile_lg_half_year', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Shimingzhi Field -->
<div class="form-group col-sm-4">
    {!! Form::label('whether_shimingzhi', '是否实名制:') !!}
    {!! Form::text('whether_shimingzhi', null, ['class' => 'form-control']) !!}
</div>

<!-- Age Field -->
<div class="form-group col-sm-4">
    {!! Form::label('age', '年龄:') !!}
    {!! Form::text('age', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Has Xycard Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_has_xycard', '有无信用卡[几张]:') !!}
    {!! Form::text('whether_has_xycard', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Normal Use Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_normal_use', '是否正常使用:') !!}
    {!! Form::text('whether_normal_use', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Has Delay Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_has_delay', '有无预期:') !!}
    {!! Form::text('whether_has_delay', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Give Xycard Log Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_give_xycard_log', '是否能提供信用卡账单邮箱6个月以上:') !!}
    {!! Form::text('whether_give_xycard_log', null, ['class' => 'form-control']) !!}
</div>

<!-- Zhimafen Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zhimafen', '芝麻分多少:') !!}
    {!! Form::text('zhimafen', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Is Wanghei Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_is_wanghei', '是否是网黑:') !!}
    {!! Form::text('whether_is_wanghei', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Wangdai Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_wangdai', '最近有无频繁网贷:') !!}
    {!! Form::text('whether_wangdai', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Had Job Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_had_job', '有无稳定工作:') !!}
    {!! Form::text('whether_had_job', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Has Shebao Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_has_shebao', '有无社保:') !!}
    {!! Form::text('whether_has_shebao', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Has Gongjijin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_has_gongjijin', '有无公积金:') !!}
    {!! Form::text('whether_has_gongjijin', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Is Student Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_is_student', '是否是学生:') !!}
    {!! Form::text('whether_is_student', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Has Xuexinwang Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_has_xuexinwang', '是否有学信网账号:') !!}
    {!! Form::text('whether_has_xuexinwang', null, ['class' => 'form-control']) !!}
</div>

<!-- Whether Know Dk Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whether_know_dk', '是否能提供信用卡账单邮箱6个月以上:') !!}
    {!! Form::text('whether_know_dk', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('submitInfoLogs.index') !!}" class="btn btn-default">返回</a>
</div>
