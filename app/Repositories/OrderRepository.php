<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderCancel;
use App\Models\Setting;
use App\Models\TeamFound;
use App\Models\TeamFollow;
use App\Models\Product;
use App\Models\SpecProductPrice;
use App\Models\Item;
use App\Models\CouponUser;
use App\Models\OrderAction;

use InfyOm\Generator\Common\BaseRepository;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Events\OrderEvent;



class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
    'snumber',
        'price',
        'origin_price',
        'preferential',
        'freight',
        'coupon_money',
        'user_level_money',
        'user_money_pay',
        'credits_money',
        'credits',
        'cost',
        'price_adjust',
        'order_delivery',
        'order_pay',
        'order_status',
        'pay_type',
        'remark',
        'customer_name',
        'customer_phone',
        'customer_address',
        'delivery_province',
        'delivery_city',
        'delivery_district',
        'delivery_street',
        'delivery_company',
        'delivery_return',
        'delivery_no',
        'pay_platform',
        'pay_no',
        'out_trade_no',
        'user_id',
        'prom_id',
        'prom_type',
        'invoice',
        'invoice_type',
        'invoice_title',
        'tax_no',
        'sendtime',
        'confirm_time',
        'paytime',
        'backup01',
        'jifen'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }

    public function updateManyItemsOrderId($items,$order_id)
    {
        $item_id_arr= [];
        if(count($items))
        {
            foreach ($items as $key => $item) 
            {
                $item_id_arr[] = $item->id;
            }
        }
        Item::whereIn('id',$item_id_arr)->update(['order_id'=>$order_id]);
    }

    /**
     * 生成订单并且发起支付
     * @param  [type] $user   [description]
     * @param  [type] $inputs [description]
     * @return [type]         [description]
     */
    public function generateOrderToPay($user,$request,$pay_platform = '支付宝')
    {
        $address =  app('commonRepo')->addressRepo()->getUserDefaultAddress($user);

        if(empty($address))
        {
            return zcjy_callback_data('请先添加收货地址',1);
        }

        $inputs = $request->all();
        $inputs['user_id'] = $user->id;
        $inputs['snumber'] = '';
        $inputs['pay_platform'] = $pay_platform;

        //发票信息
        if (array_key_exists('invoice', $inputs)) 
        {
            $inputs['invoice'] = '要';
        }
        else{
            $inputs['invoice'] = '不要';
        }

        if (isset($inputs['address_id'])) 
        {
            $address = app('commonRepo')->addressRepo()->findWithoutFail($inputs['address_id']);

            if(empty($address))
            {
                return zcjy_callback_data('该地址不存在',1);
            }

            $inputs['customer_name']     = $address->name;
            $inputs['customer_phone']    = $address->phone;
            $inputs['customer_address']  = $address->detail;

        }
        else{
            return zcjy_callback_data('请选择收货地址',1);
        }

        #获取购物车数据
        $result = app('cart')::get($user->id,$inputs['items']);
        //总成本
        $totalCost = $result['cost'];
        //总价格
        $totalprice = $result['price'];
        //所需积分
        $jifen = $result['jifen'];

        // $orderUseCredit = $jifen;

        if(empty($totalprice) && empty($jifen))
        {
            return zcjy_callback_data('请选择商品进行购买',1);
        }

        $items = $result['items'];

        if(array_key_exists('credits',$inputs))
        {
            $jifen = $inputs['credits'];
        }

        //积分抵扣
        $creditResult = app('commonRepo')->CreditPreference($user, $totalprice, $jifen);
        $creditPreference = $creditResult['creditPreference'];
        $credits = 0;
        //$creditResult['credits'];


        //判断积分是否足够
        if ($user->credits < $jifen) 
        {
            return zcjy_callback_data('您的'.getSettingValueByKeyCache('credits_alias').'不足以兑换',1);
        }

        #先把未支付的重置
        // Order::where('order_pay','未支付')->delete();

        #新建订单
        $order = Order::create($inputs);
  

        $this->updateManyItemsOrderId($items,$order->id);

        //优惠券优惠金额
        $couponPreference = 0;
        // if (array_key_exists('coupon_id', $inputs)) {
        //     $finalResult = app('commonRepo')->CouponPreference($inputs['coupon_id'], $totalprice, $items);
        //     if ($finalResult['code'] == 0) {
        //         $couponPreference = $finalResult['message']['discount'];
        //         //冻结优惠券
        //         CouponUser::where('id', $inputs['coupon_id'])->update(['status' => 1]);
        //     }
        // }

        //计算订单优惠
        $orderPreference = 0;
        // app('commonRepo')->orderPreference($totalprice);

        //会员优惠
        $userLevelPreference = 0;
        // app('commonRepo')->UserLevelPreference($user, $totalprice);

        $price = $totalprice - $couponPreference - $orderPreference['money'] -$userLevelPreference - $creditPreference + $order->freight;
        //使用余额支付
         $user_money_pay = 0;
        // if (array_key_exists('user_money_pay', $inputs)) {
        //     $user_money_pay = $inputs['user_money_pay'];
        //     $user_money_pay = $user_money_pay > $user->user_money ? $user->user_money : $user_money_pay;
        //     $user_money_pay = $user_money_pay > $price ? $price : $user_money_pay;
        // }

        if ($price - $user_money_pay > 0) {
            // 更新订单编号和总金额
            $this->update([
                'price' => $price - $user_money_pay,
                'origin_price' => $totalprice,
                'cost' => $totalCost,
                'preferential' => $orderPreference['money'], 
                'coupon_money' => $couponPreference, 
                'credits_money' => $creditPreference, 
                'user_level_money' => $userLevelPreference, 
                'credits' => $credits, 
                'snumber' => 6000000 + $order->id,
                'user_money_pay' => $user_money_pay,
                'jifen' => $jifen
                ], $order->id);
        } else {
            // 不需要再支付
            $this->update([
                'price' => $price - $user_money_pay,
                'origin_price' => $totalprice,
                'cost' => $totalCost,
                'preferential' => $orderPreference['money'], 
                'coupon_money' => $couponPreference, 
                'credits_money' => $creditPreference, 
                'user_level_money' => $userLevelPreference, 
                'credits' => $credits, 
                'order_pay' => '已支付',
                'snumber' => 6000000 + $order->id,
                'user_money_pay' => $user_money_pay,
                'jifen' => $jifen
                ], $order->id); 
        }

        //减库存
        if (getSettingValueByKey('inventory_consume') == '下单成功') {
            $this->deduceInventory($order->id);
        }

        //消耗用户余额
        // $user->user_money = $user->user_money - $user_money_pay;
        //消耗用户积分
        $user->credits = $user->credits - $jifen;
        $user->save();

        app('commonRepo')->addCreditLog($user->credits, -($jifen), '用户使用积分消费，订单编号:'.$order->id, 3, $user->id);

        ## 如果是价格是0的商品 就只用积分兑换即可
        if(empty($totalprice) && !empty($jifen))
        {
              $this->update([
                'order_pay' => '已支付'
                ], $order->id); 
            return zcjy_callback_data('兑换积分商品成功');
        }

        // app('commonRepo')->addMoneyLog($user->user_money, -$user_money_pay, '用户使用余额消费，订单编号:'.$order->id, 2, $user->id);
        
        $order_seeting = [
            'out_trade_no' => 6000000 + $order->id,
            'total_amount' => $price - $user_money_pay,
            'subject' => '下单购物',
        ];
        Log::info($order_seeting);
        return zcjy_callback_data(app('commonRepo')->appAliPay($request,$order_seeting,'buy_shop'));
    }

    /**
     * 根据订单id马上发起支付
     * @param  [type] $request  [description]
     * @param  [type] $order_id [description]
     * @return [type]           [description]
     */
    public function payNowOrder($request,$order_id)
    {
        $order = Order::find($order_id);
        if(empty($order))
        {
            return zcjy_callback_data('没有找到该订单',1);
        }
        if($order->order_pay == '已支付')
        {
            return zcjy_callback_data('该订单已支付成功,请勿重复支付',1);
        }
        $order_seeting = [
            'out_trade_no' => $order->snumber,
            'total_amount' => $order->price,
            'subject' => '下单购物',
        ];
        return zcjy_callback_data(app('commonRepo')->appAliPay($request,$order_seeting,'buy_shop'));
    }

    /**
     * 只用于之前 web
     * @param  [type] $user   [用户]
     * @param  [type] $items  [购物车商品]
     * @param  [type] $inputs [其他如优惠券、积分使用等信息]
     * @return [type]         [description]
     */
    public function createOrder($user, $items, $inputs)
    {
        $inputs['user_id'] = $user->id;
        $inputs['snumber'] = '';
        //发票信息
        if (array_key_exists('invoice', $inputs)) {
            $inputs['invoice'] = '要';
        }else{
            $inputs['invoice'] = '不要';
        }
        $order = Order::create($inputs);
 
        $result = $this->saveItems($order, $items);

        //总成本
        $totalCost = $result['totalCost'];
        //总价格
        $totalprice = $result['total'];
        //所需积分
        $jifen = $result['jifen'];

        //$totalprice = ShoppingCart::total();

        //优惠券优惠金额
        $couponPreference = 0;
        if (array_key_exists('coupon_id', $inputs)) {
            $finalResult = app('commonRepo')->CouponPreference($inputs['coupon_id'], $totalprice, $items);
            if ($finalResult['code'] == 0) {
                $couponPreference = $finalResult['message']['discount'];
                //冻结优惠券
                CouponUser::where('id', $inputs['coupon_id'])->update(['status' => 1]);
            }
        }

        //计算订单优惠
        $orderPreference = app('commonRepo')->orderPreference($totalprice);

        //会员优惠
        $userLevelPreference = app('commonRepo')->UserLevelPreference($user, $totalprice);

        //积分抵扣
        $creditResult = app('commonRepo')->CreditPreference($user, $totalprice, $jifen);
        $creditPreference = $creditResult['creditPreference'];
        $credits = $creditResult['credits'];

        //判断积分是否足够
        if ($user->credits < $credits + $jifen) {
            return ['code' => 1, 'data' => '用户'.getSettingValueByKeyCache('credits_alias').'不够'];
        }

        $price = $totalprice - $couponPreference - $orderPreference['money'] -$userLevelPreference - $creditPreference + $order->freight;
        //使用余额支付
        $user_money_pay = 0;
        if (array_key_exists('user_money_pay', $inputs)) {
            $user_money_pay = $inputs['user_money_pay'];
            $user_money_pay = $user_money_pay > $user->user_money ? $user->user_money : $user_money_pay;
            $user_money_pay = $user_money_pay > $price ? $price : $user_money_pay;
        }

        if ($price - $user_money_pay > 0) {
            // 更新订单编号和总金额
            $this->update([
                'price' => $price - $user_money_pay,
                'origin_price' => $totalprice,
                'cost' => $totalCost,
                'preferential' => $orderPreference['money'], 
                'coupon_money' => $couponPreference, 
                'credits_money' => $creditPreference, 
                'user_level_money' => $userLevelPreference, 
                'credits' => $credits, 
                'snumber' => 6000000 + $order->id,
                'user_money_pay' => $user_money_pay,
                'jifen' => $jifen
                ], $order->id);
        } else {
            // 不需要再支付
            $this->update([
                'price' => $price - $user_money_pay,
                'origin_price' => $totalprice,
                'cost' => $totalCost,
                'preferential' => $orderPreference['money'], 
                'coupon_money' => $couponPreference, 
                'credits_money' => $creditPreference, 
                'user_level_money' => $userLevelPreference, 
                'credits' => $credits, 
                'order_pay' => '已支付',
                'snumber' => 6000000 + $order->id,
                'user_money_pay' => $user_money_pay,
                'jifen' => $jifen
                ], $order->id); 
        }

        //减库存
        if (getSettingValueByKey('inventory_consume') == '下单成功') {
            $this->deduceInventory($order->id);
        }

        //消耗用户余额
        $user->user_money = $user->user_money - $user_money_pay;
        //消耗用户积分
        $user->credits = $user->credits - $credits - $jifen;
        $user->save();
        app('commonRepo')->addCreditLog($user->credits, -($credits + $jifen), '用户使用积分消费，订单编号:'.$order->id, 3, $user->id);
        app('commonRepo')->addMoneyLog($user->user_money, -$user_money_pay, '用户使用余额消费，订单编号:'.$order->id, 2, $user->id);

        return ['code' => 0, 'data' => $order];
    }

    public function deleteOrderById($id)
    {
        $order = $this->findWithoutFail($id);
        if (empty($order)) {
            return ['code' => 1, 'message' => '订单不存在'];
        }
        $order->items()->delete();
        $order->delete();
        return ['code' => 0, 'message' => '订单删除成功'];
    }


    public function cancelOrderApi($user,$id, $reason='无', $operator='系统')
    {
         try {
            $order = $this->findWithoutFail($id);
            if (empty($order)) 
            {
                return zcjy_callback_data('订单不存在',1);
            }

            if (OrderCancel::where('order_id', $id)->count()) 
            {
                return zcjy_callback_data('订单已被取消过，无法再次取消',1);
            }

            if ($order->order_delivery != '未发货') 
            {
                return zcjy_callback_data('商家已发货，无法取消订单',1);
            }

            $order->update(['order_status' => '已取消']);

            if(empty($reason))
            {
                $reason = '无';
            }

            //订单操作记录
            app('commonRepo')->addOrderLog(
                $order->order_status, 
                $order->order_delivery, 
                $order->order_pay, 
                '取消订单', 
                $reason, 
                '用户ID：'.$user->id, 
                $order->id);

            if ($order->order_pay == '已支付') {
                //已支付的订单进入退款流程
                OrderCancel::create([
                    'order_id' => $id,
                    'reason' => $reason,
                    'money' => $order->price,
                    'user_money' => $order->user_money_pay,
                    'credits' => $order->credits,
                    'auth' => 0,
                    'refound' => 0,
                ]);
            }else{
                //没有支付，但是使用了积分跟余额，则退还
                $user = $order->customer;
                if (!empty($user) && $order->jifen) {
                    // $user->user_money += $order->user_money_pay;
                    $user->credits +=   $order->jifen;
                    $user->save();

                    if ($order->credits) {
                        app('commonRepo')->addCreditLog($user->credits, $order->credits + $order->jifen, '订单取消，返还'.getSettingValueByKeyCache('credits_alias').'，订单编号:'.$order->id, 0, $user->id);
                    }
                    if ($order->user_money_pay) {
                        // app('commonRepo')->addMoneyLog($user->user_money, $order->user_money_pay, '订单取消，返还余额，订单编号:'.$order->id, 0, $user->id);
                    }
                }
            }
            return zcjy_callback_data('订单取消成功');
        } catch (Exception $e) {
            return  zcjy_callback_data('未知错误',1);
        }
    }


    public function deleteOneOrder($id)
    {
        OrderAction::where('order_id',$id)->delete();
        OrderCancel::where('order_id',$id)->delete();
        Item::where('order_id',$id)->delete();
        Order::where('id',$id)->delete();
    }


    public function cancelOrder($id, $reason='无', $operator='系统')
    {
        try {
            $user = auth('web')->user();
            $order = $this->findWithoutFail($id);
            if (empty($order)) {
                return ['code' => 1, 'message' => '订单不存在'];
            }

            if (OrderCancel::where('order_id', $id)->count()) {
                return ['code' => 1, 'message' => '订单已被取消过，无法再次取消'];
            }

            if ($order->order_delivery != '未发货') {
                return ['code' => 1, 'message' => '商家已发货，无法取消订单'];
            }

            $order->update(['order_status' => '已取消']);

            //订单操作记录
            app('commonRepo')->addOrderLog(
                $order->order_status, 
                $order->order_delivery, 
                $order->order_pay, 
                '取消订单', 
                $reason, 
                '用户ID：'.$user->id, 
                $order->id);

            if ($order->order_pay == '已支付') {
                //已支付的订单进入退款流程
                OrderCancel::create([
                    'order_id' => $id,
                    'reason' => $reason,
                    'money' => $order->price,
                    'user_money' => $order->user_money_pay,
                    'credits' => $order->credits,
                    'auth' => 0,
                    'refound' => 0,
                ]);
            }else{
                //没有支付，但是使用了积分跟余额，则退还
                $user = $order->customer;
                if (!empty($user) && ($order->user_money_pay || $order->credits)) {
                    $user->user_money += $order->user_money_pay;
                    $user->credits += ($order->credits + $order->jifen);
                    $user->save();

                    if ($order->credits) {
                        app('commonRepo')->addCreditLog($user->credits, $order->credits + $order->jifen, '订单取消，返还'.getSettingValueByKeyCache('credits_alias').'，订单编号:'.$order->id, 0, $user->id);
                    }
                    if ($order->user_money_pay) {
                        app('commonRepo')->addMoneyLog($user->user_money, $order->user_money_pay, '订单取消，返还余额，订单编号:'.$order->id, 0, $user->id);
                    }
                }
            }
            return ['code' => 0, 'message' => '订单取消成功'];
        } catch (Exception $e) {
            return ['code' => 1, 'message' => '未知错误'];
        }
    }

    //确认收货
    public function confirmOrderApi($id,$operator='系统')
    {
       $action = $this->confirmOrder($id,$operator);

       if($action['code'])
       {
        return zcjy_callback_data($action['message']);
       }
       return zcjy_callback_data($action['message']);
    }

    //查找快递web版本
    public function searchKuaiDiWebApi($id)
    {
        $order = $this->findWithoutFail($id);
        if (empty($order)) {
            return zcjy_callback_data('订单不存在',1);
        }

        if (OrderCancel::where('order_id', $id)->count()) {
            return zcjy_callback_data('订单已被取消',1);
        }

        if ($order->order_delivery == '未发货') {
            return zcjy_callback_data('商家还未发货，无法查询物流',1);
        }

        $link = 'https://m.kuaidi100.com/index_all.html?type='.$order->delivery_company.'&postid='.$order->delivery_no;
        return zcjy_callback_data($link);

    }

    public function confirmOrder($id, $operator='系统')
    {
        try {
            $order = $this->findWithoutFail($id);
            if (empty($order)) {
                return ['code' => 1, 'message' => '订单不存在'];
            }

            if (OrderCancel::where('order_id', $id)->count()) {
                return ['code' => 1, 'message' => '订单已被取消'];
            }

            if ($order->order_delivery == '未发货') {
                return ['code' => 1, 'message' => '商家还未发货，无法确认订单'];
            }

            if ($order->order_delivery == '已收货') {
                return ['code' => 0, 'message' => '订单确认成功'];
            }

            $order->update(['order_delivery' => '已收货', 'confirm_time' => Carbon::now()]);

            //订单操作记录
            app('commonRepo')->addOrderLog(
                $order->order_status,
                $order->order_delivery, 
                $order->order_pay, 
                '确认订单', 
                '无', 
                $operator, 
                $order->id);

            //用户确认事件
            event(new OrderEvent($order));

            return ['code' => 0, 'message' => '订单确认成功'];
        } catch (Exception $e) {
            return ['code' => 1, 'message' => '未知错误'];
        }
    }

    public function deleteOrder($order)
    {
        //如果订单处于某种特定的状态，不应该能被删除
        //如果是团购，清除拼团信息
        if ($order->prom_type == 5) {
            TeamFound::where('order_id', $id)->delete();
            TeamFollow::where('order_id', $id)->delete();
        }
        //还原优惠券状态
        $order->coupons()->update(['order_id' => null, 'use_time' => null, 'status' => 0]);
        //删除订单商品
        Item::where('order_id', $id)->delete();
        //删除订单
        $this->delete($id);
    }

    //消减库存
    public function deduceInventory($order_id)
    {
        $items = Item::where('order_id', $order_id)->get();
        foreach ($items as $item) {
            if (empty($item->spec_key)) {
                //无规格商品
                $product = Product::where('id', $item->product_id)->first();
                if ($product && $product->inventory != -1 && !empty($product)) {
                    $product->inventory = $product->inventory - $item->count;
                    $product->save();
                }
            } else {
                $specProductPrice = SpecProductPrice::where('product_id', $item->product_id)->where('key', $item->spec_key)->first();
                if ($specProductPrice && $specProductPrice->inventory != -1 && !empty($specProductPrice)) {
                    $specProductPrice->inventory = $specProductPrice->inventory - $item->count;
                    $specProductPrice->save();
                }
            }
        }
    }

    //处理商品的销售数量
    public function dealOrderProductSales($order)
    {
        $items = $order->items;
        if(count($items))
        {
            foreach ($items as $key => $item) {
                $product = Product::find($item->product_id);
                if(!empty($product))
                {
                    $product->update(['sales_count'=>$product->sales_count+$item->count]);
                }
            }
        } 
    }

    //计算按商品提成金额
    public function productCommission($order_id)
    {
        $total = 0;
        $items = Item::where('order_id', $order_id)->get();
        foreach ($items as $key => $value) {
            $total += $value->product->commission;
        }
        return $total;
    }

    //重新计算订单价格
    public function reCaculateOrderPrice($order_id)
    {
        //重新计算订单价格
        $order = $this->findWithoutFail($order_id);
        if (!empty($order)) {
            $items = $order->items()->get();
            $origin_price = 0;
            foreach ($items as $key => $item) {
                $origin_price += $item->price * $item->count;
            }
            //计算运费(待定)

            //如果使用了优惠券，则计算优惠价格
            $coupon = $order->coupons()->first();
            if (is_null($coupon)) {
                $new_price = $origin_price - $order->preferential + $order->freight;
                $this->update(['origin_price' => $origin_price, 'price' => $new_price], $order->id);
            }else{
                $youhui = 0;
                if ($coupon->type == '满减') {
                    $youhui = $coupon->given;
                } else if ($coupon->type == '打折'){
                    $youhui = $origin_price * (100 - $coupon->discount) / 100;
                }
                // 将优惠券冻结
                $new_price = $origin_price - $youhui + $order->freight;
                $this->update(['origin_price' => $origin_price, 'price' => $new_price, 'preferential' => $youhui], $order->id);
            }
        }
    }

    /**
     * 飞蛾小票打印
     * @param  [type] $id [订单ID]
     * @return [type]     [description]
     */
    public function printOrder($id){
        
        $orderInfo = null;
        $orderInfo = '<CB>订单编号'.$order->snumber.'</CB><BR>';
        $orderInfo .= '联系人：'.$order->customer_name.'<BR>';
        $orderInfo .= '联系方式：'.$order->customer_phone.'<BR>';
        $orderInfo .= '送货地址：'.$order->customer_address.'<BR>';
        $orderInfo .= '订单金额：'.$order->price.'<BR>';
        $orderInfo .= '商品总价：'.$order->origin_price.'<BR>';
        if($order->preferential){ $orderInfo .= '订单减免：-'.$order->preferential.'<BR>';}
        if($order->coupon_money){ $orderInfo .= '优惠券减免：-'.$order->coupon_money.'<BR>';}
        if($order->credits_money){ $orderInfo .= getSettingValueByKeyCache('credits_alias').'抵扣：-'.$order->credits_money.'<BR>';}
        if($order->user_level_money){ $orderInfo .= '会员折扣：-'.$order->user_level_money.'<BR>';}
        if($order->user_money_pay){ $orderInfo .= '余额支付：-'.$order->user_money_pay.'<BR>';}
        if($order->price_adjust){ $orderInfo .= '价格调整：-'.$order->price_adjust.'<BR>';}
        if($order->freight){ $orderInfo .= '运费：'.$order->freight.'<BR>';}
        $orderInfo .= '支付方式：'.$order->pay_type.'<BR>';
        $orderInfo .= '支付平台：'.$order->pay_platform.'<BR>';
        $orderInfo .= '支付状态：'.$order->order_pay.'<BR>';
        if($order->remark){ $orderInfo .= '客户留言：'.$order->remark.'<BR>';}
        if($order->backup01){ $orderInfo .= '订单备注：'.$order->backup01.'<BR>';}
        $orderInfo .= '商品列表：<BR>';
        $orderInfo .= '--------------------------------<BR>';
        $items->each(function ($item, $key) use (&$orderInfo) {
            $orderInfo .= $item->name.' '.$item->spec_keyname.'*'.$item->count.' 单价：'.$item->price.'<BR>';
        });
        $orderInfo .= '--------------------------------<BR>';
        return $this->wp_print($orderInfo, 1);

        return '订单不存在';
    }
    /*
    define('USER', 'yyjz@foxmail.com');    //*用户填写*：飞鹅云后台注册账号
    define('UKEY', 'BDacddSLJsXnGb9h');    //*用户填写*: 飞鹅云注册账号后生成的UKEY
    //API URL
    define('IP','api.feieyun.cn');      //接口IP或域名
    define('PORT',80);                  //接口IP端口
    define('HOSTNAME','/Api/Open/');    //接口路径
    define('STIME', time());            //公共参数，请求时间
    define('SIG', sha1(USER.UKEY.STIME)); //公共参数，请求公钥
    */
    private function wp_print(){
        $time = time();
        $sig = sha1(getSettingValueByKeyCache('feie_user').getSettingValueByKeyCache('feie_ukey').$time);
        $content = array(
            'user'=>getSettingValueByKeyCache('feie_user'),
            'stime'=>$time,
            'sig'=>$sig,
            'apiname'=>'Open_printMsg',

            'sn'=>getSettingValueByKeyCache('feie_sn'),
            'content'=>$orderInfo,
            'times'=>$times//打印次数
        );

        $request = new GuzzleRequest('POST', '/Api/Open/');
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://api.feieyun.cn',
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
        $response = $client->send($request, ['form_params' => $content]);
        return $response->getBody();
    }

    /**
     * 自动确认超时订单
     * @return [type] [description]
     */
    public function autoConfirmOrder()
    {
        $autoConfirmDays = getSettingValueByKeyCache('auto_complete');
        $orders = Order::where('order_pay', '已支付')
        ->where('order_status', '<>' , '无效')
        ->where('order_status', '<>' , '已取消')
        ->where('order_delivery', '已发货')
        ->get();
        foreach ($orders as $order) {
            if ( !empty($order->sendtime) && Carbon::parse($order->sendtime)->addDays($autoConfirmDays)->lt(Carbon::now()) ) {
                $this->confirmOrder($order->id, '系统');
            }
        }
    }

    /**
     * 处理超时订单
     * @return [type] [description]
     */
    public function clearExpiredOrder()
    {
        $hours = getSettingValueByKeyCache('order_expire_time');
        if ($hours <= 0) {
            return;
        }
        $orders = Order::where('order_pay', '未支付')
        ->where('pay_type', '在线支付')
        ->where('order_status', '<>' , '无效')
        ->where('order_status', '<>' , '已取消')
        ->where('order_delivery', '未发货')
        ->get();
        foreach ($orders as $order) {
            if ( Carbon::parse($order->created_at)->addHours($hours)->lt(Carbon::now()) ) {
                $this->cancelOrder($order->id, '超时未支付，系统取消订单');
            }
        }
    }

    private function saveItems($order, $items){
        $totalCost = 0;
        $total = 0;
        $jifen = 0;
        foreach ($items as $item) {
            //确认用户购买的商品存在
            // $item_id = 0;
            // $item_name = '';
            // $item_qty = 0;
            // $item_price = 0;

            // if (is_array($item)) {
            //     $item_id = $item['id'];
            //     $item_name = $item['name'];
            //     $item_qty = $item['qty'];
            //     $item_price = $item['price'];
            // } else {
            //     $item_id = $item->id;
            //     $item_name = $item->name;
            //     $item_qty = $item->qty;
            //     $item_price = $item->price;
            // }
            // 
            $item_id = $item['id'];
            $item_name = $item['name'];
            $item_qty = $item['qty'];
            $item_price = $item['price'];
            
            $tmp = explode('_', $item_id);

            $product = Product::where('id', $tmp[0])->first();
            if (empty($product)) {
                $this->delete($order->id);
                return ['code'=>1, 'message' => '对不起，商品'.$item_name.'已下架'];
            }
            if ($tmp[1] < 1) {
                //不带规格
                if ($product->inventory != -1 && $product->inventory < $item_qty) {
                    $this->delete($order->id);
                    return ['code'=>1, 'message' => '商品'.$product->name.'库存不足，最大可买数量: '.$product->inventory];
                }
                Item::create([
                    'name' => $product->name,
                    'pic' => $product->image,
                    'price' => $item_price,
                    'cost' => $product->cost,
                    'count' => $item_qty,
                    'unit' => '',
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'jifen' => $product->jifen
                ]);
                // 计算订单总金额
                $totalCost += $product->cost * $item_qty;
                $total += $item_price * $item_qty;
                $jifen += $product->jifen * $item_qty;
                
            } else {
                $spec=SpecProductPrice::find($tmp[1]);
                //$spec = $this->specProductPriceRepository->findWithoutFail($tmp[1]);
                if (empty($spec)) {
                    $this->delete($order->id);
                    return ['code'=>1, 'message' => '对不起，商品'.$item_name.' 已下架'];
                }
                if ($spec->inventory != -1 && $spec->inventory < $item_qty) {
                    $this->delete($order->id);
                    return ['code'=>1, 'message' => '商品'.$product->name.'('.$spec->key_name.') 库存不足，最大可买数量: '.$spec->inventory];
                }
                Item::create([
                    'name' => $product->name,
                    'pic' => $spec->image,
                    'price' => $item_price,
                    'cost' => $product->cost,
                    'count' => $item_qty,
                    'unit' => $spec->key_name,
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'spec_key' => $spec->key,
                    'spec_keyname' => $spec->key_name,
                    'jifen' => $spec->jifen
                ]);
                // 计算订单总金额
                $totalCost += $product->cost * $item_qty;
                $total += $item_price * $item_qty;
                $jifen += $spec->jifen * $item_qty;
            }
        }
        return ['total' => $total, 'totalCost' => $totalCost, 'jifen' => $jifen];
    }

    /**
     * [用户订单查询]
     * @param  [type] $user [description]
     * @param  [type] $word [description]
     * @return [type]       [description]
     */
    public function queryOrders($user,$word){
        $orders = $user->orders()
          ->orderBy('created_at', 'desc')
          ->with(['items'=>function($query) use ($word){
            $query->where('name','like','%'.$word.'%');
          }])
          ->get();
        $orders = $orders->filter(function($item) use ($word){
            $items = $item['items'];
            foreach ($items as $key => $val) {
               return strpos($val['name'],$word)!== false;
            }
        });
        $orders_arr = [];
        foreach ($orders as $key => $val) {
         $orders_arr[] = $val;
        }
        $orders = $this->dealWithOrders($orders);
        return $orders_arr;
    }

    /**
     * 获取订单接口
     * @param  [type]  $user [description]
     * @param  integer $type [description]
     * @param  integer $skip [description]
     * @param  integer $take [description]
     * @return [type]        [description]
     */
    public function ordersOfType($user, $type = 1, $skip = 0, $take = 18)
    {
        switch ($type) {
            case 1:
                // 全部
                $orders = $user->orders()->orderBy('created_at', 'desc')->with('items')->skip($skip)->take($take)->get();
                break;
            case 2:
                // 待付款
                $orders = $user->orders()->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '未支付']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 3:
                // 待发货
                $orders = $user->orders()->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '已支付'],
                    ['order_delivery', '=', '未发货']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 4:
                // 待确认
                $orders = $user->orders()->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '已支付'],
                    ['order_delivery', '=', '已发货']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 5:
                // 完成
                $orders = $user->orders()
                    ->orderBy('created_at', 'desc')
                    ->where('order_delivery', '已收货')
                    ->with('items')->skip($skip)->take($take)->get();
                break;
            default:
                # code...
                $orders = $user->orders()->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
                break;
        }

        $orders = $this->dealWithOrders($orders);

        return $orders;
    }

    /**
     * [处理订单]
     * @param  [type] $orders [description]
     * @return [type]         [description]
     */
    private function dealWithOrders($orders)
    {
        $orders = $orders->each(function ($order, $key) {
            $order = app('commonRepo')->orderRepo()->dealWithOneOrder($order);
        });
        return $orders;
    }

    public function dealWithOneOrder($order)
    {
            $order['status'] = $order->status;
            $items = $order->items;
            $count = 0;
            foreach ($items as $key => $item) {
                $count += $item['count'];
            }
            $order['count'] = $count;
            $type = 1;
            if($order->order_status != '无效' && $order->order_status != '已取消' && $order->order_pay == '未支付')
            {
                $type = 2;
            }
            elseif ($order->order_status != '无效' && $order->order_status != '已取消' && $order->order_pay == '已支付' && $order->order_delivery == '未发货')
            {
                $type = 3;
            }
            elseif ($order->order_status != '无效' && $order->order_status != '已取消' && $order->order_pay == '已支付' && $order->order_delivery == '已发货')
            {
               $type = 4;
            }
            elseif ($order->order_delivery == '已收货') {
               $type = 5;
            }
            $order['type'] = $type;
            return $order;
    }

    /**
     * 查询物流
     * @param  [string]    $company    [物流公司名称]
     * @param  [string]    $number     [运单号]
     * @param  [integer]   $muti       [0单行还是1所有]
     * @param  [string]    $sort       [desc默认倒序]
     * @return [json]                  [返回数据集合]
     */
    public function getLogicInfo($company,$number,$muti=0,$sort='desc'){
        $client = new Client(['base_uri' => 'http://api.kuaidi100.com']);
        $response = $client->request('GET', '/api?id=9a814ddd2cc41ed8&com='.$company.'&nu='.$number.'&show=0&muti='.$muti.'&order='.$sort);
        $data=$response->getBody();
        return $data;
    }

}
