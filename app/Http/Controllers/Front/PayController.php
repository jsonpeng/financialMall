<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\OldProduct;
use App\Models\OldOrder;
use App\Models\SysSetting;
use App\Models\MoneyRecord;
use App\Models\UserLevel;
use App\Models\CashIncome;
use App\Models\PayAli;
use Flash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use EasyWeChat;
use EasyWeChat\Factory;

use AlipayTradeService;
use AlipayTradeWapPayContentBuilder;

class PayController extends Controller
{


    public function __construct()
    {

    }

    //微信公众号支付
    public function buyCard(Request $request){

        $user = auth('web')->user();

        $inputs = $request->all();

        if (!$request->has('cardId')) {
            return ['code' => 1, 'message' => '请选择会员类型' ] ;
        }

        $card_id = $request->input('cardId');
        
        $result = app('commonRepo')->generateOrder($user, $card_id, '微信');

        if ($result['code']) {
            return ['code' => $result['code'], 'message' => $result['message'] ] ;
        }

        $body = $result['body'];
        $order = $result['order'];        

        $order_no = $order->pay_no;

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => $body,
            'detail'           => '订单编号:'.$order_no,
            'out_trade_no'     => $order_no,
            'total_fee'        => intval( $order->money * 100 ), // 单位：分
            'notify_url'       => $request->root().'/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => $user->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            'attach'           => '课程'
        ];

        $payment = Factory::payment(Config::get('wechat.payment'));
        $result = $payment->order->unify($attributes);

        Log::info($result);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $prepayId = $result['prepay_id'];
            $json = $payment->jssdk->bridgeConfig($prepayId);

