<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\XykIntro;
use App\Models\XykApply;
use App\Models\PosIntro;
use App\Models\PosApply;

class ApplyController extends Controller
{
    public function xyk()
    {
    	$xykIntro = XykIntro::first();
    	return view('front.apply.xyk', compact('xykIntro'));
    }

    public function postXyk(Request $request)
    {
    	if (!$request->has('name')) {
    		return ['code' => 1, 'message' => '请输入姓名'];
    	}
    	if (!$request->has('mobile')) {
    		return ['code' => 1, 'message' => '请输入手机号'];
    	}
    	if (!$request->has('info')) {
    		return ['code' => 1, 'message' => '请输入信用卡使用状况'];
    	}
    	XykApply::create($request->all());
    	return ['code' => 0, 'message' => '成功'];

    }


    public function pos()
    {
    	$posIntro = PosIntro::first();
    	return view('front.apply.pos', compact('posIntro'));
    }

    public function postPos(Request $request)
    {
    	if (!$request->has('name')) {
    		return ['code' => 1, 'message' => '请输入姓名'];
    	}
    	if (!$request->has('mobile')) {
    		return ['code' => 1, 'message' => '请输入手机号'];
    	}
    	if (!$request->has('card_num')) {
    		return ['code' => 1, 'message' => '请输入信用卡使用状况'];
    	}
    	if (!$request->has('address')) {
    		return ['code' => 1, 'message' => '请输入信用卡使用状况'];
    	}
    	PosApply::create($request->all());
    	return ['code' => 0, 'message' => '成功'];

    }
}
