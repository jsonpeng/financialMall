<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use Flash;
use Carbon\Carbon;
use App\Models\Hkj;
use Auth;
use App\Models\PostCategory;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;

class HkjController extends Controller
{
    public function __construct()
    {
        //$this->middleware('member', ['only' => ['hkjDetail']]);
    }

    public function index(Request $request)
    {
        //黑科技横幅
        $hkj_banners = app('commonRepo')->bannerRepo()->getCacheBanner('index');
        
        //黑科技分类
        $hkjCats = app('commonRepo')->hkjCatRepo()->CacheAll();

        //文章分类
        //$postCats = app('commonRepo')->catRepo()->CacheAll();

        //通知消息
        //$notices = app('commonRepo')->noticeRepo()->CacheAll();
        //$notice_pop = app('commonRepo')->noticeRepo()->PopNotice();

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

        // $needPopUp = true;
        // if ($request->session()->has('popup_notice')) {
        //     $needPopUp = false;
        // } else {
        //     $request->session()->put('popup_notice', 'yes');
        // }

        return view('front.hkj.index', compact('hkj_banners', 'hkjs', 'hkjCats', 'cat'))->withInput($request->all());

        // $hkj_banners = $this->hkjBannerRepository->all();
        // $hkjCats = $this->hkjCatRepository->all();
        // $postCats = PostCategory::orderBy('sort', 'desc')->get();
        // $notices = $this->noticeRepository->all();
        // $hkjs = Hkj::orderBy('created_at', 'desc');
        // $cat = $request->input('cat');
        // if ($request->has('cat')) {
        //     $hkjs = $hkjs->where('hkj_cat_id', $request->input('cat'));
        // }
        // $hkjs = $hkjs->paginate(15);
        // return view('front.hkj.index', compact('hkj_banners', 'postCats', 'notices', 'hkjs', 'hkjCats', 'cat'));
    }

    public function cat(Request $request, $id=0)
    {
        if (empty($id)) {
            return redirect('/hkj');
        }

        $hkj_banners = app('commonRepo')->bannerRepo()->getCacheBanner('index');
        $postCats = app('commonRepo')->hkjCatRepo()->CacheAll();
        $notices = app('commonRepo')->noticeRepo()->CacheAll();

        $hkjs = Hkj::orderBy('created_at', 'desc')->where('hkj_cat_id', $id)->paginate(15);
        return view('front.hkj.index', compact('hkj_banners', 'postCats', 'notices', 'hkjs'));
    }

    public function detail(Request $request, $id)
    {
        $hkj = app('commonRepo')->hkjRepo()->findWithoutFail($id);

        if (empty($hkj)) {
            return redirect('/hkj');
        }

        $hkj->update(['view' => $hkj->view + 1]);
        //当前微信用户
        $user = auth('web')->user();

        return view('front.hkj.detail', compact('hkj', 'user'));
    }
}
