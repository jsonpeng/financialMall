<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tool;
use App\Models\ToolCat;

class ToolController extends Controller
{
    public function tools(Request $request)
    {
        $tools = [];
        if ($request->has('slug') && !empty($request->input('slug'))) {
            $toolCat = ToolCat::where('slug', $request->input('slug'))->first();
            if (!empty($toolCat)) {
                $tools = Tool::where('cat_id', $toolCat->id)->get();
            }            
        }else{
            $tools = Tool::all();
        }
    	
    	return response()->json(['status_code' => 0, 'data' => $tools] );
    }

    public function toolsByCat()
    {
    	$toolCats = ToolCat::orderBy('sort', 'desc')->get();
    	foreach ($toolCats as $key => $value) {
    		$value['tools'] = Tool::where('cat_id', $value->id)->get();
    	}
    	return response()->json(['status_code' => 0, 'data' => $toolCats] );
    }
}
