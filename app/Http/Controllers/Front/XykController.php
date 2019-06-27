<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Flash;
use Carbon\Carbon;
use App\Models\PlatForm;

use App\Repositories\BannerRepository;
use App\Repositories\CreditCardBankRepository;
use App\Repositories\CreditCardThemeRepository;
use App\Repositories\CreditCardRepository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use App\Models\CreditCard;
use App\Models\CreditCardBanner;

class XykController extends Controller
{

    private $bannerRepository;
    private $creditCardRepository;
    private $creditCardThemeRepository;
    private $creditCardBankRepository;

    public function __construct(
        BannerRepository $bannerRepo,
        CreditCardRepository $creditCardRepo,
        CreditCardThemeRepository $creditCardThemeRepo,
        CreditCardBankRepository $creditCardBankRepo
    )
    {
        $this->bannerRepository = $bannerRepo;
        $this->creditCardThemeRepository = $creditCardThemeRepo;
        $this->creditCardBankRepository = $creditCardBankRepo;
        $this->creditCardRepository = $creditCardRepo;
    }

    public function index()
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('dk');
        $banks = $this->creditCardBankRepository->all();
        $themes = $this->creditCardThemeRepository->all();
        $cards = CreditCard::orderBy('created_at', 'desc')->paginate(15);
        return view('front.xyk.index', compact('cards','banners','banks','themes'));
    }  

    public function bank(Request $request, $id){
        $creditCardBank = $this->creditCardBankRepository->findWithoutFail($id);
        $banks = $this->creditCardBankRepository->all();

        if (empty($creditCardBank)) {
            return redirect('/xyk');
        }

        $cards = CreditCard::where('credit_card_bank_id', $id)->orderBy('created_at', 'desc')->paginate(15);
        return view('front.xyk.bank', compact('cards','banks','creditCardBank'));
    }

    public function theme(Request $request, $id){
        $creditCardTheme = $this->creditCardThemeRepository->findWithoutFail($id);
        $themes = $this->creditCardThemeRepository->all();

        if (empty($creditCardTheme)) {
            return redirect('/xyk');
        }

        $cards = CreditCard::where('credit_card_theme_id', $id)->orderBy('created_at', 'desc')->paginate(15);
        return view('front.xyk.theme', compact('cards','themes','creditCardTheme'));
    }
}