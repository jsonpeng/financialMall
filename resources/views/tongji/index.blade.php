@extends('layouts.app')


@section('css')
    <style type="text/css">
        .box-body{
            background-color: #fff;
        }
    </style>
@endsection

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box-header with-border">
            <h3 class="box-title">用户筛选</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <form id="form_search" style="margin-left: -15px;">
                <div class="form-group col-md-4">
                    <label>起始时间</label>
                    <input type="text" class="form-control" name="time_start" id="time_start" placeholder="开始时间"  @if (array_key_exists('time_start', $input))value="{{substr($input['time_start'],0,10)}}"@endif  {!! Request::is('memberCount*') || Request::is('memberCount/month') ? 'disabled' : '' !!}>
                </div>
                <div class="form-group col-md-4">
                    <label>结束时间</label>
                    <input type="text" class="form-control" name="time_end" id="time_end" placeholder="结束时间" @if (array_key_exists('time_end', $input))value="{{substr($input['time_end'],0,10)}}"@endif {!! Request::is('memberCount*') || Request::is('memberCount/month') ? 'disabled' : '' !!}>
                </div>

                <div class="form-group col-md-2">
                    <label>操作</label>
                    <button type="submit" class="btn btn-primary pull-right form-control">查询</button>
                </div>
            </form>
        </div><!-- /.box-body -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">VIP订阅人数</span>
                            <span class="info-box-number">{{$order_count}}</span>
                            <span class="info-box-text">VIP订阅金额</span>
                            <span class="info-box-number">{{$order_sum}}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">用户总数</span>
                            <span class="info-box-number">{{$user_count}}</span>
                            <span class="info-box-text">新增新增数</span>
                            <span class="info-box-number">{{$user_new}}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
            </div>
        </div>

        <div>   
            <div class="box box-primary">
                <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">会员统计</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div id="line-chart" style="height: 300px;"></div>
                </div><!-- /.box-body-->
              </div><!-- /.box -->
        </div>

        {{-- <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive" id="orders-table">
                    <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>业绩</th>
                            <th>提成</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td><img src="{!! $user->header !!}" style="width: 25px;"></td>
                            <td>{!! $user->nickname !!}</td>
                            <td>{!! $user->yeji !!}</td>
                            <td>@if(empty($user->scale)) {!! $user->yeji * $setting->scale / 100 !!} @else {!! $user->yeji * $user->scale !!} @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>

@endsection


@section('scripts')

    <!-- FLOT CHARTS -->
    <script src="vendor/adminLTE/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="vendor/adminLTE/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        /*
         * LINE CHART
         * ----------
         */
        //LINE randomly generated data
        var sin = {{ $user_line }}, cos ={{ $member_line }};

        var line_data1 = {
          data: sin,
          color: "#3c8dbc"
        };
        var line_data2 = {
          data: cos,
          color: "#00c0ef"
        };
        $.plot("#line-chart", [line_data1, line_data2], {
          grid: {
            hoverable: true,
            borderColor: "#f3f3f3",
            borderWidth: 1,
            tickColor: "#f3f3f3"
          },
          series: {
            shadowSize: 0,
            lines: {
              show: true
            },
            points: {
              show: true
            }
          },
          lines: {
            fill: false,
            color: ["#3c8dbc", "#f56954"]
          },
          yaxis: {
            show: true,
          },
          xaxis: {
            show: true,
            ticks: {!! $dates !!}
          },
          legend: {
              show: true,
              // 格式化图例的显示
              labelFormatter:null,
              labelBoxBorderColor: '#333',
              noColumns: 2,
              position:"ne",
              margin: 10

          }
        });
    </script>

    <script type="text/javascript">
        $('#time_start, #time_end').datepicker({
            format: "yyyy-mm-dd",
            language: "zh-CN",
            todayHighlight: true
          });
    </script>
@endsection


