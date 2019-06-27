<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OldOrder;
use App\User;
use Carbon\Carbon;

class TongjiController extends Controller
{
    public function index(Request $request)
    {

    	//dd(OldOrder::where('pay_status','已支付')->where('money', 688 )->whereBetween('updated_at', ['2017-10-01', '2018-10-01'])->count());
        $input = $request->all();

        $days = 29;

        $range = \Carbon\Carbon::today()->subDays($days);

        $dates = [];
        $user_line = [];
        $member_line = [];

        for ($i=0; $i <= $days; $i++) {
            if ($range->isWeekend()) {
                $range = $range->addDay(1);
                continue;
            }
            $userCount = User::whereDate('created_at', $range)->count();
            $orderCount = OldOrder::where('pay_status','已支付')->whereDate('updated_at', $range)->count();
            array_push($dates, [$i, $range->format('m-d')]);
            array_push($user_line, [$i, $userCount]);
            array_push($member_line, [$i, $orderCount]);
            $range = $range->addDay(1);
        }

        $dates = json_encode($dates);
        $user_line = json_encode($user_line);
        $member_line = json_encode($member_line);

        //$now = Carbon::now();
        //处理用户输入
        if (!$request->has('time_start')) {
            $input['time_start'] = Carbon::today();
        }

        if (!$request->has('time_end')) {
            $input['time_end'] = Carbon::tomorrow();
        }

        $orders = OldOrder::where('pay_status','已支付')->whereBetween('updated_at', [$input['time_start'], $input['time_end']])->get();
        $order_count = $orders->count();
        $order_sum = $orders->sum('money');
        // $parent_users = array();
        // foreach ($orders as $key => $order) {
        // 	if ($order->user->parent_id) {
        // 		if (array_key_exists($order->user->parent_id, $parent_users)) {
        // 			$parent_users[$order->user->parent_id] += $order->money;
        // 		} else {
        // 			$parent_users[$order->user->parent_id] = $order->money;
        // 		}
        // 	}
        // }

        // $users = User::whereIn('id', array_keys($parent_users))->get();
        // foreach ($users as $key => $user) {
        // 	$user['yeji'] = $parent_users[$user->id];
        // }
        //粉丝总数
        $user_count = User::where('level', '用户')->count();
        $user_new = User::where('level', '用户')->whereBetween('created_at', [$input['time_start'], $input['time_end']])->count();
        return view('tongji.index', compact('order_count','order_sum','user_count','user_new', 'dates', 'user_line', 'member_line'))->withInput($input);
    }
}
