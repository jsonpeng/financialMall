<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class XingYongController extends Controller
{

    /**
     * 获取贷款超市分类
     *
     * @SWG\Get(path="/api/shop/xinyong/get_platform_cats",
     *   tags={"商城显示模块-信用生活"},
     *   summary="获取贷款超市分类",
     *   description="获取贷款超市分类,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程列表",
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
    public function getPlatformCats(Request $request)
    {
       $cats = app('commonRepo')->platFormCatRepo()->cacheAll();
       return zcjy_callback_data($cats);
    }

    /**
     * 获取指定分类下的贷款
     *
     * @SWG\Get(path="/api/shop/xinyong/get_cat_platforms_dk/{cat_id}",
     *   tags={"商城显示模块-信用生活"},
     *   summary="获取指定分类下的贷款",
     *   description="获取指定分类下的贷款,需要带上token参数后获取",
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
     *     name="cat_id",
     *     type="integer",
     *     description="分类id",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认为0",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="取出多少条数据,可不传默认为20",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程列表",
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
    public function getCatPlatformsDk(Request $request,$cat_id)
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
        return zcjy_callback_data(app('commonRepo')->platFormRepo()->catPlatforms($cat_id,$skip,$take));
    }

    /**
     * 获取所有的贷款
     *
     * @SWG\Get(path="/api/shop/xinyong/get_all_platforms_dk",
     *   tags={"商城显示模块-信用生活"},
     *   summary="获取所有的贷款",
     *   description="获取所有的贷款,需要带上token参数后获取",
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
     *     description="跳过多少条数据,可不传默认为0",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="取出多少条数据,可不传默认为20",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程列表",
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
    public function getAllPlatformsDk(Request $request)
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
       return zcjy_callback_data(app('commonRepo')->platFormRepo()->platforms($skip,$take,2));
    }

    /**
     * 获取所有信用卡银行
     *
     * @SWG\Get(path="/api/shop/xinyong/get_xyk_banks",
     *   tags={"商城显示模块-信用生活"},
     *   summary="获取所有信用卡银行",
     *   description="获取所有信用卡银行,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程列表",
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
    public function getXykBanks(Request $request)
    {
            return zcjy_callback_data(app('commonRepo')->creditCardBankRepo()->cacheAll());
    }


    /**
     * 获取指定银行下的信用卡
     *
     * @SWG\Get(path="/api/shop/xinyong/get_bank_xyks/{bank_id}",
     *   tags={"商城显示模块-信用生活"},
     *   summary="获取指定银行下的信用卡",
     *   description="获取指定银行下的信用卡,需要带上token参数后获取",
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
     *     name="bank_id",
     *     type="integer",
     *     description="银行id,传0取所有",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认为0",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="取出多少条数据,可不传默认为20",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程列表",
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
    public function getBankXyks(Request $request,$bank_id)
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
        return zcjy_callback_data(app('commonRepo')->creditCardRepo()->bankXyks($bank_id,$skip,$take));
    }

    /**
     * 获取所有工具分类并且带上工具
     *
     * @SWG\Get(path="/api/shop/xinyong/get_toolcats_withtools",
     *   tags={"商城显示模块-信用生活"},
     *   summary="获取所有工具分类并且带上工具",
     *   description="获取所有工具分类并且带上工具,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回所有工具分类及工具",
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
    public function getToolCatsWithTools(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->toolRepo()->getToolCatsWithTools());
    }


    /**
     * 根据工具分类别名获取工具列表
     *
     * @SWG\Get(path="/api/shop/xinyong/get_tools_by_slug/{slug}",
     *   tags={"商城显示模块-信用生活"},
     *   summary="根据工具分类别名获取工具列表",
     *   description="根据工具分类别名获取工具列表,需要带上token参数后获取",
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
     *     name="slug",
     *     type="string",
     *     description="分类别名",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="integer",
     *     description="跳过多少条数据,可不传默认为0",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="integer",
     *     description="取出多少条数据,可不传默认为20",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程列表",
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
    public function getToolsBySlug(Request $request,$slug)
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
        return zcjy_callback_data(app('commonRepo')->toolRepo()->getToolsBySlug($slug,$skip,$take));
    }

 




}
