<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\PlatFormRepository;
use App\Repositories\PlatFormCatRepository;

use App\Models\PlatFormCat;
use App\Models\PlatForm;
use App\Models\PlatformBanner;

class PlatformController extends Controller
{

	private $platFormRepository;
    private $platFormCatRepository;

    public function __construct(PlatFormRepository $platFormRepo, PlatFormCatRepository $platFormCatRepo)
    {
        $this->platFormRepository = $platFormRepo;
        $this->platFormCatRepository = $platFormCatRepo;
    }

	/**
	 * 获取平台分类
	 * @Author   Hybrid
	 * @DateTime 2018-02-26
	 * @return   [type]     [description]
	 */
    public function platformCats()
    {
    	return response()->json(['status_code' => 0, 'data' => ['message' => PlatFormCat::orderBy('sort', 'desc')->get()]] );
    }

    
    public function getPlatformByCat(Request $request)
    {
    	$skip = 0; 
    	$take = 20; 
    	//$cat = -1;
        $type = 1; //1新口子 2热门 3推荐
    	if ($request->has('skip')) {
    		$skip = $request->input('skip');
    	}
    	if ($request->has('take')) {
    		$take = $request->input('take');
    	}
    	// if ($request->has('cat')) {
    	// 	$cat = $request->input('cat');
    	// }
        if ($request->has('type')) {
            $type = $request->input('type');
        }
        
        $platForms = $this->platFormRepository->platforms($skip, $take, $type);
    	
    	return response()->json(['status_code' => 0, 'data' => ['message' => $platForms]] );
    }

    public function getPlatformByCatNew(Request $request)
    {
        $platForms = [];
        if ($request->has('cat_id') && !empty($request->input('cat_id'))) {
            $platForms = PlatForm::where('plat_form_cat_id', $request->input('cat_id'))->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->get();
        } else {
            $platForms = PlatForm::orderBy('sort', 'desc')->orderBy('created_at', 'desc')->get();
        }
        return response()->json(['status_code' => 0, 'data' => ['message' => $platForms]] );
    }

    public function getPlatformByFilter(Request $request)
    {
        $skip = 0; 
        $take = 20; 
        $edu = 0;
        $cat = 0; //分类
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        if ($request->has('edu')) {
         $edu = $request->input('edu');
        }
        if ($request->has('cat')) {
            $cat = $request->input('cat');
        }
    
        $platForms = PlatForm::orderBy('sort', 'desc')->orderBy('hot', 'desc')->orderBy('star', 'desc');
        //所有额度
        if ($edu == 0) {
            //$platForms = PlatForm::orderBy('created_at', 'desc');
        }
        //0-5000
        if ($edu == 1) {
            $platForms = $platForms->where(function ($query) {
                $query->whereBetween('edu_min', [0, 5000])->orWhereBetween('edu_max', [0, 5000]);
            });
        }
        // 5000 - 2万
        if ($edu == 2) {
            $platForms = $platForms->where(function ($query) {
                $query->whereBetween('edu_min', [5000, 20000])->orWhereBetween('edu_max', [5000, 20000]);
            });
        }
        //2万 = 5万
        if ($edu == 3) {
            $platForms = $platForms->where(function ($query) {
                $query->whereBetween('edu_min', [20000, 50000])->orWhereBetween('edu_max', [20000, 50000]);
            });
        }
        //5万 = 10万
        if ($edu == 4) {
            $platForms = $platForms->where(function ($query) {
                $query->whereBetween('edu_min', [50000, 100000])->orWhereBetween('edu_max', [50000, 100000]);
            });
        }
        //10万以上
        if ($edu == 5) {
            $platForms = $platForms = $platForms->where('edu_max', '>=', 100000);
        }

        if ($cat) {
         $platForms = $platForms->where('plat_form_cat_id', $cat);
        }

        $platForms = $platForms->skip($skip)->take($take)->get();
        foreach ($platForms as $key => $value) {
            $tmp = [];
            for ($i=0; $i < $value->star; $i++) { 
                array_push($tmp, $i);
            }
            $value['stars'] = $tmp;
        }
        return response()->json(['status_code' => 0, 'data' => ['message' => $platForms]] );
    }

    public function getPlatform($id)
    {
    	$platform = $this->platFormRepository->findWithoutFail($id);
    	if (empty($platform)) {
    		return response()->json(['status_code' => 0, 'data' => ['message' => '平台信息不存在']] );
    	} else {
    		return response()->json(['status_code' => 0, 'data' => ['message' => $platform]] );
    	}
    	
    }

    public function banners()
    {
        $banners = PlatformBanner::all();
        $images = [];
        foreach ($banners as $banner) {
            array_push($images, $banner->image);
        }
        return response()->json(['status_code' => 0, 'data' => ['message' => $images, 'original' => $banners]] );
    }
}
