<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PostCategory;

class CategoryController extends Controller
{
    public function categories()
    {
    	return response()->json(['status_code' => 0, 'data' => ['message' => app('commonRepo')->catRepo()->CacheAll()]] );
    }

}
