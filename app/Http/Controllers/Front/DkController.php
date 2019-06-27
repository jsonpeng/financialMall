<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\BannerRepository;
use App\Repositories\PlatFormRepository;
use App\Repositories\PlatFormCatRepository;

use App\User;
use Flash;
use Carbon\Carbon;
use App\Models\PlatForm;
use App\Models\PlatformBanner;

use Auth;
use Config;
use Log;
use Intervention\Image\ImageManagerStatic as Image;

class DkController extends Controller
{
    private $bannerRepository;
    private $platFormCatRepository;
    private $platFormRepository;

    public function __construct(
        BannerRepository $bannerRepo,
        PlatFormRepository $platFormRepo,
        PlatFormCatRepository $platFormCatRepo
    )
    {
        $this->bannerRepository = $bannerRepo;
        $this->platFormCatRepository = $platFormCatRepo;
        $this->platFormRepository = $platFormRepo;
    }

    public function index(Request $request)
    {

        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('dk');
        $postCats = $this->platFormCatRepository->all();
        $dks = null;
        $type = null;
        if ($request->has('type')) {
            $type = $request->input('type');
            if ($type == 'hot') {
                $dks = PlatForm::orderBy('created_at', 'desc');
                $dks = $dks->where('hot', 1);
            }
            if ($type == 'recommend') {
                $dks = PlatForm::orderBy('star', 'desc')->orderBy('created_at', 'desc');
            }
        }else{
            $dks = PlatForm::orderBy('created_at', 'desc');
        }

        $dks = $dks->paginate(15);
        //当前微信用户
        $user = auth('web')->user();
        
        return view('front.dk.index', compact('banners', 'postCats', 'dks', 'user', 'type'));
    }

    public function cat(Request $request, $id=0)
    {
        if (empty($id)) {
            return redirect('/dk');
        }

        $banners = $this->bannerRepository->all();
        $postCats = $this->platFormCatRepository->all();

         //当前微信用户
        $user = auth('web')->user();

        $dks = PlatForm::orderBy('created_at', 'desc')->where('plat_form_id', $id)->paginate(15);
        return view('front.dk.index', compact('banners', 'postCats', 'dks', 'user'));
    }

    public function detail(Request $request, $id)
    {
        $platForm = $this->platFormRepository->findWithoutFail($id);

        if (empty($platForm)) {
            return redirect('/dk');
        }

        $platForm->update(['view' => $platForm->view + 1]);

        return view('front.dk.detail')->with('platForm', $platForm);
    }

    public function list(Request $request, $range, $type)
    {
        $dks = PlatForm::orderBy('created_at', 'desc');
        $range_name = '全部额度';
        $type_name = '全部类型';
        //过滤
        switch ($range) {
            case 0:
                # 全部
                break;
            case 1:
                # 0-5000
                $dks = $dks->where(function ($query) {
                    $query->whereBetween('edu_min', [0, 5000])->orWhereBetween('edu_max', [0, 5000]);
                });
                $range_name = '0-5000';
                break;
            case 2:
                # 5000-20000
                $dks = $dks->where(function ($query) {
                    $query->whereBetween('edu_min', [5000, 20000])->orWhereBetween('edu_max', [5000, 20000]);
                });
                $range_name = '5000-2万';
                break;
            case 3:
                # 20000-50000
                $dks = $dks->where(function ($query) {
                    $query->whereBetween('edu_min', [20000, 50000])->orWhereBetween('edu_max', [20000, 50000]);
                });
                $range_name = '2万-5万';
                break;
            case 4:
                # 50000-100000
                $dks = $dks->where(function ($query) {
                    $query->whereBetween('edu_min', [50000, 100000])->orWhereBetween('edu_max', [50000, 100000]);
                });
                $range_name = '5万-10万';
                break;
            case 5:
                # 100000-10000000
                $dks = $dks->where(function ($query) {
                    $query->whereBetween('edu_min', [100000, 10000000])->orWhereBetween('edu_max', [100000, 10000000]);
                });
                $range_name = '10万以上';
                break;
        }
        if ($type) {
            $dks = $dks->where('plat_form_cat_id', $type);

            $platFormCat = $this->platFormCatRepository->findWithoutFail($type);

            if (!empty($platFormCat)) {
                $type_name = $platFormCat->name;
            }
        }
        $cats = $this->platFormCatRepository->all();
        $dks = $dks->paginate(15);
        return view('front.dk.list', compact('dks', 'range', 'type', 'cats', 'range_name', 'type_name'));
    }
}