            return ['code' => 0, 'message' => $json];

        }else{
            //$payment->payment->reverse($order_no);
        }

        /*$inputs = $request->all();

        //当前微信用户
        $user = auth('web')->user();
        if ($user->member && Carbon::now()->lt(Carbon::parse($user->member_end_time))) {
            return ['code' => 1, 'message' => '您已经是会员了，无需再次购买'];
        }

        $product = OldProduct::first();
            
        $order = OldOrder::create([
            'money' => $product->price,
            'pay_status' => '未支付',
            'user_id' => $user->id,
            'platform' => '微信',
            'pay_no' => time().'_'.random_int(1, 20000)
        ]);

        $body = '会员卡购买';

        $order_no = $order->pay_no;

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => $body,
            'detail'           => '订单编号:'.$order_no,
            'out_trade_no'     => $order_no,
            'total_fee'        => intval( $order->money * 100 ), // 单位：分
            'notify_url'       => $request->root().'/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => $user->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            'attach'           => '会员卡'
        ];

        $payment = Factory::payment(Config::get('wechat.payment'));
        $result = $payment->order->unify($attributes);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $prepayId = $result['prepay_id'];
            $json = $payment->jssdk->bridgeConfig($prepayId);

            return ['code' => 0, 'message' => $json];

        }else{
            //$payment->payment->reverse($order_no);
        }*/
    }

    //微信公众号支付回调
    public function payNotify(Request $request)
    {
        $payment = Factory::payment(Config::get('wechat.payment'));
        $self = $this;
        $response = $payment->handlePaidNotify(function($message, $fail) use ($self){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单

            $order = OldOrder::where('pay_no', $message['out_trade_no'])->first();

            if (empty($order)) { // 如果订单不存在
                $fail('订单不存在'); // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->pay_status == '已支付') {
                // 已经支付成功了就不再更新了
                return true; 
            }

            // 用户是否支付成功
            if ($message['result_code'] === 'SUCCESS') {
                $this->processOrder($order, $message['transaction_id']);
            } else { // 用户支付失败
            }

            return true; // 返回处理完成
        });

        return $response;
    }

    // 商品购买-支付宝
    public function buyCardAlipay(Request $request) {

        //当前用户
        $user = auth('web')->user();

        if (!$request->has('card_id')) {
            return ['code' => 1, 'message' => '请选择会员类型'];
        }

        $card_id = $request->input('card_id');
        
        $result = app('commonRepo')->generateOrder($user, $card_id, '支付宝');

        if ($result['code'] != 0) {
            return $result;
        }

        $body = $result['body'];
        $order = $result['order'];

        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject('订单编号:'.$order->pay_no);
        $payRequestBuilder->setOutTradeNo($order->pay_no);
        $payRequestBuilder->setTotalAmount($order->money);
        $payRequestBuilder->setTimeExpress("1m");

        $payAli = PayAli::inRandomOrder()->first();
        
        $config = Config::get('alipay');
        $config['app_id'] = $payAli->app_id;
        $payResponse = new AlipayTradeService($config);
        $redirecturl = $payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return ['message' => $redirecturl, 'code' => 0]; 
    }


    /**
     * 下单 异步通知 -支付宝
     */
    public function buyShopAliNotify(Request $request)
    {
        $inputs = $request->all();

        if ($inputs['trade_status'] == 'TRADE_SUCCESS') {

            return app('commonRepo')->processShopOrder($inputs['out_trade_no'],'支付宝');

        }
        return 'success';
    }

    /**
     * 购买会员卡 异步通知 -支付宝
     */
    public function buyMemAliNotify(Request $request)
    {
        $inputs = $request->all();

        if ($inputs['trade_status'] == 'TRADE_SUCCESS') {

            //$this->processOrder($inputs['out_trade_no']);
            $order = OldOrder::where('pay_no', $inputs['out_trade_no'])->first();

            if (empty($order)) { // 如果订单不存在
                return 'failure';
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->pay_status == '已支付') {
                // 已经支付成功了就不再更新了
                return 'success'; 
            }

            $this->processOrder($order, $inputs['trade_no']);

        }
        return 'success';
    }

    /**
     * 同步通知 -支付宝
     */
    public function webReturn(Request $request)
    {
        return redirect('/pay_success');
    }

    /**
    *PAYS API支付
    */
    public function paysApi(Request $request)
    {
        $user = auth('web')->user();
        if ($user->member && Carbon::now()->lt(Carbon::parse($user->member_end_time))) {
            return ['code' => 1, 'message' => '您已经是会员了，无需再次购买'];
        }
        if (!$request->has('card_id')) {
            return ['code' => 1, 'message' => '参数不正确'];
        }
        //$product = OldProduct::first();
        $userLevel = UserLevel::where('id', $request->input('card_id'))->first();

        //校验传入的表单，确保价格为正常价格（整数，1位小数，2位小数都可以），支付渠道只能是1或者2，orderuid长度不要超过33个中英文字。
        $istype = 2;
        if ($request->has('type') && $request->input('type') == 1) {
            $istype = 1;
        }

        $platform = '微信';
        if ($istype == 1) {
            $platform = '支付宝';
        }
        
        $order = OldOrder::create([
            'money' => $userLevel->money,
            'pay_status' => '未支付',
            'platform' => $platform,
            'user_id' => $user->id,
            'pay_no' => time().'_'.random_int(1, 20000),
            'level_name' => $userLevel->name,
            'level_id' => $userLevel->id,
        ]);

        $orderuid = $user->id.'_'.$user->mobile;       //此处传入您网站用户的用户名，方便在paysapi后台查看是谁付的款，强烈建议加上。可忽略。

        

        //此处就在您服务器生成新订单，并把创建的订单号传入到下面的orderid中。
        $goodsname = "VIP服务购买";
        $orderid = $order->pay_no;    //每次有任何参数变化，订单号就变一个吧。
        $uid = Config::get('zcjy.PAYS_API_UID');//"此处填写PaysApi的uid";
        $token = Config::get('zcjy.PAYS_API_TOKEN');//"此处填写PaysApi的Token";
        $return_url = $request->root().'/paysapi_return';
        $notify_url = $request->root().'/paysapi_notify';
        $price = $userLevel->money;
        
        $key = md5($goodsname. $istype . $notify_url . $orderid . $orderuid . $price . $return_url . $token . $uid);
        //经常遇到有研发问为啥key值返回错误，大多数原因：1.参数的排列顺序不对；2.上面的参数少传了，但是这里的key值又带进去计算了，导致服务端key算出来和你的不一样。

        $returndata['goodsname'] = $goodsname;
        $returndata['istype'] = $istype;
        $returndata['key'] = $key;
        $returndata['notify_url'] = $notify_url;
        $returndata['orderid'] = $orderid;
        $returndata['orderuid'] =$orderuid;
        $returndata['price'] = $price;
        $returndata['return_url'] = $return_url;
        $returndata['uid'] = $uid;
        return ['code' => 0, 'message' => $returndata];
    }

    public function paysapiReturn(Request $request)
    {
        $inputs = $request->all();
        $orderid = $inputs["orderid"];
        $order = OldOrder::where('pay_no', $orderid)->first();
        if (empty($order) || $order->member == 0) { 
            return view('front.pay_success');
        }else{
            return view('front.pay_failure');
        }
    }

    public function paysapiNotify(Request $request)
    {
        $inputs = $request->all();
        $paysapi_id = $inputs["paysapi_id"];
        $orderid = $inputs["orderid"];
        $price = $inputs["price"];
        $realprice = $inputs["realprice"];
        $orderuid = $inputs["orderuid"];
        $key = $inputs["key"];

        //校验传入的参数是否格式正确，略

        $token = Config::get('zcjy.PAYS_API_TOKEN');
        
        $temps = md5($orderid . $orderuid . $paysapi_id . $price . $realprice . $token);

        if ($temps != $key){
            return jsonError("key值不匹配");
        }else{
            $order = OldOrder::where('pay_no', $orderid)->first();

            if (empty($order)) { // 如果订单不存在
                return jsonError("订单不存在"); 
            }

            // 检查订单是否已经更新过支付状态
            if ($order->pay_status == '已支付') {
                return jsonSuccess("成功"); 
            }
            // 用户是否支付成功
            $this->processOrder($order, $orderid);

        }

    }
    //返回错误
    private function jsonError($message = '',$url=null) 
    {
        $return['msg'] = $message;
        $return['data'] = '';
        $return['code'] = -1;
        $return['url'] = $url;
        return json_encode($return);
    }

    //返回正确
    private function jsonSuccess($message = '',$data = '',$url=null) 
    {
        $return['msg']  = $message;
        $return['data'] = $data;
        $return['code'] = 1;
        $return['url'] = $url;
        return json_encode($return);
    }
    
    // 支付成功后，处理商品订单信息
    private function processOrder($order, $trade_no = null){

        $order->update(['pay_status' => '已支付', 'trade_no' => $trade_no]);

        OldOrder::where('user_id', $order->user_id)->where('pay_status', '未支付')->delete();

        $userLevel = UserLevel::where('id', $order->level_id)->first();

        if (empty($userLevel)) {
            return;
        }

        $user = User::where('id', $order->user_id)->first();
        if (empty($user)) {
            return;
        }

        $end_time = null;

        if ($user->member && Carbon::now()->lt(Carbon::parse($user->member_end_time))) {
            //之前就是会员
            $end_time = Carbon::parse($user->member_end_time)->addDays($userLevel->days);
            //同级别会员，续费
            // if ($userLevel->level == $user->mem_level) {
            //     $end_time = Carbon::parse($user->member_end_time)->addDays($userLevel->days);
            // }

            // //升级会员，补差价
            // if ($userLevel->level > $user->mem_level) {
            //     $end_time = $user->member_end_time;
            //     $new = false;
            //     //$end_time = Carbon::now()->addDays($userLevel->days);
            // }
        }else{
            //新开会员
            $end_time = Carbon::now()->addDays($userLevel->days);
        }
        
        //更新用户信息
        $user->update([
            'member' => 1, 
            'member_buy_time' => Carbon::now(), 
            'member_end_time' => $end_time,
            'level_name' => $order->level_name,
            'level_id' => $order->level_id,
            'member_buy_money' => $userLevel->money, 
            'mem_level' => $userLevel->level, 
            'can_share' => '是', 
        ]);

        // if (Config::get('zcjy.OPEN_SHARE') && Config::get('zcjy.OPEN_MEM_FENYONG')) {
            $this->yongjin($order, $user);
        // }
        
        return;
    }

    private function yongjin($order, $user)
    {
        //给会员
        app('commonRepo')->AttachUserLevelRepo()->attachNewUserMinLevel($user);
        //发佣金
        if (!empty($user->leader1)) {
            $parent = User::where('id', $user->leader1)->first();
            if (!empty($parent)) {
                //发奖金
                $addMoney = app('commonRepo')->returnMoney($parent, $order, 1);
                //直接推荐人
                $parent->update(['money' => $parent->money+$addMoney, 'money_all' => $parent->money_all+$addMoney]);
                //操作记录
                CashIncome::create([
                    'type' => '推广收入',
                    'count' => $addMoney,
                    'user_id' => $parent->id,
                    'custorm_name' => $user->nickname,
                    'custorm_mobile' => $user->mobile,
                    'des' => '您推荐的1级用户'.$user->nickname.'办理了会员'
                ]);

                //二级推荐人
                if (!empty($user->leader2)) {
                    $granpa = User::where('id', $user->leader2)->first();
                    if (!empty($granpa)) {
                        //发奖金
                        $addMoney = app('commonRepo')->returnMoney($granpa, $order, 2, $parent);
                        if (!empty($addMoney)) {
                            //直接推荐人
                            $granpa->update(['money' => $granpa->money+$addMoney, 'money_all' => $granpa->money_all+$addMoney]);

                            //操作记录
                            CashIncome::create([
                                'type' => '推广收入',
                                'count' => $addMoney,
                                'user_id' => $granpa->id,
                                'custorm_name' => $user->nickname,
                                'custorm_mobile' => $user->mobile,
                                'des' => '您推荐的2级用户'.$user->nickname.'办理了会员'
                            ]);
                        }
                    }
                }
            }
        }
    }
}
