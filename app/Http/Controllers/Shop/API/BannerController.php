<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\BannerRepository;

class BannerController extends Controller
{
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepository = $bannerRepo;
    }

    public function banners($slug)
    {
    	$banner = $this->bannerRepository->getCacheBanner($slug);
    	return  zcjy_callback_data($banner);
    }
}
