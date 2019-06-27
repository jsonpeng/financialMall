<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Live;

class LiveController extends Controller
{
    public function lives()
    {
    	$lives = app('commonRepo')->liveRepo()->allCached();
    	return response()->json(['status_code' => 0, 'data' => ['message' => $lives]] );
    }

    public function live(Request $request, $id)
    {
    	$live = app('commonRepo')->liveRepo()->getById($id);
    	return response()->json(['status_code' => 0, 'data' => ['message' => $live]] );
    }
}
