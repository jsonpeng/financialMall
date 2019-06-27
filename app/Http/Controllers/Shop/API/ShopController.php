<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CategoryRepository;

class ShopController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * 获取一二级分类，用户分类展示
     *
     * @SWG\Get(path="/api/shop/get_toptwolevel_cats",
     *   tags={"商城显示模块-商城"},
     *   summary=" 获取一二级分类，用户分类展示",
     *   description=" 获取一二级分类，用户分类展示,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回一级二级分类列表信息",
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
    public function getTopTwoLevelCategories()
    {
    	return  zcjy_callback_data($this->categoryRepository->getTopTwoLevelCats());
    }

    /**
     * 获取某分类的商品列表不带上子分类
     *
     * @SWG\Get(path="/api/shop/get_cat_products/{cat_id}",
     *   tags={"商城显示模块-商城"},
     *   summary=" 获取某分类的商品列表不带上子分类",
     *   description="获取某分类的商品列表不带上子分类,需要带上token参数及分类id后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回一级二级分类列表信息",
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
    public function getProductsOfCat(Request $request, $cat_id)
    {
        $skip = 0;
        $take = 20;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $products =  app('commonRepo')
        ->productRepo()
        ->getProductsCached($cat_id, $skip, $take,auth()->user());
        return zcjy_callback_data($products);
    }

    /**
     * 获取某分类下的产品列表包含子分类
     *
     * @SWG\Get(path="/api/shop/get_cat_products_with_children/{cat_id}",
     *   tags={"商城显示模块-商城"},
     *   summary=" 获取某分类下的产品列表包含子分类",
     *   description="获取某分类下的产品列表包含子分类,需要带上token参数及分类id后获取",
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
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回一级二级分类列表信息",
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
    public function getProductsOfCatWithChildren(Request $request, $cat_id)
    {
        $skip = 0;
        $take = 20;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $products = app('commonRepo')
        ->productRepo()
        ->getProductsOfCatWithChildrenCatsCached($cat_id, $skip, $take,auth()->user());
        return zcjy_callback_data($products);
    }    

}
