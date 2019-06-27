<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;

use EasyWeChat\Factory;
use App\Models\Order;
use Config;
use Log;

class PayController extends Controller
{

	private $orderRepository;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }


    /**
     * 发起商城订单购买-支付宝
     *
     * @SWG\Get(path="/api/shop/pay/alipay/buy_shop",
     *   tags={"商城支付模块"},
     *   summary="发起商城订单购买-支付宝",
     *   description="发起商城订单购买-支付宝,需要带上token参数后获取",
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
     *     name="pay_type",
     *     type="string",
     *     description="app/web 可不传默认使用app支付",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="address_id",
     *     type="integer",
     *     description="收货地址id",
     *     required=true,
     *   ), 
     *   @SWG\Parameter(
     *     in="query",
     *     name="credits",
     *     type="integer",
     *     description="使用积分 纯积分商品兑换可不传或者传返回的总积分数量",
     *     required=false,
     *   ), 
     *   @SWG\Parameter(
     *     in="query",
     *     name="invoice",
     *     type="string",
     *     description="是否要发票,默认不要传了参数就是要",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="invoice_type",
     *     type="string",
     *     description="发票类型 [个人,公司]",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="invoice_title",
     *     type="string",
     *     description="名称 发票抬头",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="tax_no",
     *     type="string",
     *     description="税号",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="items",
     *     type="string",
     *     description="购物车数据,传递请转成json字符串,格式请参照获取购物车返回数据,选中的商品请加上selected属性并且设置为1没选择的商品不加上selected属性或者设置为0或空",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回支付参数",
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
    public function alipayGenerateOrderToPay(Request $request)
    {
        return app('commonRepo')->orderRepo()->generateOrderToPay(auth()->user(),$request);
    }


    /**
     * 发起订单支付根据订单id-支付宝
     *
     * @SWG\Get(path="/api/shop/pay/alipay/pay_order/{order_id}",
     *   tags={"商城支付模块"},
     *   summary="发起订单支付根据订单id-支付宝",
     *   description="发起订单支付根据订单id-支付宝,需要带上token参数后获取",
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
     *     name="pay_type",
     *     type="string",
     *     description="app/web 可不传默认使用app支付",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回支付参数",
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
    public function payNowOrder(Request $request,$order_id)
    {
        return app('commonRepo')->orderRepo()->payNowOrder($request,$order_id);
    }

    /**
     * 发起会员购买-支付宝
     *
     * @SWG\Get(path="/api/shop/pay/alipay/buy_member",
     *   tags={"商城支付模块"},
     *   summary="发起会员购买-支付宝",
     *   description="发起会员购买-支付宝,需要带上token参数后获取",
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
     *     name="pay_type",
     *     type="string",
     *     description="app/web 可不传默认使用app支付",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="id",
     *     type="integer",
     *     description="会员id",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="code",
     *     type="string",
     *     description="优惠代码",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回支付参数",
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
     public function alipayBuyMemeber(Request $request){
        //当前用户
        $user = auth()->user();

        if (!$request->has('id')) {
            return response()->json(['status_code' => 1, 'data' => '请选择会员类型']);
        }

        $card_id = $request->input('id');
        $code = $request->input('code');
        $result = app('commonRepo')->generateOrder($user, $card_id, '支付宝',$code);

        if ($result['code']) {
            return response()->json(['status_code' => $result['code'], 'data' => $result['message']]);
        }

        $body = $result['body'];
        $order = $result['order'];

        $order_seeting = [
            'out_trade_no' => $order->pay_no,
            'total_amount' => $order->money,
            'subject' => $body,
        ];

        return zcjy_callback_data(app('commonRepo')->appAliPay($request,$order_seeting,'buy_mem'));
    }




    public function miniWechatPay(Request $request, $order_id)
    {
    	$order = $this->orderRepository->findWithoutFail($order_id);
    	if (empty($order)) {
    		return ['status_code' => 0, 'message' => '订单信息不存在'];
    	}

        $out_trade_no = $order->snumber.'_'.time();
        $order->out_trade_no = $out_trade_no;
        $order->save();

        $body = '支付订单'.$order->snumber.'费用';
        $user =auth()->user();

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => $body,
            'detail'           => '订单编号:'.$order->snumber,
            'out_trade_no'     => $out_trade_no,
            'total_fee'        => intval( $order->price * 100 ), // 单位：分
            'notify_url'       => $request->root().'/notify_wechcat_pay', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => $user->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            'attach'           => '支付订单',
        ];

        //Log::info(Config::get('wechat.payment.xiaochengxu'));

        //Log::info($attributes);

        $payment = Factory::payment(Config::get('wechat.payment.xiaochengxu'));

        $result = $payment->order->unify($attributes);

        //Log::info($result);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $prepayId = $result['prepay_id'];
            $json = $payment->jssdk->bridgeConfig($prepayId);

            return ['status_code' => 0, 'message' => $json];

        }else{
            return ['status_code' => 1, 'message' => $result];
        }
    }
}
