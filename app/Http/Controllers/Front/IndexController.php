<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\OldProduct;
use App\Models\Hkj;
use Flash;
use Carbon\Carbon;
use App\Models\UserLevel;
use App\Models\SubmitForm;
use App\Models\SysSetting;
use App\Models\CashIncome;
use App\Models\CashWithdraw;
use App\Models\OldOrder;
use DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;

use App\Repositories\BannerRepository;
use App\Repositories\OldProductRepository as CategoryRepository;
use App\Repositories\NoticeRepository;

use App\Models\Tool;

class IndexController extends Controller
{
    private $bannerRepository;
    private $categoryRepository;
    private $noticeRepository;

    public function __construct(
        BannerRepository $bannerRepo,
        CategoryRepository $categoryRepo,
        NoticeRepository $noticeRepo
    )
    {
        $this->bannerRepository = $bannerRepo;
        $this->categoryRepository = $categoryRepo;
        $this->noticeRepository = $noticeRepo;
    }

    public function index(Request $request)
    {
        //黑科技横幅
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('index');
        
        //黑科技分类
        $hkjCats = app('commonRepo')->hkjCatRepo()->CacheAll();

        //文章分类
        $postCats = app('commonRepo')->catRepo()->CacheAll();

        //通知消息
        $notices = app('commonRepo')->noticeRepo()->CacheAll();
        $notice_pop = app('commonRepo')->noticeRepo()->PopNotice();

        $setting = SysSetting::first();

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

        $needPopUp = true;
        if ($request->session()->has('popup_notice')) {
            $needPopUp = false;
        } else {
            $request->session()->put('popup_notice', 'yes');
        }

        return view('front.index', compact('banners', 'postCats', 'notices', 'hkjs', 'hkjCats', 'cat', 'notice_pop', 'needPopUp', 'setting'))->withInput($request->all());
    }

