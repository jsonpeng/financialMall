<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\OldProductRepository;

use App\Models\OldProduct;
use App\Models\OldOrder;
use Config;
use Pay;
use Log;
use App\Models\SysSetting;
use App\Models\UserLevel;
use App\Models\CashWithdraw;
use App\Models\CashIncome;
use App\Models\PayAli;
use Carbon\Carbon;
use App\User;

use Intervention\Image\ImageManagerStatic as Image;
use QrCode;

class MemberController extends Controller
{

	/** @var  OldProductRepository */
    private $OldProductRepository;

    public function __construct(OldProductRepository $productRepo)
    {
        $this->OldProductRepository = $productRepo;
    }

    //会员卡信息
    public function intro()
    {
    	$mem_intro = $this->OldProductRepository->mem_intro();
        $userLevels = UserLevel::orderBy('money', 'asc')->get();
    	return response()->json(['status_code' => 0, 'data' => ['intro' => $mem_intro, 'levels' => $userLevels]] );
    }

    public function setting()
    {
        $setting = SysSetting::first();
        return response()->json(['status_code' => 0, 'data' => $setting] );
    }

    public function userLevels()
    {
        $userLevels = UserLevel::orderBy('money', 'asc')->get();
        return response()->json(['status_code' => 0, 'data' => $userLevels] );
    }

    public function payBuyAlipay(Request $request){
        //当前用户
        $user = auth()->user();

        if (!$request->has('cardId')) {
            return response()->json(['status_code' => 1, 'data' => ['error' => '请选择会员类型' ]] );
        }

        $card_id = $request->input('cardId');
        
        $result = app('commonRepo')->generateOrder($user, $card_id, '支付宝');

        if ($result['code']) {
            return response()->json(['status_code' => $result['code'], 'data' => ['error' => $result['message']] ] );
        }

        $body = $result['body'];
        $order = $result['order'];

        $order_seeting = [
            'out_trade_no' => $order->pay_no,
            'total_amount' => $order->money,
            'subject' => $body,
        ];

        $payAli = PayAli::inRandomOrder()->first();
        $config = Config::get('pay.alipay');
        $config['app_id'] = $payAli->app_id;
        unset($config['return_url']);
        $alipay = \Yansongda\Pay\Pay::alipay($config);
        $response = $alipay->app($order_seeting);
        //$response = Pay::alipay($config)->app($order_seeting);

        return response()->json(['status_code' => 0, 'data' => $response->getContent()] );
    }

    // public function payBuyAlipay(Request $request)
    // {
    // 	$user = auth()->user();
    //     if ($user->member && Carbon::now()->lt( Carbon::parse($user->member_end_time) )) {
    //         return response()->json(['status_code' => 1, 'data' => ['error' => '您已经是会员了，无需再次购买' ]] );
    //     }
    //     if (!$request->has('cardId') || $request->input('cardId') == 0) {
    //         return response()->json(['status_code' => 1, 'data' => ['error' => '请选择订阅套餐' ]] );
    //     }

    //     //$product = OldProduct::first();
    //     $userLevel = UserLevel::where('id', $request->input('cardId'))->first();

    //     if (empty($userLevel)) {
    //         return response()->json(['status_code' => 1, 'data' => ['error' => '订阅信息不存在' ]] );
    //     }
            
    //     $order = OldOrder::create([
    //         'money' => $userLevel->money,
    //         'pay_status' => '未支付',
    //         'platform' => '支付宝',
    //         'user_id' => $user->id,
    //         'pay_no' => time().'_'.random_int(1, 20000),
    //         'level_name' => $userLevel->name,
    //         'level_id' => $userLevel->id,
    //     ]);

    //     $order_seeting = [
    //         'out_trade_no' => $order->pay_no,
    //         'total_amount' => $order->money,
    //         'subject' => SysSetting::first()->name.$userLevel->name.'服务',
    //     ];
    //     $alipayConfig = Config::get('pay.alipay');
    //     unset($alipayConfig['return_url']);
    //     $response = Pay::alipay($alipayConfig)->app($order_seeting);

    //     return response()->json(['status_code' => 0, 'data' => $response->getContent()] );
        
