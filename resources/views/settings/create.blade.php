@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Setting
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary" style="max-width: 500px;">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'settings.store']) !!}

                        @include('settings.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  <script type="text/javascript">
     function changeImageId(id) {
        $('iframe#image').attr( 'src', '/filemanager/dialog.php?type=1&field_id=' + id);
    }
  </script>
@endsection