<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

use App\Models\Advertorial;

class CommonController extends Controller
{

    /**
     * 获取第一级城市列表
     *
     * @SWG\Get(path="/api/shop/func/get_basic_cities",
     *   tags={"商城显示模块-通用功能"},
     *   summary="获取第一级城市列表",
     *   description="获取第一级城市列表,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回城市列表",
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
    public function getBasicLevelCities(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->cityRepo()->getBasicLevelCities());
    }

    /**
     * 根据城市id获取子列表
     *
     * @SWG\Get(path="/api/shop/func/get_child_cities/{id}",
     *   tags={"商城显示模块-通用功能"},
     *   summary="根据城市id获取子列表",
     *   description="根据城市id获取子列表,需要带上token参数后获取",
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
     *     type="integer",
     *     description="城市id",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回城市列表",
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
    public function getChildCitiesById(Request $request,$id)
    {
        return zcjy_callback_data(app('commonRepo')->cityRepo()->getChildCitiesById($id));
    }

    /**
     * 搜索文章
     *
     * @SWG\Get(path="/api/shop/func/search_posts",
     *   tags={"商城显示模块-通用功能"},
     *   summary="搜索文章",
     *   description="搜索文章,需要带上token参数后获取",
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
     *     name="query",
     *     type="string",
     *     description="查询关键字",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程及黑科技文章列表",
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
    public function searchPosts(Request $request)
    {
        return app('commonRepo')->UserPostRepo()->searchPosts($request->all());
    }


    /**
     * 获取推广软文
     *
     * @SWG\Get(path="/api/shop/func/get_advertorial",
     *   tags={"商城显示模块-通用功能"},
     *   summary="获取推广软文",
     *   description="获取推广软文,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回推广软文内容",
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
    public function advertorial()
    {
        $advertorial = Advertorial::first();
        return response()->json( ['status_code' => 0, 'data' => $advertorial] );
    }

    /**
     * 文章收藏操作
     *
     * @SWG\Get(path="/api/shop/func/action_collect_post",
     *   tags={"商城显示模块-通用功能"},
     *   summary="文章收藏操作",
     *   description="文章收藏操作,需要带上token参数后获取",
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
     *     name="post_id",
     *     type="integer",
     *     description="文章id",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="类型 黑科技文章传hkj;音频课程传soundPost",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回收藏操作结果",
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
    public function actionCollectPost(Request $request)
    {
        $input = $request->all();

        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'post_id,type');

        #如果出现问题
        if($validator) 
        {
            return $validator;
        }

        $user = auth()->user();

        return app('commonRepo')->UserPostRepo()->collectAction($user->id, $input['post_id'],$input['type']);
    }


    /**
     * 用户收藏的文章列表
     *
     * @SWG\Get(path="/api/shop/func/user_collect_posts",
     *   tags={"商城显示模块-通用功能"},
     *   summary="用户收藏的文章列表",
     *   description="用户收藏的文章列表,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回音频权威课程及黑科技文章列表",
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
    public function userCollectPosts(Request $request)
    {
        $user = auth()->user();
        return app('commonRepo')->UserPostRepo()->userCollectList($user->id);
    }

    /**
     * 获取所有通知消息
     *
     * @SWG\Get(path="/api/shop/func/get_notices",
     *   tags={"商城显示模块-通用功能"},
     *   summary="获取所有通知消息",
     *   description="获取所有通知消息,需要带上token参数后获取",
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
    public function getAllNotices(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->noticeRepo()->CacheAll());
    }

    /**
     * 根据商品名查找商品
     *
     * @SWG\Get(path="/api/shop/func/find_products",
     *   tags={"商城显示模块-通用功能"},
     *   summary="根据商品名查找商品",
     *   description="根据商品名查找商品,需要带上token参数后获取",
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
     *     name="query",
     *     type="string",
     *     description="查询参数",
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
    public function findProducts(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->productRepo()->searchProduct($request->get('query')));
    }

    /**
     * 获取指定横幅
     *
     * @SWG\Get(path="/api/shop/func/get_banners/{slug}",
     *   tags={"商城显示模块-通用功能"},
     *   summary="获取指定横幅",
     *   description="获取指定横幅,需要带上token参数后获取",
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
     *     description="横幅别名 可不传默认是获取首页",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应的横幅列表",
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
    public function getBanners(Request $request,$slug = 'index')
    {
        if($slug == '{slug}')
        {
           $slug = 'index';
        }
        $banners = app('commonRepo')->bannerRepo()->getCacheBanner($slug);
        return  zcjy_callback_data($banners);
    }

    /**
     * 图片文件上传
     *
     * @SWG\Post(path="/api/shop/func/upload",
     *   tags={"商城用户常用接口"},
     *   summary="图片文件上传",
     *   description="图片文件上传,需要登录后的返回值data(token)字段来调用",
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
     *     in="formData",
     *     name="file",
     *     type="file",
     *     description="文件对象",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回图片地址",
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
    public function uploadFile()
    {
        return \Zcjy::upload('oss','api',optional(auth()->user())->id)->ossUpload();
        // $file =  Input::file('file');
        // return app('commonRepo')->uploadImages($file,'api',auth()->user());
    }


    /**
     * 获取系统设置列表
     *
     * @SWG\Get(path="/api/shop/func/get_set_list",
     *   tags={"商城显示模块-通用功能"},
     *   summary="获取系统设置列表",
     *   description="获取系统设置列表,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应的系统配置项",
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
    public function getSetList(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->settingRepo()->getSetList());
    }

    /**
     * 获取单个系统设置
     *
     * @SWG\Get(path="/api/shop/func/get_set/{name}",
     *   tags={"商城显示模块-通用功能"},
     *   summary="获取单个系统设置",
     *   description="获取单个系统设置,需要带上token参数后获取",
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
     *     name="name",
     *     type="string",
     *     description="name属性",
     *     required=true,
     *   ), 
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应的系统配置项",
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
    public function getSetObj(Request $request,$name)
    {
        return zcjy_callback_data(app('commonRepo')->settingRepo()->getSetObj($name));
    }

    /**
     * 基本功能列表
     * @param  [int]  $type [description]
     * @return [type] [description]
     */
    public function getFuncList(Request $request)
    {
        return ['status_code' => 0, 'data' =>app('commonRepo')->settingRepo()->getFuncList()];
    }

    /**
     * 当前主题
     */
    public function themeNow(Request $request){
         return ['status_code' => 0, 'data' =>theme()];
    }


    /**
     * 一次获取所有配置
     */
    public function getAllFunc(Request $request){
         return ['status_code' => 0, 'data' =>app('commonRepo')->settingRepo()->getAllFunc()];
    }


    /**
     * 系统指定的功能
     */
      public function getSystemSettingFunc(Request $request)
    {
        return app('commonRepo')->settingRepo()->getSystemSettingFunc();
    }

    /**
     * 通知消息
     */
     public function getNotices(){
         return ['status_code' => 0, 'data' =>app('commonRepo')->noticeRepo()->notices()];
     }

     /**
      * 环球国家馆
      */
     public function countries(){
         return ['status_code' => 0, 'data' =>countries()];
     }



    
}
