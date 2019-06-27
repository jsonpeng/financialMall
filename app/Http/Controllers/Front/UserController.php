<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Flash;
use Carbon\Carbon;
//use App\Models\BankCard;
use App\Models\MoneyRecord;

use App\Models\Advertorial;
use App\Models\CashWithdraw;
use App\Models\CashIncome;
use App\Models\SysSetting;
use App\Models\JifenRecord;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;

//use App\Repositories\BankCardRepository;
use App\Repositories\MoneyRecordRepository;
use App\Repositories\HkjBannerRepository;

use EasyWeChat\Factory;

use QrCode;

class UserController extends Controller
{
    //private $bankCardRepository;
    private $moneyRecordRepository;
    

    public function __construct(
        //BankCardRepository $bankCardRepo,
        MoneyRecordRepository $moneyRecordRepo,
        HkjBannerRepository $hkjBannerRepo
    )
    {
        //$this->bankCardRepository = $bankCardRepo;
        $this->moneyRecordRepository = $moneyRecordRepo;
        $this->hkjBannerRepository = $hkjBannerRepo;
    }

    public function userCenter(Request $request)
    {

        $user = auth('web')->user();
        //检查会员是否有推荐码
        if ($user->member && empty($user->share_code)) {
            $user->share_code = app('commonRepo')->randomCode();
            $user->save();
        }
        $withdraw_pendding = round(CashWithdraw::where('user_id', $user->id)->where('status', '待审核')->sum('count'), 2);
        $withdraw_done = round(CashWithdraw::where('user_id', $user->id)->where('status', '审核通过')->sum('count'), 2);

        return view('front.user.user_center', compact('user', 'withdraw_pendding', 'withdraw_done'));

        // $user = auth('web')->user();

        // $daili_count = User::where('parent_id', $user->id)->count();
        // $tuijianren = '';
        // if ($user->parent_id != 0) {
        //     $parent_user = User::find($user->parent_id);
        //     if (!is_null($parent_user)) {
        //         $tuijianren = $parent_user->nickname;
        //     }
        // }
        // return view('front.user.user_center')
        //     ->with('user', $user)
        //     ->with('tuijianren', $tuijianren)
        //     ->with('daili_count', $daili_count);
    }

    public function userInfo(Request $request)
    {
        $user = auth('web')->user();
        return view('front.user.user_info')
            ->with('user', $user);
    }

    public function wallet(Request $request)
    {
        $user = auth('web')->user();
        //待审核金额
        $withdraw_pendding = round(CashWithdraw::where('status', '待审核')->where('user_id', $user->id)->sum('count'), 2);
        $withdraw_done = round(CashWithdraw::where('status', '审核通过')->where('user_id', $user->id)->sum('count'), 2);
        $cashList = CashWithdraw::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(15);
        //已提金额
        return view('front.user.wallet', compact('user', 'withdraw_pendding', 'withdraw_done', 'cashList'));
    }

    public function income(Request $request)
    {
        $user = auth('web')->user();
        $incomes = CashIncome::where('user_id', $user->id);
        $input = $request->all();
        $type = 2;
        if (array_key_exists('type', $input) && $input['type'] == 1) {
             $type = 1;
            # 贷款收入
            $incomes = $incomes->where('type', '贷款收入');
        } else {
            # 推广收入
            $incomes = $incomes->where('type', '推广收入');
        }

        $incomes = $incomes->orderBy('created_at', 'desc')->paginate(15);

        $withdraw_pendding = round(CashWithdraw::where('status', '待审核')->where('user_id', $user->id)->sum('count'), 2);
        $withdraw_done = round(CashWithdraw::where('status', '审核通过')->where('user_id', $user->id)->sum('count'), 2);

        return view('front.user.income', compact('user', 'withdraw_pendding', 'withdraw_done', 'incomes', 'type'))->withInput($input);
    }

    public function face2face(Request $request)
    {
        $user = auth('web')->user();
        return view('front.user.face2face')
            ->with('user', $user);
    }

    public function advertorial(Request $request)
    {
        $advertorial = Advertorial::first();
        return view('front.user.advertorial')
            ->with('advertorial', $advertorial);
    }

    public function cashWithdraw(Request $request)
    {
        $user = auth('web')->user();
        return view('front.user.cash_withdraw')
            ->with('user', $user);
    }

