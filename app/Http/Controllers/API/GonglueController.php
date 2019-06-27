<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gonglue;

class GonglueController extends Controller
{
    public function list()
    {
    	$gonglues = Gonglue::where('shelf', 1)->orderBy('sort', 'desc')->get();
    	return response()->json(['status_code' => 0, 'data' => ['message' => $gonglues]] );
    }

    public function detail(Request $request, $id)
    {
    	$gonglue = Gonglue::where('shelf', 1)->where('id', $id)->first();
    	if (empty($gonglue)) {
    		return response()->json(['status_code' => 1, 'data' => ['message' => '信息不存在']] );
    	} else {
    		return response()->json(['status_code' => 0, 'data' => ['message' => $gonglue]] );
    	}
    }
}
