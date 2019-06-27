<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\BannerRepository;
use App\Repositories\CreditCardBankRepository;
use App\Repositories\CreditCardThemeRepository;
use App\Repositories\CreditCardRepository;
use App\Repositories\XykNewRepository;

use App\Models\CreditCardBanner;
use App\Models\CreditCard;
use App\Models\SubmitInfoLog;

class XykController extends Controller
{
    private $bannerRepository;
    private $creditCardRepository;
    private $creditCardThemeRepository;
    private $creditCardBankRepository;
    private $xykNewRepository;

    public function __construct(
        BannerRepository $bannerRepo,
        CreditCardRepository $creditCardRepo,
        CreditCardThemeRepository $creditCardThemeRepo,
        CreditCardBankRepository $creditCardBankRepo,
        XykNewRepository $xykNew
    )
    {
        $this->bannerRepository = $bannerRepo;
        $this->creditCardThemeRepository = $creditCardThemeRepo;
        $this->creditCardBankRepository = $creditCardBankRepo;
        $this->creditCardRepository = $creditCardRepo;
        $this->xykNewRepository = $xykNew;
    }

    public function xykBanners()
    {
    	$banners = CreditCardBanner::orderBy('sort', 'desc')->get();
    	$images = [];
        foreach ($banners as $banner) {
            array_push($images, $banner->image);
        }
    	return response()->json(['status_code' => 0, 'data' => ['message' => $images, 'original' => $banners]] );
    }

    public function xykBanks()
    {
    	$banks = $this->creditCardBankRepository->all();
    	return response()->json(['status_code' => 0, 'data' => ['message' => $banks]] );
    }

    public function xykThemes()
    {
    	$themes = $this->creditCardThemeRepository->all();
    	return response()->json(['status_code' => 0, 'data' => ['message' => $themes]] );
    }

    public function creditCards(Request $request)
    {
    	$inputs = $request->all();
    	$bank = -1;
    	if (array_key_exists('bank', $inputs)) {
    		$bank = $inputs['bank'];
    	}
    	$theme = -1;
    	if (array_key_exists('theme', $inputs)) {
    		$theme = $inputs['theme'];
    	}
    	$skip = 0;
    	if (array_key_exists('skip', $inputs)) {
    		$skip = $inputs['skip'];
    	}
    	$take = 20;
    	if (array_key_exists('take', $inputs)) {
    		$take = $inputs['take'];
    	}
    	$cards = CreditCard::orderBy('hot', 'desc')->orderBy('created_at', 'desc');
    	if ($bank != -1) {
    		$cards = $cards->where('credit_card_bank_id', $bank);
    	}
    	if ($theme != -1) {
    		$cards = $cards->where('credit_card_theme_id', $theme);
    	}
    	$cards = $cards->skip($skip)->take($take)->get();
    	return response()->json(['status_code' => 0, 'data' => ['message' => $cards]] );
    }

    public function newCards(Request $request)
    {
        return response()->json(['status_code' => 0, 'data' => ['message' => $this->xykNewRepository->sortedAll()]] );
    }

    //提交申请信息
    public function submitInfo(Request $request){
        $input = $request->all();
        $varify = app('commonRepo')->varifyInputParam($input, SubmitInfoLog::$rule);
        if($varify){
            return zcjy_callback_data($varify, 1);
        }
        SubmitInfoLog::create($input);
        return zcjy_callback_data('提交成功');
    }
}



        
        