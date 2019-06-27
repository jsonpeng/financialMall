<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Address;
use Carbon\Carbon;

class MemberController extends Controller
{
	/**
     * 获取会员分类
     *
     * @SWG\Get(path="/api/shop/member/get_cats",
     *   tags={"商城显示模块-会员"},
     *   summary="获取会员分类",
     *   description="获取会员分类,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function getMemberCats(Request $request)
    {
       return zcjy_callback_data(
       	app('commonRepo')
       	->productLevelPriceRepo()
       	->getCacheAllLevel()
       );
    }

    /**
     * 获取积分兑换商品
     *
     * @SWG\Get(path="/api/shop/member/credit_products",
     *   tags={"商城显示模块-会员"},
     *   summary="获取积分兑换商品",
     *   description="获取积分兑换商品,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回积分商品列表数据",
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
    public function getCreditProducts(Request $request)
    {
    	$skip = 0;
    	$take = 20;
    	if($request->has('skip'))
    	{
    		$skip = $request->get('skip');
    	}
    	if($request->has('take'))
    	{
    		$take = $request->get('take');
    	}
    	return zcjy_callback_data(app('commonRepo')->productRepo()->creditProducts($skip,$take));
    }

    /**
     * 获取爆款推荐商品
     *
     * @SWG\Get(path="/api/shop/member/rec_products",
     *   tags={"商城显示模块-会员"},
     *   summary="获取爆款推荐商品",
     *   description="获取爆款推荐商品,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回爆款推荐商品列表",
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
    public function getRecProducts(Request $request)
    {
        $skip = 0;
        $take = 20;
        if($request->has('skip'))
        {
            $skip = $request->get('skip');
        }
        if($request->has('take'))
        {
            $take = $request->get('take');
        }
        return zcjy_callback_data(app('commonRepo')
            ->productRepo()
            ->getRecommendProducts($skip,$take));
    }

    /**
     * 获取商品详情
     *
     * @SWG\Get(path="/api/shop/member/product/{product_id}",
     *   tags={"商城显示模块-会员"},
     *   summary="获取商品详情",
     *   description="获取商品详情,需要带上token参数及得到商品id后获取",
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
     *     in="path",
     *     name="product_id",
     *     type="integer",
     *     description="商品id",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回商品详情信息其中images->商品轮播图(多张),specs->商品规格信息,spec_goods_prices->商品规格带上价格信息(level_price->对应会员优惠后的价格),product->商品详情(product下:member_price->各个会员的优惠价格,user_price->当前用户购买商品的价格),collect_status->收藏状态",
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
    public function getProduct(Request $request,$product_id)
    {
        $product = app('commonRepo')->productRepo()->product($product_id);
        if (empty($product)) 
        {
            return zcjy_callback_data('产品信息不存在',1);
        } 
        else{
            //商品展示图片
            $productImages = $product->images;
            //商品规格信息
            $specs = app('commonRepo')->specProductPriceRepo()->get_spec($product_id);
            //计算规格优惠价格
            $spec_goods_prices =  app('commonRepo')->specProductPriceRepo()->productSpecWithSalePrice($product_id,true);
            //最终售价，将优惠活动计算在内
            $product['realPrice'] = app('commonRepo')->productRepo()->getSalesPrice($product);
            //带上会员优惠价格
            $product['member_price'] =  app('commonRepo')->productLevelPriceRepo()->getAllLevelWithPrice($product_id);
            //当前用户
            $user = auth()->user();
            //商品收藏状态
            $collect_status = app('commonRepo')->productRepo()->getCollectionStatusApi($user,$product_id);
            //当前用户价格
            $product['user_price'] = app('commonRepo')->getMemberPrice($user,$product);
            $product['max_buy'] = app('commonRepo')->maxCanBuy($product,999999);
            //服务保障
            $words = $product->words;
            return zcjy_callback_data(
                [
                    'images'            => $productImages,
                    'specs'             => $specs,
                    'spec_goods_prices' => $spec_goods_prices,
                    'product'           => $product,
                    'collect_status'    => $collect_status,
                    'words'             => $words
                ]
            );
        }
    }

    /**
     * 收藏操作商品(收藏及取消收藏)
     *
     * @SWG\Get(path="/api/shop/member/product_action_collect/{product_id}",
     *   tags={"商城显示模块-会员"},
     *   summary="收藏操作商品(收藏及取消收藏)",
     *   description="收藏操作商品(收藏及取消收藏),需要带上token参数及商品id后操作[注: 已经收藏使用接口会执行取消收藏操作,未收藏使用接口会执行收藏操作]",
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
     *     in="path",
     *     name="product_id",
     *     type="integer",
     *     description="商品id",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回操作处理结果",
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
    public function actionCollectStatus($product_id)
    {
        $product = app('commonRepo')->productRepo()->product($product_id);
        if (empty($product)) 
        {
            return zcjy_callback_data('产品信息不存在',1);
        } 
        //当前用户
        $user = auth()->user();
        //商品收藏状态
        $collect_status = app('commonRepo')->productRepo()->getCollectionStatusApi($user,$product_id);
        $status = '收藏成功';
        if($collect_status){
            $user->collections()->detach($product_id);
            $status = '取消收藏成功';
        }
        else{
            $user->collections()->attach($product_id,['created_at'=>Carbon::now()]);
        }
        return zcjy_callback_data($status);
    }

    
    /**
     * 获取猜你喜欢的商品
     *
     * @SWG\Get(path="/api/shop/member/product_fav/{product_id}",
     *   tags={"商城显示模块-会员"},
     *   summary="获取猜你喜欢的商品",
     *   description="获取猜你喜欢的商品,需要带上token参数及得到商品id后获取",
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
     *     in="path",
     *     name="product_id",
     *     type="integer",
     *     description="商品id",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function getFavProduct(Request $request, $product_id)
    {
        return zcjy_callback_data(app('commonRepo')->productRepo()->relatedProducts($product_id));
    }

    /**
     * 获取购物车列表信息
     *
     * @SWG\Get(path="/api/shop/member/carts",
     *   tags={"商城显示模块-会员"},
     *   summary="获取购物车列表信息",
     *   description="获取购物车列表信息,需要带上token参数",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function getCarts(Request $request)
    {
        return zcjy_callback_data(app('cart')::get(auth()->user()->id));
    }

    /**
     * 添加购物车操作
     *
     * @SWG\Get(path="/api/shop/member/add_cart",
     *   tags={"商城显示模块-会员"},
     *   summary="添加购物车操作",
     *   description="添加购物车操作,需要带上token参数商品id以及添加数量",
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
     *     name="product_id",
     *     type="string",
     *     description="商品id，普通商品的话直接使用商品id,规格商品的话使用商品id_规格id,例:1_3(商品id是1规格id是3的商品)",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="count",
     *     type="integer",
     *     description="商品数量",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function addCart(Request $request)
    {
        $input = $request->all();

        $input['user_id'] = auth()->user()->id;
        // return $input;
        $action = app('cart')::add($input);

        if($action)
        {
            return zcjy_callback_data($action,1);
        }

        return zcjy_callback_data(app('cart')::get(auth()->user()->id));
    }

    /**
     * 更新购物车操作
     *
     * @SWG\Get(path="/api/shop/member/update_cart",
     *   tags={"商城显示模块-会员"},
     *   summary="更新购物车操作",
     *   description="更新购物车操作,需要带上token参数,购物车指定id以及数量",
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
     *     name="cart_id",
     *     type="integer",
     *     description="单个购物车节点id",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="count",
     *     type="integer",
     *     description="商品数量",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回最新更新后的购物车信息(总价总积分其他信息等)",
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
    public function updateCart(Request $request)
    {
        $action = app('cart')::update($request->all());

        if($action)
        {
            return zcjy_callback_data($action);
        }

        return zcjy_callback_data(app('cart')::get(auth()->user()->id));
    }


    /**
     * 删除购物车操作
     *
     * @SWG\Get(path="/api/shop/member/delete_cart",
     *   tags={"商城显示模块-会员"},
     *   summary="删除购物车操作",
     *   description="删除购物车操作,需要带上token参数及购物车指定id",
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
     *     name="cart_id",
     *     type="string",
     *     description="购物车节点id,多个的话加上, 例如同时删除id分别是1,2,3的购物车就是1,2,3",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回最新更新后的购物车信息(总价总积分其他信息等)",
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
    public function deleteCart(Request $request)
    {
        $action = app('cart')::delete($request->all());

        if($action)
        {
            return zcjy_callback_data($action);
        }

        return zcjy_callback_data(app('cart')::get(auth()->user()->id));
    }

    /**
     * 获取结算信息
     *
     * @SWG\Get(path="/api/shop/member/get_checkinfo",
     *   tags={"商城显示模块-会员"},
     *   summary="获取结算信息",
     *   description="获取结算信息,可用于购物车,需要带上token参数",
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
     *     name="address_id",
     *     type="integer",
     *     description="地址id,可不传使用默认地址",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="check_address",
     *     type="string",
     *     description="校对地址 传入后才强制校对地址 购物车中可不传",
     *     required=false,
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
     *     name="items",
     *     type="string",
     *     description="购物车数据,传递请转成json字符串,格式请参照获取购物车返回数据,选中的商品请加上selected属性并且设置为1没选择的商品不加上selected属性或者设置为0或空",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回结算信息(user_level->当前用户等级,items->当前用户加入购物车的商品,cart_price_total->当前购物车中的总价,cart_jifen_total->购物车中的积分总额,creditPreference=>积分折扣金额,total->总消费金额)",
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
    public function getCheckInfo(Request $request)
    {
        $user = auth()->user();

        $address =  app('commonRepo')->addressRepo()->getUserDefaultAddress($user);

        if(empty($address))
        {
            if(isset($input['check_address'])){
                return zcjy_callback_data('请先添加收货地址',1);
            }
        }

        $input = $request->all();

        if(!isset($input['items']))
        {
            return zcjy_callback_data('请选择购物商品',1);
        }

        #当前购物车的信息
        $carts = app('cart')::get($user->id,$input['items']);

        #商品运费
        $freight = 0;

        if (isset($input['address_id'])) 
        {
            $address = app('commonRepo')->addressRepo()->findWithoutFail($input['address_id']);

            if(empty($address))
            {
                return zcjy_callback_data('该地址不存在',1);
            }
        }

        if(isset($input['check_address'])){
            $freight = app('commonRepo')->freight($address, $carts);
        }

        #购物车中的商品
        $items = $carts['items'];

        #购物车中的商品总价
        $cart_price_total = $carts['price'];

        #购物车中的积分总额
        $cart_jifen_total = $carts['jifen'];

        $credits = 0;

        if(array_key_exists('credits', $input))
        {
            $credits = $input['credits'];
        }



        //积分抵扣
        $creditResult = app('commonRepo')->CreditPreference($user, $cart_price_total, $credits);
        $creditPreference = $creditResult['creditPreference'];

        #总消费金额
        $total = round($cart_price_total+$freight-$creditPreference,2);
    
        return zcjy_callback_data([
            'address'           => $address,
            'user_level'        => $user->UserLevel,
            'items'             => $items,
            'freight'           => $freight,
            'cart_price_total'  => $cart_price_total,
            'cart_jifen_total'  => $cart_jifen_total,
            'total'             => $total,
            'creditPreference'  => $creditPreference
        ]);


    }

    /**
     * 获取收货地址列表
     *
     * @SWG\Get(path="/api/shop/member/get_address",
     *   tags={"商城显示模块-会员"},
     *   summary="获取收货地址列表",
     *   description="获取收货地址列表,需要带上token参数",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function getAddress(Request $request)
    {
        $user = auth()->user();
        return zcjy_callback_data($user->addresses()->get());
    }

    /**
     * 添加新收货地址
     *
     * @SWG\Get(path="/api/shop/member/add_address",
     *   tags={"商城显示模块-会员"},
     *   summary="添加新收货地址",
     *   description="添加新收货地址,需要带上token参数",
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
     *     name="name",
     *     type="string",
     *     description="收货人姓名",
     *     required=true,
     *   ),   
     *   @SWG\Parameter(
     *     in="query",
     *     name="phone",
     *     type="string",
     *     description="手机号码",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="province",
     *     type="string",
     *     description="省份中文",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="city",
     *     type="string",
     *     description="城市中文",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="district",
     *     type="string",
     *     description="区域中文",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="detail",
     *     type="string",
     *     description="详细地址",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="default",
     *     type="string",
     *     description="是否设置为默认地址,不传或者传空不设置,传参数则设置为默认",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function addAddress(Request $request)
    {
        $inputs = $request->all();
        $user = auth()->user();
        $inputs['user_id'] = $user->id;
        if(isset($inputs['default'])) 
        {
            $inputs['default'] = 'true';
            $user->addresses()->update(['default' => 'false']);
        }
        #新建地址
        $address = Address::create($inputs);
        return zcjy_callback_data('添加地址成功');
    }

    /**
     * 编辑保存新收货地址
     *
     * @SWG\Get(path="/api/shop/member/update_address/{address_id}",
     *   tags={"商城显示模块-会员"},
     *   summary="编辑保存新收货地址",
     *   description="编辑保存新收货地址,需要带上token参数以及地址id",
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
     *     in="path",
     *     name="address_id",
     *     type="integer",
     *     description="地址id",
     *     required=true,
     *   ), 
      *   @SWG\Parameter(
     *     in="query",
     *     name="name",
     *     type="string",
     *     description="收货人姓名",
     *     required=true,
     *   ),   
     *   @SWG\Parameter(
     *     in="query",
     *     name="phone",
     *     type="string",
     *     description="手机号码",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="province",
     *     type="string",
     *     description="省份中文",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="city",
     *     type="string",
     *     description="城市中文",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="district",
     *     type="string",
     *     description="区域中文",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="detail",
     *     type="string",
     *     description="详细地址",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="default",
     *     type="string",
     *     description="是否设置为默认地址,不传或者传空不设置,传参数则设置为默认",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function updateAddress(Request $request,$address_id)
    {
        $address = app('commonRepo')->addressRepo()->findWithoutFail($address_id);

        if (empty($address)) 
        {
            return zcjy_callback_data('没有找到该地址',1);
        }

        $inputs = $request->all();
        $user = auth()->user();

        //处理默认地址
        if(isset($inputs['default'])) {
            $inputs['default'] = 'true';
            $user->addresses()->update(['default' => 'false']);
        }

        $address->update($inputs);
        return zcjy_callback_data('更新地址成功');
    }

    /**
     * 删除收货地址
     *
     * @SWG\Get(path="/api/shop/member/delete_address/{address_id}",
     *   tags={"商城显示模块-会员"},
     *   summary="删除收货地址",
     *   description="删除收货地址,需要带上token参数以及地址id",
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
     *     in="path",
     *     name="address_id",
     *     type="integer",
     *     description="地址id",
     *     required=true,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回处理结果信息",
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
    public function deleteAddress(Request $request,$address_id)
    {
        $address = app('commonRepo')->addressRepo()->findWithoutFail($address_id);
        if (empty($address)) 
        {
            return ['status_code' => 0, 'data' => '地址信息不存在'];
        }
        $address->delete();
        return zcjy_callback_data('删除成功');
    }



}
