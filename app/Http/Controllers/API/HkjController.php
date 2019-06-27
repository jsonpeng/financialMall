<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\HkjRepository;
use App\Repositories\HkjCatRepository;
use App\Models\HkjBanner;
use App\Models\Hkj;
use Log;

class HkjController extends Controller
{

	private $hkjRepository;
    private $hkjCatRepository;

    public function __construct(HkjRepository $hkjRepo, HkjCatRepository $hkjCatRepo)
    {
        $this->hkjRepository = $hkjRepo;
        $this->hkjCatRepository = $hkjCatRepo;
    }

    public function cats()
    {
        //$cats = $this->hkjCatRepository->all();
        //$cats = $this->hkjCatRepository->allCached();
        $hkjCats = app('commonRepo')->hkjCatRepo()->CacheAll();
        return response()->json(['status_code' => 0, 'data' => ['message' => $hkjCats]] );
    }

    public function list(Request $request)
    {
    	$inputs = $request->all();
    	$skip = 0;
    	$take = 20;
        $cat = 0;
    	if (array_key_exists('skip', $inputs)) {
    		$skip = intval($inputs['skip']);
    	}
    	if (array_key_exists('take', $inputs)) {
    		$take = intval($inputs['take']);
    	}
        if (array_key_exists('cat', $inputs)) {
            $cat = intval($inputs['cat']);
        }
        $hkjs = $this->hkjRepository->getHkj($skip, $take, $cat);

        // foreach ($hkjs as $hkj) {
        //     $hkj['decription'] = $hkj->des;
        //     $hkj['intro'] = '';
        // }

    	return response()->json(['status_code' => 0, 'data' => ['message' => $hkjs]] );
    	
    }

    public function hkjSearch(Request $request)
    {
        if (!$request->has('text') || empty($request->input('text'))) {
            return response()->json(['status_code' => 0, 'data' => ['message' => []]] );
        }

        $hkjs = Hkj::where('name', 'like', '%'.$request->input('text').'%')->take(50)->get();

        return response()->json(['status_code' => 0, 'data' => ['message' => $hkjs]] );
    }

    public function hkjDetail(Request $request, $id)
    {   
    	$hkj = $this->hkjRepository->getHkjDetail($id);
    	if (empty($hkj)) {
    		return response()->json(['status_code' => 1, 'data' => ['error' => '信息不存在' ]] );
    	} else {
    		return response()->json(['status_code' => 0, 'data' => $hkj] );
    	}
    }


    public function banners(Request $request)
    {
        // $banners = HkjBanner::all();
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner($request->input('name'));
        $images = [];
        foreach ($banners as $banner) {
            array_push($images, $banner->image);
        }
        return response()->json(['status_code' => 0, 'data' => ['message' => $images, 'banners' => $banners]] );
    }
}
