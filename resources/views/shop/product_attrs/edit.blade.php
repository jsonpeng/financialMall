@extends('shop.layouts.app_shop')

@section('content')
  <div class="container-fluid" style="padding: 30px 15px;">
        <div class="row">
            <div class="col-sm-3 col-lg-2">
                <ul class="nav nav-pills nav-stacked nav-email">
                    <li class="{{ Request::is('shop/productTypes*') ? 'active' : '' }}">
                        <a href="{!! route('productTypes.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-user"></i> 模型
                        </a>
                    </li>
                    <li class="{{ Request::is('shop/specs*') ? 'active' : '' }}">
                        <a href="{!! route('specs.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-users"></i> 规格
                        </a>
                    </li>
                    <li class="{{ Request::is('shop/productAttrs*') ? 'active' : '' }}">
                        <a href="{!! route('productAttrs.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-key"></i> 属性
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9 col-lg-10">
             <div class="content pdall0-xs">
                 @include('adminlte-templates::common.errors')
                 <div class="box box-primary form">
                     <div class="box-body">
                         <div class="row">
                             {!! Form::model($productAttr, ['route' => ['productAttrs.update', $productAttr->id], 'method' => 'patch']) !!}

                                  @include('shop.product_attrs.fields')

                             {!! Form::close() !!}
                         </div>
                     </div>
                 </div>
             </div>
           </div>
         </div>
       </div>
@endsection