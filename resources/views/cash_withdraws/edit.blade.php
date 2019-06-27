@extends('layouts.app')

@section('content')
     <style>
         .user-info{
            padding: 10px;
         }
     </style>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    <div class="user-info col-md-2">用户姓名: {{$user->name}}</div>
                    <div class="user-info col-md-2">电话: {{$user->mobile}}</div>
                    <div class="user-info col-md-2">注册时间: {{$user->created_at}}</div>
                    <div class="user-info col-md-2">会员等级: {{$user->level_name}}</div>
                    <div class="user-info col-md-2">会员到期: {{$user->member_end_time}}</div>
                    <div class="user-info col-md-2">会员购买金额: {{$user->member_buy_money}}</div>
                    <div class="user-info col-md-2">账户余额: {{$user->money}}</div>
                    <div class="user-info col-md-2">收入统计: {{$incomes}}</div>
                    <div class="user-info col-md-2">已提现金额: {{$withdraws_done}}</div>
                    <div class="user-info col-md-2">待审核金额: {{$withdraws_pendding}}</div>
                    
                </div>
            </div>
            @if(!$order_count)
                <div class="callout callout-danger">
                    <h4>用户从未购买过会员</h4>
                    <p>没有购买过会员的人，一般不具备推广的权利，账户中应该没有金额可供提现</p>
                </div>
            @endif

            @if( abs($user->money+$withdraws_done+$withdraws_pendding - $incomes) > 1 )
                <div class="callout callout-danger">
                    <h4>用户的账户余额不正常</h4>
                    <p>用户的账户余额+已提现金额+带审核提现金额与总收入不匹配</p>
                </div>
            @endif
            

           <div class="box-body">
               <div class="row">
                
                    <!-- Count Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('count', '提取金额:') !!}
                        {{-- {!! Form::number('count', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!} --}}
                        <input type="number" name="count" class="form-control" value="{{ $cashWithdraw->count }}" disabled="disabled">
                    </div>

                    <!-- Name Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('name', '姓名:') !!}  
                        {{-- {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!} --}}
                        <input type="text" name="name" class="form-control" value="{{ $cashWithdraw->name }}" disabled="disabled">
                    </div>

                    <!-- Zhifubao Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('zhifubao', '支付宝账号:') !!}
                        {{-- {!! Form::text('zhifubao', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!} --}}
                        <input type="text" name="zhifubao" class="form-control" value="{{ $cashWithdraw->zhifubao }}" disabled="disabled">
                    </div>

                    <div class="form-group col-sm-12">
                        <span class="label 
                        @if($cashWithdraw->status == '待审核') label-warning @endif 
                        @if($cashWithdraw->status == '审核通过') label-success @endif
                        @if($cashWithdraw->status == '审核不通过' || $cashWithdraw->status == '失败') label-danger @endif

                        ">{{ $cashWithdraw->status }}</span>
                        
                    </div>

                    @if ($cashWithdraw->status == '待审核')
                        <div class="form-group col-sm-12">
                            {!! Form::label('reason', '备注:') !!}
                            {{-- {!! Form::text('reason', null, ['class' => 'form-control']) !!} --}}
                            <input type="text" name="reason" class="form-control" value="{{ $cashWithdraw->reason }}">
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <div class="btn btn-success" onclick="confirm()">在线转账</div>
                            <div class="btn btn-warning" onclick="reject()">拒绝</div>
                            <div class="btn btn-default" onclick="byHand()">手动转账</div>
                        </div>

                    @endif

                    @if ($cashWithdraw->status == '审核通过')
                        <!-- Trade No Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('trade_no', '交易号:') !!}
                            <div class="form-control"> {!! $cashWithdraw->trade_no !!} </div>
                        </div>

                        <!-- Out Trade No Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('out_trade_no', '商户号:') !!}
                            <div class="form-control"> {!! $cashWithdraw->out_trade_no !!} </div>
                        </div>
                    @endif

                    @if ($cashWithdraw->status == '审核不通过')
                        <div class="form-group col-sm-12">
                            {!! Form::label('reason', '备注:') !!}
                            {{-- {!! Form::text('reason', null, ['class' => 'form-control']) !!} --}}
                            <input type="text" name="reason" class="form-control" value="{{ $cashWithdraw->reason }}">
                        </div>
                    @endif

                    @if ($cashWithdraw->status == '失败')
                        <!-- Reason Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('reason', '备注:') !!}
                            {{-- {!! Form::text('reason', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!} --}}
                            <input type="text" name="reason" class="form-control" value="{{ $cashWithdraw->reason }}" disabled="disabled">
                        </div>
                    @endif

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        <a href="{!! route('cashWithdraws.index') !!}" class="btn btn-default">返回</a>
                    </div>


               </div>
           </div>
       </div>
   </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        function confirm() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/ajax/confirm_cash_withdraw/{{ $cashWithdraw->id }}",
                type:"GET",
                data:'',
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                  setTimeout(function(){
                    location.reload();
                  }, 1000);
                },
                error: function(data) {
                  //提示失败消息

                },
            });  
        }

        function byHand() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/ajax/confirm_cash_byhand/{{ $cashWithdraw->id }}",
                type:"GET",
                data:'',
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                  setTimeout(function(){
                    location.reload();
                  }, 1000);
                },
                error: function(data) {
                  //提示失败消息

                },
            });  
        }

        function reject() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/ajax/reject_cash_withdraw/{{ $cashWithdraw->id }}",
                type:"GET",
                data:'reason='+$('input[name=reason]').val(),
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                  setTimeout(function(){
                    location.reload();
                  }, 1000);
                },
                error: function(data) {
                  //提示失败消息

                },
            });  
        }
        
    </script>
@endsection