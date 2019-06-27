<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Log;
use RsaCrypt;
use RSAUtils;
use CURLFile;

use GuzzleHttp\Client;
use App\Models\JifenRecord;

class JifenController extends Controller
{

    /**
     * 获取所有银行列表
     *
     * @SWG\Get(path="/api/shop/mashang/bankList",
     *   tags={"商城显示模块-马上贷"},
     *   summary="信用卡积分兑换-获取所有银行列表",
     *   description="信用卡积分兑换-获取所有银行列表,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回银行列表",
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
    public function bankList()
    {
        $result = app('commonRepo')->jifenRepo()->bankList();
        return response()->json(['status_code' => 0, 'data' => $result] );
    }


    /**
     * 发起礼物兑换
     *
     * @SWG\Post(path="/api/shop/mashang/gift_apply",
     *   tags={"商城显示模块-马上贷"},
     *   summary="信用卡积分兑换-发起礼物兑换",
     *   description="信用卡积分兑换-发起礼物兑换,需要带上token参数后获取",
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
     *     name="oemId",
     *     type="string",
     *     description="oemId",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="tagId",
     *     type="string",
     *     description="tagId",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="type类型 EXCHANGE_CODE | QR_CODE可选",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="code",
     *     type="string",
     *     description="code type选EXCHANGE_CODE ",
     *     required=false,
     *   ), 
     *   @SWG\Parameter(
     *     in="query",
     *     name="image",
     *     type="string",
     *     description="code type选EXCHANGE_CODE ",
     *     required=false,
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
    public function giftApply(Request $request)
    {
    	$input = $request->all();
    	if ($this->varifyInputParam($input, ['oemId', 'tagId', 'type'], true)) {
    		return response()->json(['status_code' => 1, 'data' => '参数错误'] );
    	}

        if ($input['type'] == 'EXCHANGE_CODE') {
            if ($this->varifyInputParam($input, ['code'], true)) {
                return response()->json(['status_code' => 1, 'data' => '请填写兑换码'] );
            }
        }
        if ($input['type'] == 'QR_CODE') {
            if ($this->varifyInputParam($input, ['image'], true)) {
                return response()->json(['status_code' => 1, 'data' => '请上传图片'] );
            }
        }

        //查询类目详情
        $tagDetail = json_decode(app('commonRepo')->jifenRepo()->tagDetail($input['tagId']));
        if ($tagDetail->status != 200) {
            return response()->json(['status_code' => 1, 'data' => $tagDetail->message] );
        }

        //查询通道价格
        $price = json_decode(app('commonRepo')->jifenRepo()->price($input['oemId']));
        if ($price->status != 200) {
            return response()->json(['status_code' => 1, 'data' => $price->message] );
        }

        // if (Config::get('zcjy.JIFEN_USER_PERCENT') && Config::get('zcjy.JIFEN_USER_PERCENT') != 100) {
        //     $price->result->price = intval($price->result->price*(Config::get('zcjy.JIFEN_USER_PERCENT') ? Config::get('zcjy.JIFEN_USER_PERCENT') : 100)/100);
        // }

        $user = auth()->user();

        $money_total = $tagDetail->result->credit/1000000*$price->result->price;

        $result = app('commonRepo')->jifenRepo()->save($input['oemId'], $input['tagId'], $input['code'], $input['image'], $input['type'], $price->result->name, $tagDetail->result->title, $money_total, $user, $request->root().'/jifen_callback');

        return response()->json(['status_code' => 0, 'data' => $result] );
    }


    /**
     * 获取tagDetail
     *
     * @SWG\Get(path="/api/shop/mashang/gift_detail/{tagId}",
     *   tags={"商城显示模块-马上贷"},
     *   summary="信用卡积分兑换-获取tagDetail",
     *   description="信用卡积分兑换-获取tagDetail,需要带上token参数后获取",
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
     *     name="tagId",
     *     type="string",
     *     description="tagId",
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
    public function tagDetail($tagId)
    {
        $result = app('commonRepo')->jifenRepo()->tagDetail($tagId);
        return response()->json(['status_code' => 0, 'data' => json_decode($result)] );
    }

    /**
     * 获取postGifts
     *
     * @SWG\Get(path="/api/shop/mashang/gifts/{id}",
     *   tags={"商城显示模块-马上贷"},
     *   summary="信用卡积分兑换-获取postGifts",
     *   description="信用卡积分兑换-获取postGifts,需要带上token参数后获取",
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
     *     name="id",
     *     type="string",
     *     description="id",
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
    public function postGifts(Request $request, $id)
    {
        $result = app('commonRepo')->jifenRepo()->gifts($id);
        return response()->json(['status_code' => 0, 'data' => json_decode($result)] );
    }


    /**
     * 获取price价格
     *
     * @SWG\Get(path="/api/shop/mashang/price/{id}",
     *   tags={"商城显示模块-马上贷"},
     *   summary="信用卡积分兑换-获取price价格",
     *   description="信用卡积分兑换-获取price价格,需要带上token参数后获取",
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
     *     name="id",
     *     type="string",
     *     description="id",
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
    public function price(Request $request, $id)
    {
    	$result = app('commonRepo')->jifenRepo()->price($id);
        $result = json_decode($result);

        if ($result->status == 200) {
            if (Config::get('zcjy.JIFEN_USER_PERCENT') && Config::get('zcjy.JIFEN_USER_PERCENT') != 100) {
                $result->result->price = intval($result->result->price*(Config::get('zcjy.JIFEN_USER_PERCENT') ? Config::get('zcjy.JIFEN_USER_PERCENT') : 100)/100);
            }
            return response()->json(['status_code' => 0, 'data' => $result] );
        } else {
             return response()->json(['status_code' => 1, 'data' => $result->message] );
        }        
    }

    /**
     * 获取信用卡积分记录
     *
     * @SWG\Get(path="/api/shop/mashang/jife_records",
     *   tags={"商城显示模块-马上贷"},
     *   summary="信用卡积分兑换-获取信用卡积分记录",
     *   description="信用卡积分兑换-获取信用卡积分记录,需要带上token参数后获取",
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
    public function jifenRecords(Request $request)
    {
        $inputs = $request->all();
        $user = auth()->user();
        $skip = 0;
        $take = 20;
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        $records = JifenRecord::where('user_id', $user->id)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        return response()->json(['status_code' => 0, 'data' => $records] );
    }

    private function varifyInputParam($input, $attr=[], $check_empty=false){
    	//$result = false;
    	if(count($attr)){
	    	foreach ($attr as $key => $val) {
				if(!array_key_exists($val,$input)){
					return true;
				}
				if ($check_empty && empty($input[$val])) {
					return true;
				}
	    	}
    	}
		return false;
    }

}