    // }

   
    /**
     * 获取我的余额记录
     *
     * @SWG\Get(path="/api/shop/myself/user_money",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的余额记录",
     *   description="获取我的余额记录,需要带上token参数后获取",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回余额记录数据",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function userMoney(Request $request)
    {
        $user = auth()->user();
        $withdraw_pendding = 0;
        $withdraw_done = 0;
        if (CashWithdraw::where('user_id', $user->id)->count()) {
            $withdraw_pendding = round(CashWithdraw::where('user_id', $user->id)->where('status', '待审核')->sum('count'), 2);
        }
        
        $withdraw_done = round(CashWithdraw::where('user_id', $user->id)->where('status', '审核通过')->sum('count'), 2);
        return response()->json(['status_code' => 0, 'data' => ['withdraw_pendding' => $withdraw_pendding, 'withdraw_done' => $withdraw_done, 'withdraw_has' => $user->money] ] );
    }

     /**
     * 获取我的代理列表
     *
     * @SWG\Get(path="/api/shop/myself/my_members",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的代理列表",
     *   description="获取我的代理列表,需要带上token参数后获取",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回积分数据列表及当前用户剩余总积分",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function myMembers(Request $request)
    {
        $level = 1;
        $skip = 0;
        $take = 20;
        $members = null;

        $inputs = $request->all();
        if ($request->has('level')) {
            $level = $request->input('level');
        }
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        $user = auth()->user();

        if ($level == 1) {
            $members = User::where('leader1', $user->id)->orderBy('level_name', 'desc')->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        } else {
            $members = User::where('leader2', $user->id)->orderBy('level_name', 'desc')->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        }

        return response()->json(['status_code' => 0, 'data' => $members] );
    }

  
    /**
     * 获取我的提现记录
     *
     * @SWG\Get(path="/api/shop/myself/withdraw",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的提现记录",
     *   description="获取我的提现记录,需要带上token参数后获取",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认是0",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="单次取多少条数据,可不传默认是20",
     *     required=false,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回提现记录列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function withdraw(Request $request)
    {
        $skip = 0;
        $take = 20;
        $withdraws = null;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        $user = auth()->user();

        $withdraws = CashWithdraw::where('user_id', $user->id)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        
        return response()->json(['status_code' => 0, 'data' => $withdraws] );
    }


 
    /**
     * 发起提现操作
     *
     * @SWG\Post(path="/api/shop/myself/withdraw",
     *   tags={"商城显示模块-我的"},
     *   summary="发起提现操作",
     *   description="发起提现操作,需要设置姓名及支付宝账号及安全码后使用;需要带上token参数后获取",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="count",
     *     type="string",
     *     description="提现金额",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="code",
     *     type="string",
     *     description="安全码",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回操作结果",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function postWithdraw(Request $request)
    {
        $input = $request->all();

        if (!array_key_exists('count', $input) || empty($input['count'])) {
            return zcjy_callback_data('请填写提取金额',1);
        }

        if (!array_key_exists('code', $input) || empty($input['code'])) {
            return zcjy_callback_data('请输入安全码',1);
        }

        $setting = SysSetting::first();

        $user = auth()->user();

        if(empty($user->alipay_account))
        {
            return zcjy_callback_data('请先设置支付宝账号',1);
        }

        if(empty($user->name))
        {
            return zcjy_callback_data('请先设置姓名',1);
        }

        if(empty($user->safe_code))
        {
             return zcjy_callback_data('请先设置安全码',1);
        }

        if($input['code'] != $user->safe_code)
        {
             return zcjy_callback_data('安全码错误',1);
        }

        if ($user->money < $input['count']) {
            return  zcjy_callback_data('账户余额不足',1);
        }

        if ($setting->min_cash && $setting->min_cash > $input['count']) {
            return zcjy_callback_data('最低提取金额为'.$setting->min_cash.'元',1);
        }

        if(empty($setting->max_cash_withdraw)){
            return  zcjy_callback_data('提现功能升级中，请稍后再试',1);
        }
        if ($setting->max_cash_withdraw && $setting->max_cash_withdraw <= CashWithdraw::where('user_id', $user->id)->where('created_at', '>=', Carbon::today()->subDays(30))->count() ) {
            return zcjy_callback_data('一个月内最多提取'.$setting->max_cash_withdraw.'次',1);
        }

        $input['status'] = '待审核';
        $input['user_id'] = $user->id;
        $input['name'] = $user->name;
        $input['zhifubao'] = $user->alipay_account;
        
        CashWithdraw::create($input);

        $user->update(['money' => $user->money - $input['count']]);

        return response()->json(['status_code' => 0, 'data' => '提交成功'] );
    }


    /**
     * 获取我的收入记录
     *
     * @SWG\Get(path="/api/shop/myself/income",
     *   tags={"商城显示模块-我的"},
     *   summary="获取我的收入记录",
     *   description="获取我的收入记录,需要带上token参数后获取",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认是0",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="单次取多少条数据,可不传默认是20",
     *     required=false,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回积分数据列表及当前用户剩余总积分",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function income(Request $request)
    {
        $skip = 0;
        $take = 20;
        $type=2;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        if (array_key_exists('type', $inputs)) {
            $type = intval($inputs['type']);
        }
        $user = auth()->user();

        $incomes = CashIncome::where('user_id', $user->id);

        // if ($type == 2) {
        //     # 贷款收入
        //     $incomes = $incomes->where('type', '贷款收入');
        // } else {
        //     # 推广收入
        //     $incomes = $incomes->where('type', '推广收入');
        // }

        $incomes = $incomes->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        
        return response()->json(['status_code' => 0, 'data' => $incomes] );
    }

    public function erweima(Request $request)
    {
        $user = auth()->user();
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
        
        $img_url = $request->root().'/qrcodes/user_share'.$user->id.'.jpg';

        return response()->json(['status_code' => 0, 'data' => $img_url] );
    }

}