    public function postWithdraw(Request $request)
    {
        $input = $request->all();
        if (!array_key_exists('count', $input) || empty($input['count'])) {
            return ['code' => 1, 'message' => '请填写提取金额'];
        }
        if (!array_key_exists('name', $input) || empty($input['name'])) {
            return ['code' => 1, 'message' => '请填写姓名'];
        }
        if (!array_key_exists('zhifubao', $input) || empty($input['zhifubao'])) {
            return ['code' => 1, 'message' => '请填写支付宝账号'];
        }

        $setting = SysSetting::first();

        $user = auth('web')->user();

        if ($user->money < $input['count']) {
            return ['code' => 1, 'message' => '账户余额不足'];
        }

        if ($setting->min_cash && $setting->min_cash > $input['count']) {
            return ['code' => 1, 'message' => '最低提取金额为'.$setting->min_cash.'元'];
        }
        if ($setting->max_cash_withdraw && $setting->max_cash_withdraw <= CashWithdraw::where('user_id')->where('created_at', '>=', Carbon::today()->subDays(30))->count() ) {
            return ['code' => 1, 'message' => '一个月内最多提取'.$setting->max_cash_withdraw.'次'];
        }

        $input['status'] = '待审核';
        $input['user_id'] = $user->id;
        CashWithdraw::create($input);

        $user->update(['money' => $user->money - $input['count']]);

        return ['code' => 0, 'message' => '提交成功'];

    }

    public function share(Request $request)
    {
        $user = auth('web')->user();
        return view('front.user.share', compact('user'));
    }


    public function erweima(Request $request)
    {

        // $user = auth('web')->user();
        // //会员才有二维码
        // if ($user->member == 0) {
        //     return redirect('/mem_intro');
        // }

        // $shareLink = $request->root().'?invitor='.$user->id;
        // //生成二维码图片
        // $picPath = public_path().'/qrcodes/'.$user->id.'.png';
        // QrCode::format('png')->size(300)->generate($shareLink, $picPath);
        // return view('front.user.erweima')->with('url', 'qrcodes/'.$user->id.'.png');  
        $user = auth('web')->user();
        //$shareLink = $request->root().'?invitor='.$user->share_code;
        $shareLink = $request->root().'/invite_register/?invitor='.$user->share_code;
        //生成二维码图片
        $picPath = public_path().'/qrcodes/'.$user->id.'.png';
        QrCode::format('png')->size(300)->generate($shareLink, $picPath);

        $setting = SysSetting::first();
        //打开底图
        $img = null;
        if (empty($setting->base_share_img)) {
            $img = Image::make(public_path().'/images/share_base.jpg');
        } else {
            $img = Image::make($setting->base_share_img);
        }
        $img->text($user->nickname.'向您推荐了'.$setting->name, 230, 630, function($font) {
            $font->file(public_path().'/font/XinH_CuJW.TTF');
            $font->size(24);
            $font->color('#000');
        });
        //插入二维码
        $qcode = Image::make($picPath)->resize(221, 221);
        $img->insert($qcode, 'top-left', 230, 654);

        $img->save(public_path().'/qrcodes/user_share'.$user->id.'.jpg', 80);
        
        return view('front.user.erweima')->with('url', 'qrcodes/user_share'.$user->id.'.jpg');      
    }

    public function user_memebers(Request $request)
    {
        // $members = User::where('parent_id', $id)->orderBy('created_at', 'desc')->paginate(20);
        // return view('front.user.members')
        //     ->with('members', $members);
        $level = 1;
        if ($request->has('level')) {
            $level = $request->input('level');
        }
        $members = null;
        $user = auth('web')->user();
        if ($level == 1) {
            $members = User::where('leader1', $user->id)->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $members = User::where('leader2', $user->id)->orderBy('created_at', 'desc')->paginate(20);
        }
        
        return view('front.user.members')
            ->with('members', $members)->with('level', $level)->withInput($request->all());
    }

    public function xykJifenRecords(Request $request)
    {
        $user = auth('web')->user();
        $records = JifenRecord::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('front.user.jifen')
            ->with('records', $records);
    }

    // public function bankcard(Request $request)
    // {
        
    //     $user = auth('web')->user();

    //     $bankcards = $user->bankcards;
    //     return view('front.user.bankcard.index')
    //         ->with('user', $user)
            
    //         ->with('bankcards', $bankcards);
    // }

    // public function bankcard_add(Request $request)
    // {
    //     $user = auth('web')->user();

    //     return view('front.user.bankcard.add')
    //         ->with('user', $user);
    // }

    // public function bankcard_store(Request $request)
    // {

    //     $input = $request->all();

    //     $this->validate($request, BankCard::$rules);


    //     $bankCard = $this->bankCardRepository->create($input);

    //     Flash::success('银行卡创建成功');

    //     return redirect('/bankcard');
    // }

    // public function bankcard_edit(Request $request, $id)
    // {
        
    //     $user = auth('web')->user();

    //     $bankCard = $this->bankCardRepository->findWithoutFail($id);

    //     if (empty($bankCard)) {
    //         Flash::error('银行卡不存在');

    //         return redirect('/bankcard');
    //     }

