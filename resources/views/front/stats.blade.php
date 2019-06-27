<!DOCTYPE html>
<html style="height: 100%">
   <head>
       <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	    <meta http-equiv="Access-Control-Allow-Origin" content="*">
   </head>
   <body style="height: 100%; margin: 0">
   		<div>
   			<a href="/stats?type=1" class="changedate">当日</a> 
   			<a href="/stats?type=2" class="changedate">当月</a> 
   			<a href="/stats?type=3" class="changedate">上月</a> 
   			<a href="/stats?type=4" class="changedate">全部</a> 
   		</div>
   		<div style="padding: 15px;">提成：{{ $money_ticheng }} 已提：{{ $money_withdraw }} 待审：{{ $money_pedding }} 未提：{{ $money_user }}</div>

   		<div style="padding: 15px;"> {{ $level_chu }}  {{ $level_zhong }}  {{ $level_gao }}</div>
   		<!-- 本月提成 -->
        <div id="container01" style="height: 2000px"></div>
        <!-- 本月订单单数 -->
        <!-- 本月推荐数 -->
        <div id="container02" style="height: 2000px"></div>

		<!-- 历史提成 -->
        <div id="container03" style="height: 2000px"></div>


       <script src="{{ asset('vendor/echarts.common.min.js') }}"></script>
       <script type="text/javascript">

       		function getArray(value){
       			return value.split(',');
       		}

       		var name01 = getArray('{!! $name01 !!}');
       		var money01 = getArray('{!! $money01 !!}');

       		var name02 = getArray('{!! $name02 !!}');
       		var order02 = getArray('{!! $order02 !!}');
       		var register02 = getArray('{!! $register02 !!}');

       		var money03 = getArray('{!! $money03 !!}');

			var dom = document.getElementById("container01");
			var myChart = echarts.init(dom);
			var app = {};
			option = null;
			app.title = '会员提成金额';

			option = {
			    title: {
			        text: '会员提成金额',
			        subtext: '数据来自网络'
			    },
			    tooltip: {
			        trigger: 'axis',
			        axisPointer: {
			            type: 'shadow'
			        }
			    },
			    legend: {
			        data: ['提成']
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    xAxis: {
			        type: 'value',
			        boundaryGap: [0, 0.01]
			    },
			    yAxis: {
			        type: 'category',
			        data: name01
			    },
			    series: [
			        {
			            name: '',
			            type: 'bar',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'inside'
			                }
			            },
			            data: money01
			        }
			    ]
			};
			;
			if (option && typeof option === "object") {
			    myChart.setOption(option, true);
			}


			var dom = document.getElementById("container02");
			var myChart = echarts.init(dom);
			var app = {};
			option = null;
			app.title = '订单/推荐';

			option = {
			    title: {
			        text: '订单/推荐',
			        subtext: '数据来自网络'
			    },
			    tooltip: {
			        trigger: 'axis',
			        axisPointer: {
			            type: 'shadow'
			        }
			    },
			    color: ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
			    legend: {
			        data: ['订单数', '推荐会员数']
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    xAxis: {
			        type: 'value',
			        boundaryGap: [0, 0.01]
			    },
			    yAxis: {
			        type: 'category',
			        data: name02
			    },
			    series: [
			        {
			            name: '',
			            type: 'bar',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'inside'
			                }
			            },
			            itemStyle:{
			            	color: '#3c8dbc',
			            },
			            data: order02
			        },
			        {
			            name: '',
			            type: 'bar',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'inside'
			                }
			            },
			            data: register02
			        }
			    ]
			};
			;
			if (option && typeof option === "object") {
			    myChart.setOption(option, true);
			}

			var dom = document.getElementById("container03");
			var myChart = echarts.init(dom);
			var app = {};
			option = null;
			app.title = '金额';

			option = {
			    title: {
			        text: '金额',
			        subtext: '数据来自网络'
			    },
			    tooltip: {
			        trigger: 'axis',
			        axisPointer: {
			            type: 'shadow'
			        }
			    },
			    color: ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
			    legend: {
			        data: ['订单数']
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    xAxis: {
			        type: 'value',
			        boundaryGap: [0, 0.01]
			    },
			    yAxis: {
			        type: 'category',
			        data: name02
			    },
			    series: [
			        {
			            name: '',
			            type: 'bar',
			            label: {
			                normal: {
			                    show: true,
			                    position: 'inside'
			                }
			            },
			            itemStyle:{
			            	color: '#3c8dbc',
			            },
			            data: money03
			        }
			    ]
			};
			;
			if (option && typeof option === "object") {
			    myChart.setOption(option, true);
			}

       </script>
   </body>
</html>