    public function tools()
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('tool');
        return view('front.tools.index', compact('banners'));
    }

    public function toolsJinrong()
    {
        $tools  = app('commonRepo')->toolRepo()->CacheAll();
        return view('front.tools.jinrong', compact('tools'));
    }

    public function jump()
    {
        return view('front.jump');
    }

    public function member(){

        $product = OldProduct::first();

        //当前微信用户
        $user = auth('web')->user();

        //当会员卡信息
        $userLevels = UserLevel::orderBy('money', 'asc')->get();

        //绑定手机号
        // if (empty($user->mobile)) {
        //     return redirect('mobile');
        // }
        // if ($user->member == 1 && Carbon::now()->lt(Carbon::parse($user->member_end_time))) {
        //     return redirect('/hkj');
        // }

        $product->update(['sales' => $product->sales + 1]);

        $open_weixin_pay = false;
        if (Config::get('zcjy.OPEN_PAYSAPI_WEIXIN')) {
            $open_weixin_pay = true;
        }

        $open_ali_pay = false;
        if (Config::get('zcjy.OPEN_PAYSAPI_ALIPAY')) {
            $open_ali_pay = true;
        }

        $open_ali_pay_mobile = false;
        if (Config::get('zcjy.OPEN_PAYSAPI_ALIPAY_MOBILE')) {
            $open_ali_pay_mobile = true;
        }

        return view('front.member', compact('product', 'user', 'userLevels', 'open_ali_pay', 'open_ali_pay_mobile', 'open_weixin_pay'));                       
    }

    public function memberBuyV2()
    {
        //当前微信用户
        $user = auth('web')->user();

        $wechat_user = session('wechat.oauth_user'); // 拿到授权用户资料

        if (empty($user->openid) && !empty($wechat_user)) {

            $user->update([
                'openid' => $wechat_user['default']['original']['openid'],
                'header' => $wechat_user['default']['original']['headimgurl']
            ]);
        }

        //当会员卡信息
        $userLevels = UserLevel::orderBy('money', 'asc')->get();

        $open_wechat_pay = false;
        if (Config::get('zcjy.OPEN_WECHAT_PAY')) {
            $open_wechat_pay = true;
        }

        $open_weixin_pay = false;
        if (Config::get('zcjy.OPEN_PAYSAPI_WEIXIN')) {
            $open_weixin_pay = true;
        }

        $open_ali_pay = false;
        if (Config::get('zcjy.OPEN_PAYSAPI_ALIPAY')) {
            $open_ali_pay = true;
        }

        $open_ali_pay_mobile = false;
        if (Config::get('zcjy.OPEN_PAYSAPI_ALIPAY_MOBILE')) {
            $open_ali_pay_mobile = true;
        }

        return view('front.mem_buy.index', compact('user', 'userLevels', 'open_ali_pay', 'open_ali_pay_mobile', 'open_weixin_pay', 'open_wechat_pay'));
    }

    public function mem_intro()
    {
        return view('front.user.mem_intro');
    }

    public function members_justnow()
    {
        //当前微信用户
        $user = auth('web')->user();

        $users = User::where('id', '<>' ,$user->id)->orderBy('created_at', 'desc')->take(10)->get()->toArray();
        return ['code' => 0, 'message' => $users];
    }

    public function yue()
    {
        return view('front.user.yue');
    }

    public function pay_success()
    {
        return view('front.pay_success');
    }

    public function law()
    {
        return view('front.law');
    }


    /**
     * 我要贷款表单提交
     */
    
    public function showDkForm(Request $request)
    {
        return view('front.apply.dk');
    }
    /**
     * 用户提交表单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxSubmitInfo(Request $request)
    {
        if (!$request->has('mobile')) {
            return ['code' => 1, 'message' => '请填写手机号'];
        }
        if (!$request->has('type')) {
            return ['code' => 1, 'message' => '请填写类型'];
        }
        try {
            $count = SubmitForm::where('mobile', $request->input('mobile'))->whereDate('created_at', Carbon::today())->count();

            if ($count) {
                return ['code' => 1, 'message' => '对不起您今天已经提交过数据了'];
            }

            SubmitForm::create($request->all());
            return ['code' => 0, 'message' => '成功'];
        } catch (Exception $e) {
            return ['code' => 1, 'message' => '失败'];
        }
    }

    public function live()
    {
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner('live');
        $lives = app('commonRepo')->liveRepo()->allCached();
        return view('front.live.index', compact('banners', 'lives'));
    }

    public function liveDetail(Request $request, $id)
    {
        $live = app('commonRepo')->liveRepo()->getById($id);
        return view('front.live.detail', compact('live'));
    }

    public function stats(Request $request)
    {
        //当日 当月 上月 全部
        $type = 1;
        if ($request->has('type')) {
            $type = $request->input('type');
        }
        $month_money = CashIncome::select('user_id', DB::raw('SUM(count) as total_sales'));
        $month_order = CashIncome::select('user_id', DB::raw('count(*) as total_orders'));

        $money_withdraw = 0;
        $money_ticheng = 0;
        $money_user = User::sum('money');
        $money_pedding = CashWithdraw::where('status', '待审核')->sum('count');

        $level_chu = OldOrder::where('pay_status', '已支付')->where('money', 388);
        $level_zhong = OldOrder::where('pay_status', '已支付')->where('money', 588);
        $level_gao = OldOrder::where('pay_status', '已支付')->where('money', 888);

        switch ($type) {
            case 1:
                $month_money = $month_money->whereDate('created_at', Carbon::today());
                $month_order = $month_order->whereDate('created_at', Carbon::today());

                $money_ticheng = CashIncome::whereDate('created_at', Carbon::today())->sum('count');
                $money_withdraw = CashWithdraw::whereDate('created_at', Carbon::today())->where('status', '审核通过')->sum('count');

                $level_chu = $level_chu->whereDate('created_at', Carbon::today());
                $level_zhong = $level_zhong->whereDate('created_at', Carbon::today());
                $level_gao = $level_gao->whereDate('created_at', Carbon::today());

                break;
            case 2:
                $month_money = $month_money->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month);
                $month_order = $month_order->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month);
                $money_ticheng = CashIncome::whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month)->sum('count');
                $money_withdraw = CashWithdraw::whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month)->where('status', '审核通过')->sum('count');

                $level_chu = $level_chu->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month);
                $level_zhong = $level_zhong->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month);
                $level_gao = $level_gao->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month);

                break;
            case 3:
                $month_money = $month_money->whereYear('created_at', Carbon::today()->subMonth()->year)->whereMonth('created_at', Carbon::today()->subMonth()->month);
                $month_order = $month_order->whereYear('created_at', Carbon::today()->subMonth()->year)->whereMonth('created_at', Carbon::today()->subMonth()->month);

                $money_ticheng = CashIncome::whereYear('created_at', Carbon::today()->subMonth()->year)->whereMonth('created_at', Carbon::today()->subMonth()->month)->sum('count');
                $money_withdraw = CashWithdraw::whereYear('created_at', Carbon::today()->subMonth()->year)->whereMonth('created_at', Carbon::today()->subMonth()->month)->where('status', '审核通过')->sum('count');

                $level_chu = $level_chu->whereYear('created_at', Carbon::today()->subMonth()->year)->whereMonth('created_at', Carbon::today()->subMonth()->month);
                $level_zhong = $level_zhong->whereYear('created_at', Carbon::today()->subMonth()->year)->whereMonth('created_at', Carbon::today()->subMonth()->month);
                $level_gao = $level_gao->whereYear('created_at', Carbon::today()->subMonth()->year)->whereMonth('created_at', Carbon::today()->subMonth()->month);

                break;
            case 4:
                $money_ticheng = CashIncome::sum('count');
                $money_withdraw = CashWithdraw::where('status', '审核通过')->sum('count');
                break;
            
            default:
                $month_money = $month_money->whereDate('created_at', Carbon::today());
                $month_order = $month_order->whereDate('created_at', Carbon::today());

                $money_ticheng = CashIncome::whereDate('created_at', Carbon::today())->sum('count');
                $money_withdraw = CashWithdraw::whereDate('created_at', Carbon::today())->where('status', '审核通过')->sum('count');

                $level_chu = $level_chu->whereDate('created_at', Carbon::today());
                $level_zhong = $level_zhong->whereDate('created_at', Carbon::today());
                $level_gao = $level_gao->whereDate('created_at', Carbon::today());

                break;
        }
        //本月提成统计
        $month_money = $month_money->groupBy('user_id')->orderBy('total_sales', 'desc')->get();

        foreach ($month_money as $key => $value) {
            $user = User::where('id', $value->user_id)->first();
            $value['name'] = $user->name.'('.substr($user->mobile,-4).')';
        }

        //订单数
        $month_order = $month_order->groupBy('user_id')->where('type', '推广收入')->where('des', 'like', '%1级%')->orderBy('total_orders', 'desc')->get();
        foreach ($month_order as $key => $value) {
            switch ($type) {
                case 1:
                    $value['register'] = User::where('leader1', $value->user_id)->whereDate('created_at', Carbon::today())->count();
                    break;
                case 2:
                    $value['register'] = User::where('leader1', $value->user_id)->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month)->count();
                    break;
                case 3:
                    $value['register'] = User::where('leader1', $value->user_id)->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month - 1)->count();
                    break;
                case 4:
                    $value['register'] = User::where('leader1', $value->user_id)->count();
                    break;
                
                default:
                    $value['register'] = User::where('leader1', $value->user_id)->whereDate('created_at', Carbon::today())->count();
                    break;
            }
        }
        foreach ($month_order as $key => $value) {
            $user = User::where('id', $value->user_id)->first();
            $value['name'] = $user->name.'('.substr($user->mobile,-4).')';
        }

        //提成表
        $name01 = [];
        $money01 = [];
        //销售额
        $money03 = [];

        foreach ($month_money as $key => $value) {
            array_push($name01, $value->name);
            array_push($money01, $value->total_sales);
            
        }
        $name01 = array_reverse($name01);
        $money01 = array_reverse($money01);
        
        $name01 = implode(',', $name01);
        $money01 = implode(',', $money01);
        

        //订单&推荐
        $name02 = [];
        $order02 = [];
        $register02 = [];

        foreach ($month_order as $key => $value) {
            array_push($name02, $value->name);
            array_push($order02, $value->total_orders);
            array_push($register02, $value->register);
            //销售额
            array_push($money03, $this->saleMoney($value->user_id, $type));
        }

        $name02 = array_reverse($name02);
        $order02 = array_reverse($order02);
        $register02 = array_reverse($register02);

        $name02 = implode(',', $name02);
        $order02 = implode(',', $order02);
        $register02 = implode(',', $register02);

        $money03 = array_reverse($money03);
        $money03 = implode(',', $money03);


        $level_chu = $level_chu->count();
        $level_zhong = $level_zhong->count();
        $level_gao = $level_gao->count();

        return view('front.stats', compact('name01', 'money01', 'name02', 'order02', 'register02', 'type', 'money03', 'money_ticheng', 'money_withdraw', 'money_user', 'money_pedding', 'level_chu', 'level_zhong', 'level_gao'));
    }


    private function saleMoney($user_id, $type)
    {
        $result = OldOrder::select(DB::raw('sum(money) as total_money'))->where('pay_status', '已支付')->whereIn('user_id', $this->childIds($user_id));
        switch ($type) {
            case 1:
                $result = $result->whereDate('created_at', Carbon::today());

                break;
            case 2:
                $result = $result->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month);
                break;
            case 3:
                $result = $result->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at', Carbon::today()->month - 1);
                break;
            case 4:
                break;
            
            default:
                $result = $result->whereDate('created_at', Carbon::today());
                break;
        }
        $result = $result->get();
        if (empty($result)) {
            return 0;
        }else{
             return $result[0]->total_money;
        }
    }

    private function childIds($parent_id)
    {
        $users = User::where('leader1', $parent_id)->select('id')->get();
        $ids = [];
        foreach ($users as $key => $value) {
            array_push($ids, $value->id);
        }
        return $ids;
    }
}