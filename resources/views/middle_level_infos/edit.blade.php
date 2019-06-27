@extends('layouts.app')

@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body form">
               <div class="row">
                   {!! Form::model($middleLevelInfo, ['route' => ['middleLevelInfos.update', $middleLevelInfo->id], 'method' => 'patch']) !!}

                        @include('middle_level_infos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partial.imagemodel')
@endsection

@section('scripts')

@include('middle_level_infos.js')
<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
<script type="text/javascript">

    var previewTemplate='<div class="dz-preview dz-file-preview uploads_box"><img class="success_img" data-dz-thumbnail/><input type="hidden" name="post_images[]" value=""><span class="dz-progress"></span><div class="zhezhao" data-status="none"></div></div>';

    var myDropzone = new Dropzone("#fileUploader", { url: "/zcjy/qiniu_file_upload" , previewTemplate: previewTemplate, addRemoveLinks:true});

    myDropzone.on("success",function(file, data){
        $('#link').val(data.url);
    });

</script>

@endsection