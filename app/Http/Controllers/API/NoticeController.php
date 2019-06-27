<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    public function index()
    {
    	$notices = app('commonRepo')->noticeRepo()->CacheAll();

    	$popup = app('commonRepo')->noticeRepo()->PopNotice();
    	return response()->json(['status_code' => 0, 'data' => ['message' => $notices, 'popup' => $popup]] );
    }

    public function show(Request $request, $id)
    {
    	$notice = app('commonRepo')->noticeRepo()->getBuyID($id);
    	return response()->json(['status_code' => 0, 'data' => ['message' => $notice]] );
    }
}
