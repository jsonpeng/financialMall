<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\MiddleLevelInfo;
use App\Models\HighLevelInfo;

use App\Models\Hkj;

class MemberLevelController extends Controller
{

    public function index(Request $request)
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('learn');

        //黑科技分类
        $hkjCats = app('commonRepo')->hkjCatRepo()->CacheAll();

        //黑科技列表
        $cat = null;
        $hkjs = Hkj::orderBy('created_at', 'desc');
        if ($request->has('cat')) {
            $cat = $request->input('cat');
            $hkjs = $hkjs->where('hkj_cat_id', $cat);
        }else{
            if ($hkjCats->count()) {
                $cat = $hkjCats->first()->id;
                $hkjs = $hkjs->where('hkj_cat_id', $cat);
            }
        }
        $hkjs = $hkjs->paginate(15);

        return view('front.mem_level.index', compact('banners', 'hkjCats', 'hkjs', 'cat'));
    }

    public function middleLevel(Request $request)
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('learn');
    	$type = '语音';
    	if ($request->has('type')) {
    		$type = $request->input('type');
    	}

    	$elements = MiddleLevelInfo::where('type', $type)->where('level', '中级会员')->orderBy('created_at', 'desc')->paginate(15);

    	return view('front.mem_level.middle', compact('elements', 'banners', 'type'));
    }

    public function kechengDetail(Request $request, $id)
    {
    	$element = app('commonRepo')->middleLevelInfoRepo()->getById($id);

    	if (empty($element)) {
    		return redirect('/middle_level');
    	}

    	return view('front.mem_level.detail', compact('element'));
    }

    public function highLevel(Request $request)
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('learn');
    	$type = '语音';
    	if ($request->has('type')) {
    		$type = $request->input('type');
    	}

    	$elements = MiddleLevelInfo::where('type', $type)->where('level', '高级会员')->orderBy('created_at', 'desc')->paginate(15);

    	return view('front.mem_level.high', compact('elements', 'banners', 'type'));
    }

    public function superLevel()
    {
        $page = app('commonRepo')->pageRepo()->getBySlug('super_kecheng');
        return view('front.pages.super_kecheng', compact('page'));
    }

    public function allLevel(Request $request)
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('learn');
        $type = '语音';
        if ($request->has('type')) {
            $type = $request->input('type');
        }

        $elements = MiddleLevelInfo::where('type', $type)->orderBy('created_at', 'desc')->paginate(15);

        return view('front.mem_level.all', compact('elements', 'banners', 'type'));
    }
}
