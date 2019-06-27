<?php

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AmazingManController extends Controller
{
    /**
     * 获取音频权威课程
     *
     * @SWG\Get(path="/api/shop/daren/get_sound_posts",
     *   tags={"商城显示模块-达人"},
     *   summary="获取音频权威课程",
     *   description="获取音频权威课程,需要带上token参数后获取",
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
    public function getSoundPosts(Request $request)
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
       $soundPosts = app('commonRepo')->SoundPostRepo()->getAllCacheSoundPosts($skip,$take);
       return zcjy_callback_data($soundPosts);
    }

    /**
     * 获取音频权威课程详情
     *
     * @SWG\Get(path="/api/shop/daren/get_sound_post/{sound_post_id}",
     *   tags={"商城显示模块-达人"},
     *   summary="获取音频权威课程详情",
     *   description="获取音频权威课程详情,需要带上token令牌参数及课程id后获取",
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
     *     name="sound_post_id",
     *     type="integer",
     *     description="课程id",
     *     required=true,
     *   ),  
     *   @SWG\Parameter(
     *     in="query",
     *     name="kecheng",
     *     type="string",
     *     description="是否通过课程id获取",
     *     required=false,
     *   ),  
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回课程详情及课程小节",
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
    public function getSoundPostDetail(Request $request,$sound_post_id)
    {
        if($request->has('kecheng'))
        {
            // $kecheng = app('commonRepo')->middleLevelInfoRepo()->findWithoutFail($sound_post_id);
            // $sound_post_id = optional($kecheng->soundPost()->first())->id;
        }
        return app('commonRepo')->SoundPostRepo()->getCacheSoundPostDetail($sound_post_id,auth()->user());
    }



    /**
     * 保存音频观看记录,并且顺带获取课程额外积分
     *
     * @SWG\Get(path="/api/shop/daren/save_watch_sound_post_log/{id}",
     *   tags={"商城显示模块-达人"},
     *   summary="保存音频观看记录,并且顺带获取课程额外积分",
     *   description="保存音频观看记录,并且顺带获取课程额外积分,需要带上token令牌参数及课程id后获取",
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
     *     description="课程id",
     *     required=true,
     *   ),  
     *   @SWG\Parameter(
     *     in="query",
     *     name="last_see_time",
     *     type="string",
     *     description="观看时间",
     *     required=true,
     *   ),  
     *   @SWG\Parameter(
     *     in="query",
     *     name="whether_end",
     *     type="integer",
     *     description="是否观看完 没观看完传0观看完成传1",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回课程详情及课程小节",
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
    public function saveSoundPostWatchLog(Request $request,$id)
    {
        $input = $request->all();

        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'last_see_time,whether_end');

        #如果出现问题
        if($validator) 
        {
            return zcjy_callback_data($validator,1);
        }

        return app('commonRepo')->SoundPostRepo()->saveSoundPostWatchLog($id,auth()->user(),$input);
    }

    /**
     * 获取直播间列表
     *
     * @SWG\Get(path="/api/shop/daren/get_lives_room",
     *   tags={"商城显示模块-达人"},
     *   summary="获取直播间列表",
     *   description="获取直播间列表,需要带上token令牌参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回课程详情及课程小节",
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
    public function getLivesRoom(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->liveRepo()->allCached(auth()->user()));
    }

    /**
     * 获取直播间详情
     *
     * @SWG\Get(path="/api/shop/daren/get_live_room/{live_room_id}",
     *   tags={"商城显示模块-达人"},
     *   summary="获取直播间详情",
     *   description="获取直播间详情,需要带上token令牌参数后获取",
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
     *     name="live_room_id",
     *     type="integer",
     *     description="直播间房间号",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回课程详情及课程小节",
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
    public function getLiveRoomDetail(Request $request,$live_room_id)
    {
        return zcjy_callback_data(app('commonRepo')->liveRepo()->getById($live_room_id,auth()->user()));
    }

    /**
     * 获取所有黑科技文章
     *
     * @SWG\Get(path="/api/shop/daren/get_hkj_posts",
     *   tags={"商城显示模块-达人"},
     *   summary="获取所有黑科技文章",
     *   description="获取所有黑科技文章,需要带上token令牌参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回课程详情及课程小节",
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
    public function getHkjPosts(Request $request)
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
        $hkjs = app('commonRepo')->hkjRepo()->getHkj($skip,$take);
        return zcjy_callback_data($hkjs);
    }

    /**
     * 获取所有黑科技文章分类
     *
     * @SWG\Get(path="/api/shop/daren/get_hkj_cats",
     *   tags={"商城显示模块-达人"},
     *   summary="获取所有黑科技文章分类",
     *   description="获取所有黑科技文章分类,需要带上token令牌参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应黑科技文章列表",
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
    public function getHkjCats(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->hkjCatRepo()->CacheAll());
    }

    /**
     * 获取指定分类下的黑科技文章
     *
     * @SWG\Get(path="/api/shop/daren/get_cat_hkj_posts/{hkj_cat_id}",
     *   tags={"商城显示模块-达人"},
     *   summary="获取指定分类的黑科技文章",
     *   description="获取指定分类的黑科技文章,需要带上token令牌参数及文章分类id后获取",
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
     *     name="hkj_cat_id",
     *     type="integer",
     *     description="黑科技分类id",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应黑科技文章列表",
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
    public function getHkjPostsByCatId(Request $request,$hkj_cat_id)
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
        $hkjs = app('commonRepo')->hkjRepo()->getHkj($skip,$take,$hkj_cat_id);
        return zcjy_callback_data($hkjs);
    }

    /**
     * 获取黑科技文章详情
     *
     * @SWG\Get(path="/api/shop/daren/get_hkj_post_detail/{hkj_post_id}",
     *   tags={"商城显示模块-达人"},
     *   summary="获取黑科技文章详情",
     *   description="获取黑科技文章详情,需要带上token令牌参数及文章id后获取",
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
     *     name="hkj_post_id",
     *     type="integer",
     *     description="黑科技文章id",
     *     required=true,
     *   ),  
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应黑科技文章列表",
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
    public function getHkjPostDetail(Request $request,$hkj_post_id)
    {
        return app('commonRepo')->hkjRepo()->getHkjDetail($hkj_post_id,auth()->user());
    }

    /**
     * 获取所有达人
     *
     * @SWG\Get(path="/api/shop/daren/get_amazing_mans",
     *   tags={"商城显示模块-达人"},
     *   summary="获取所有达人",
     *   description="获取所有达人,需要带上token令牌参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应黑科技文章列表",
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
    public function getAllAmazingMan(Request $request)
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
        return zcjy_callback_data(app('commonRepo')->AmazingManRepo()->allMans($skip,$take));
    }

    /**
     * 获取达人详情
     *
     * @SWG\Get(path="/api/shop/daren/get_amazing_man/{amazing_man_id}",
     *   tags={"商城显示模块-达人"},
     *   summary="获取达人详情",
     *   description="获取达人详情,需要带上token令牌参数及达人id后获取",
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
     *     name="amazing_man_id",
     *     type="integer",
     *     description="达人id",
     *     required=true,
     *   ),   
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应达人详情及达人发布的黑科技文章和音频课程",
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
    public function getAmazingManDetail(Request $request,$amazing_man_id)
    {
        return app('commonRepo')->AmazingManRepo()->getAmazingManDetail($amazing_man_id);
    }


    /**
     * 获取音视频课程所有分类
     *
     * @SWG\Get(path="/api/shop/daren/get_kecheng_all_cats",
     *   tags={"商城显示模块-达人"},
     *   summary="获取音视频课程所有分类",
     *   description="获取音视频课程所有分类,需要带上token令牌参数及达人id后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回所有分类列表",
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
    public function getCacheAllCat(Request $request)
    {
        return zcjy_callback_data(app('commonRepo')->SoundPostCatRepo()->getCacheAllCat());
    }

    /**
     * 根据分类id获取课程列表
     *
     * @SWG\Get(path="/api/shop/daren/get_kechengs_by_catid/{cat_id}",
     *   tags={"商城显示模块-达人"},
     *   summary="根据分类id获取课程列表",
     *   description="根据分类id获取课程列表,需要带上token令牌参数后获取",
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
     *     description="分类id 可不传 传0或者不传获取所有",
     *     required=false,
     *   ), 
     *   @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="类型（音频,视频） 可不传 不传获取所有",
     *     required=false,
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应黑科技文章列表",
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
    public function getKechengsByCatId(Request $request,$cat_id)
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

      return zcjy_callback_data(app('commonRepo')->SoundPostCatRepo()->getKechengsByCatId($cat_id,auth()->user(),$request->get('type'),$skip,$take));
    }


    /**
     * 根据会员卡名称获取课程列表
     *
     * @SWG\Get(path="/api/shop/daren/get_kechengs_by_cardname",
     *   tags={"商城显示模块-达人"},
     *   summary="根据会员卡名称获取课程列表",
     *   description="根据会员卡名称获取课程列表,需要带上token令牌参数后获取",
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
     *     name="card_name",
     *     type="string",
     *     description="会员卡名称",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回对应黑科技文章列表",
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
    public function getKechengsByCardName(Request $request)
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

      return zcjy_callback_data(app('commonRepo')->SoundPostCatRepo()->getKechengsByCardName($request->get('card_name'),auth()->user(),$skip,$take));
    }




}