    //     return view('front.user.bankcard.edit')
    //         ->with('user', $user)
            
    //         ->with('bankCard', $bankCard);
    // }

    // public function bankcard_delete(Request $request, $id)
    // {
    //     $bankCard = $this->bankCardRepository->findWithoutFail($id);

    //     if (empty($bankCard)) {
    //         //Flash::error('银行卡不存在');

    //         return redirect('/bankcard');
    //     }

    //     $this->bankCardRepository->delete($id);

    //     //Flash::success('银行卡删除成功');

    //     return ['code' => 0, 'message' => '删除成功'];
    // }

    // public function bankcard_update(Request $request, $id)
    // {

    //     $this->validate($request, BankCard::$rules);

    //     $bankCard = $this->bankCardRepository->findWithoutFail($id);

    //     if (empty($bankCard)) {

    //         return redirect('/bankcard');
    //     }

    //     $bankCard = $this->bankCardRepository->update($request->all(), $id);

    //     Flash::success('银行卡信息更新成功');

    //     return redirect('/bankcard');
        
    // }

    // public function tixian_shenqing(Request $request)
    // {
    //     $user = auth('web')->user();
    //     //会员才有二维码
    //     if ($user->member == 0) {
    //         return view('front.user.erweima_tishi');
    //     }

    //     $bankcards = $user->bankcards;
    //     if (!$bankcards->count()) {
    //         return redirect('/bankcard/add');
    //     }

    //     return view('front.user.tixian.shenqing')
    //         ->with('user', $user)
    //         ->with('bankcards', $bankcards);
    // }

    // public function tixian_shenqing_post(Request $request)
    // {
    //     $this->validate($request, MoneyRecord::$rules);

    //     $input = $request->all();

    //     //银行卡是否存在
    //     $bankCard = $this->bankCardRepository->findWithoutFail($input['card_id']);

    //     if (empty($bankCard)) {

    //         Flash::error('银行卡不存在');
    //         return redirect('/tixian/shenqing');
    //     }

    //     $user = auth('web')->user();

    //     if ($input['money'] < 200 || $input['money'] > $user->money) {

    //         Flash::error('金额输入不正确(提现金额须在200到个人金额之间)');
    //         return redirect('/tixian/shenqing');
    //     }
    //     //生成提现记录
    //     $money_record = MoneyRecord::create([
    //         'money' => $input['money'],
    //         'status' => '处理中',
    //         'type' => '提现',
    //         'name' => $bankCard->name,
    //         'bank_name' => $bankCard->bank_name,
    //         'user_name' => $bankCard->user_name,
    //         'mobile' => $bankCard->mobile,
    //         'count' => $bankCard->count,
    //         'user_id' => $user->id,
    //         'pay_no' => time()
    //     ]);

    //     $user->update(['money' => $user->money - $input['money']]);
    //     Flash::success('提交成功，处理中');
    //     return redirect('/tixian');
    //     /*
    //     //向系统发送提现申请
    //     $res = $this->thirdPartyTixian($request->root(), $money_record);
    //     if ($res->result == 'success') {
    //         //扣钱
    //         $user->update(['money' => $user->money - $input['money']]);
    //         Flash::success('提交成功，处理中');
    //         return redirect('/tixian');
    //     } else {
    //         Flash::error($res->msg);
    //         return redirect('/tixian/shenqing');
    //     }  
    //     */      
    // }


    // public function tixian_notify_3rd(Request $request)
    // {
    //     $inputs  = $request->all();

    //     $money_record = MoneyRecord::where('pay_no', $inputs['businessnumber'])->first();
    //     if (is_null($money_record)) {
    //     } else {
    //         $money_record->update(['status'=>$inputs['status'], 'info'=>$inputs['remark']]);
    //         //如果失败，则退钱
    //         if ($inputs['status'] == '失败') {
    //             $user = User::find($money_record->user_id);
    //             if (!is_null($money_record)) {
    //                 $user->update(['money' => $user->money + $money_record->money]);
    //             }
    //         }
    //     }
        
    // }


    public function tixian(Request $request)
    {
        
        $user = auth('web')->user();

        $money_records = $user->tixian()->orderBy('created_at', 'desc')->paginate(15);
        return view('front.user.tixian.index')
            ->with('user', $user)
            ->with('money_records', $money_records);
    }

    public function tixian_detail(Request $request, $id)
    {
        $moneyRecord = $this->moneyRecordRepository->findWithoutFail($id);

        if (empty($moneyRecord)) {
            Flash::error('记录不存在');

            return redirect(route('/tixian'));
        }

        $user = auth('web')->user();

        return view('front.user.tixian.detail')
            ->with('user', $user)
            
            ->with('moneyRecord', $moneyRecord);
    }

    public function kefu()
    {
        return view('front.user.kefu');
    }

}
