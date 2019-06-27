<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

// Route::group(['middleware' => ['api']], function () {
// 		//发送短信验证码
// 	//Route::get('/sendCode', 'MobileController@sendCode');
// });


$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    $api->get('login', 'App\Http\Controllers\API\AuthController@login');
  	$api->post('sms', 'App\Http\Controllers\API\AuthController@sms');
  	$api->post('register', 'App\Http\Controllers\API\AuthController@register');
  	$api->post('resetpassword', 'App\Http\Controllers\API\AuthController@resetpassword');

	//黑科技列表
    $api->get('hkj_cats', 'App\Http\Controllers\API\HkjController@cats');
    $api->get('hkj_list', 'App\Http\Controllers\API\HkjController@list');
    $api->get('post_list', 'App\Http\Controllers\API\PostController@list');
    $api->get('banners', 'App\Http\Controllers\API\HkjController@banners');
    //黑科技搜索
    $api->get('hkj_search', 'App\Http\Controllers\API\HkjController@hkjSearch');
    //文章分类
    $api->get('categories', 'App\Http\Controllers\API\CategoryController@categories');
    $api->get('cat/{id}', 'App\Http\Controllers\API\PostController@postsOfCat');
    $api->get('post/{id}', 'App\Http\Controllers\API\PostController@post');

    $api->get('mem_intro', 'App\Http\Controllers\API\MemberController@intro');

    //平台信息
    $api->get('platform_cats', 'App\Http\Controllers\API\PlatformController@platformCats');
    // 老板
    $api->get('platforms', 'App\Http\Controllers\API\PlatformController@getPlatformByCat');
    $api->get('platform/{id}', 'App\Http\Controllers\API\PlatformController@getPlatform');
    $api->get('platform_banners', 'App\Http\Controllers\API\PlatformController@banners');
    #新版
    $api->get('platforms_by_cat', 'App\Http\Controllers\API\PlatformController@getPlatformByCatNew');
    //根据额度和类型获取平台
    $api->get('platforms_filter', 'App\Http\Controllers\API\PlatformController@getPlatformByFilter');

    //信用卡接口
    $api->get('xyk_banners', 'App\Http\Controllers\API\XykController@xykBanners');
    $api->get('xyk_banks', 'App\Http\Controllers\API\XykController@xykBanks');
    $api->get('xyk_themes', 'App\Http\Controllers\API\XykController@xykThemes');
    $api->get('xyk_cards', 'App\Http\Controllers\API\XykController@creditCards');
    //信用卡新接口
    $api->get('xyk_new', 'App\Http\Controllers\API\XykController@newCards');

    //POS机申请
    $api->get('pos', 'App\Http\Controllers\API\PostController@pos');
    $api->post('postPos', 'App\Http\Controllers\API\PostController@postPos');
    //信用卡代还
    $api->get('xyk_return', 'App\Http\Controllers\API\PostController@xyk');
    $api->post('postXyk', 'App\Http\Controllers\API\PostController@postXyk');
    //贷款申请
    $api->post('apply_dk', 'App\Http\Controllers\API\PostController@applyDk');
    //用户服务协议
    $api->get('setting', 'App\Http\Controllers\API\MemberController@setting');

    //工具
    $api->get('tools', 'App\Http\Controllers\API\ToolController@tools');
    $api->get('tools_withcat', 'App\Http\Controllers\API\ToolController@toolsByCat');

    //通知消息
    $api->get('notices', 'App\Http\Controllers\API\NoticeController@index');
    $api->get('notice/{id}', 'App\Http\Controllers\API\NoticeController@show');

    //课程列表
    $api->get('kecheng', 'App\Http\Controllers\API\PostController@kechengs');
    $api->get('kecheng/{id}', 'App\Http\Controllers\API\PostController@kecheng');
    $api->get('page', 'App\Http\Controllers\API\PostController@page');

    //直播
    $api->get('lives', 'App\Http\Controllers\API\LiveController@lives');
    $api->get('live_detail/{id}', 'App\Http\Controllers\API\LiveController@live');

    //攻略
    $api->get('gonglues', 'App\Http\Controllers\API\GonglueController@list');

    //需要登录才可以看
	$api->group(['middleware' => 'api.auth'], function ($api) {
        
        /**
         * 考试接口
         */
        $api->group(['prefix' => 'paper'], function ($api) {
             //所有题库分类列表
             $api->get('types_all', 'App\Http\Controllers\API\PaperController@allTypes');
             //根据题库分类id获取对应试卷列表
             $api->get('list_all/{paper_type_id?}','App\Http\Controllers\API\PaperController@allLists');
             //根据试卷id获取对应的题目
             $api->get('topic/{paper_id}','App\Http\Controllers\API\PaperController@paperTopics');
             //存储考试记录
             $api->get('store_record','App\Http\Controllers\API\PaperController@testRecordsStore');
             //对应用户的考试记录
             $api->get('auth_records/{paper_type_id?}','App\Http\Controllers\API\PaperController@testRecordsList');
        });
        
	    $api->post('logout', 'App\Http\Controllers\API\AuthController@logout');
	    
	    $api->post('refresh', 'App\Http\Controllers\API\AuthController@refresh');
	    $api->get('me', 'App\Http\Controllers\API\AuthController@me');

	    //黑科技
	    $api->get('hkj_detail/{id}', 'App\Http\Controllers\API\HkjController@hkjDetail');
	    $api->get('payBuyAlipay', 'App\Http\Controllers\API\MemberController@payBuyAlipay');

        //攻略
        $api->get('gonglue/{id}', 'App\Http\Controllers\API\GonglueController@detail');

	      //会员卡信息
	      $api->get('user_levels', 'App\Http\Controllers\API\MemberController@userLevels');

      
     
 
        //分享二维码
        $api->get('erweima', 'App\Http\Controllers\API\MemberController@erweima');
        //推广软文
        $api->get('advertorial', 'App\Http\Controllers\API\PostController@advertorial');
        //马上贷
        $api->get('xyk_list', 'App\Http\Controllers\API\ShareController@xyk_list');
        //马上贷产品详情
        $api->get('share_product/{id}', 'App\Http\Controllers\API\ShareController@product');
        //马上贷产品二维码
        $api->get('product_erweima/{id}', 'App\Http\Controllers\API\ShareController@productErweima');
       

        //高爆口子
        $api->get('gaobao_list', 'App\Http\Controllers\API\GaobaoController@index');

        //积分兑换
        $api->get('bankList', 'App\Http\Controllers\API\JifenController@bankList');
        $api->get('price/{id}', 'App\Http\Controllers\API\JifenController@price');
        $api->get('gift_detail/{id}', 'App\Http\Controllers\API\JifenController@giftDetail');
        $api->get('gifts/{id}', 'App\Http\Controllers\API\JifenController@postGifts');
        $api->get('jife_records', 'App\Http\Controllers\API\JifenController@jifenRecords');
        $api->post('gift_apply', 'App\Http\Controllers\API\JifenController@giftApply');

      

    });

    //提交申请信息
    $api->get('submit_info','App\Http\Controllers\API\XykController@submitInfo');


    /**
     * 商城接口
     */
    $api->group(['prefix' => 'shop'], function ($api) {

        //商城显示接口
        $api->group(['middleware' => 'api.auth'], function ($api) {
            ##分类常用接口
            $api->get('get_toptwolevel_cats','App\Http\Controllers\Shop\API\ShopController@getTopTwoLevelCategories');

            ##获取分类下的商品不带上子分类
            $api->get('get_cat_products/{cat_id}','App\Http\Controllers\Shop\API\ShopController@getProductsOfCat');

            ##获取分类下的商品并且带上子分类
            $api->get('get_cat_products_with_children/{cat_id}','App\Http\Controllers\Shop\API\ShopController@getProductsOfCatWithChildren');
        });

        /**
         * 商城支付接口
         */
        $api->group(['prefix'=>'pay','middleware'=>'api.auth'],function($api){
            /**
             * 支付宝支付相关
             */
            $api->group(['prefix'=>'alipay'],function($api){
                  #买会员卡
                  $api->get('buy_member','App\Http\Controllers\Shop\API\PayController@alipayBuyMemeber');
                  #商城下单
                  $api->get('buy_shop','App\Http\Controllers\Shop\API\PayController@alipayGenerateOrderToPay');
                  ##发起订单支付根据订单id-支付宝
                  $api->get('pay_order/{order_id}','App\Http\Controllers\Shop\API\PayController@payNowOrder');
                  
            });
            //alipayBuyMemeber
        });

        /**
         * 常用用户接口
         */
        $api->group(['prefix'=>'user'],function($api){

            ##发送短信验证码
            $api->get('send_code','App\Http\Controllers\Shop\API\AuthController@sendMobileCodeAction');

            ##用户重置密码
            $api->get('resetpwd','App\Http\Controllers\Shop\API\AuthController@resetPassword');
            //resetPassword

            ##用户注册
            $api->get('register','App\Http\Controllers\Shop\API\AuthController@register');

            ##用户登录
            $api->get('login','App\Http\Controllers\Shop\API\AuthController@login');

            //需要登录才可以看
            $api->group(['middleware' => 'api.auth'], function ($api) {
                ##退出登录
                $api->post('logout','App\Http\Controllers\Shop\API\AuthController@logout');

                ##获取用户信息
                $api->get('meinfo','App\Http\Controllers\Shop\API\AuthController@me');

                ##商城用户个人信息更新updateMeInfo
                $api->get('update_info','App\Http\Controllers\Shop\API\AuthController@updateMeInfo');
            });
            
        });

        /**
         * 商城显示模块-会员
         */
          $api->group(['prefix'=>'member'],function($api){

                //需要登录才可以看
                $api->group(['middleware' => 'api.auth'], function ($api) {

                    ##获取会员分类
                    $api->get('get_cats','App\Http\Controllers\Shop\API\MemberController@getMemberCats');

                    ##获取积分兑换商品
                    $api->get('credit_products','App\Http\Controllers\Shop\API\MemberController@getCreditProducts');

                    ##获取爆款推荐商品
                    $api->get('rec_products','App\Http\Controllers\Shop\API\MemberController@getRecProducts'); 

                    ##获取商品详情
                    $api->get('product/{product_id}','App\Http\Controllers\Shop\API\MemberController@getProduct');

                    ##收藏操作商品(收藏及取消收藏) 
                    $api->get('product_action_collect/{product_id}','App\Http\Controllers\Shop\API\MemberController@actionCollectStatus');

                    ##获取猜你喜欢的商品列表 
                    $api->get('product_fav/{product_id}','App\Http\Controllers\Shop\API\MemberController@getFavProduct');
                    //product_fav

                    ##获取购物车列表信息
                    $api->get('carts','App\Http\Controllers\Shop\API\MemberController@getCarts'); 

                    ##添加购物车 
                    $api->get('add_cart','App\Http\Controllers\Shop\API\MemberController@addCart');

                    ##更新购物车 
                    $api->get('update_cart','App\Http\Controllers\Shop\API\MemberController@updateCart');

                    ##删除购物车 
                    $api->get('delete_cart','App\Http\Controllers\Shop\API\MemberController@deleteCart');

                    ##获取结算信息
                    $api->get('get_checkinfo','App\Http\Controllers\Shop\API\MemberController@getCheckInfo'); 

                    ##获取收货地址列表
                    $api->get('get_address','App\Http\Controllers\Shop\API\MemberController@getAddress'); 
                    
                    ##添加新收货地址
                    $api->get('add_address','App\Http\Controllers\Shop\API\MemberController@addAddress');
                
                    ##编辑保存新收货地址
                    $api->get('update_address/{address_id}','App\Http\Controllers\Shop\API\MemberController@updateAddress');

                    ##删除收货地址
                    $api->get('delete_address/{address_id}','App\Http\Controllers\Shop\API\MemberController@deleteAddress');
                });
          

          });

          /**
           * 商城显示模块-信用生活
           */
          $api->group(['prefix'=>'xinyong','middleware'=>'api.auth'],function($api){
             
              //获取贷款超市分类
              $api->get('get_platform_cats','App\Http\Controllers\Shop\API\XingYongController@getPlatformCats');

              //获取指定分类下的贷款 getCatPlatformsDk
              $api->get('get_cat_platforms_dk/{cat_id}','App\Http\Controllers\Shop\API\XingYongController@getCatPlatformsDk');

              //获取所有信用卡银行
              $api->get('get_xyk_banks','App\Http\Controllers\Shop\API\XingYongController@getXykBanks');

              //获取所有信用卡银行
              $api->get('get_bank_xyks/{bank_id?}','App\Http\Controllers\Shop\API\XingYongController@getBankXyks');

              //获取所有工具分类并且带上工具get_toolcats_withtools
              $api->get('get_toolcats_withtools','App\Http\Controllers\Shop\API\XingYongController@getToolCatsWithTools');

              //根绝工具分类别名获取工具列表get_tools_by_slug/{slug}
              $api->get('get_tools_by_slug/{slug}','App\Http\Controllers\Shop\API\XingYongController@getToolsBySlug');

              //获取所有的贷款 
              $api->get('get_all_platforms_dk','App\Http\Controllers\Shop\API\XingYongController@getAllPlatformsDk');
          });

          /**
           * 商城显示模块-常用功能
           */
          $api->group(['prefix'=>'func','middleware'=>'api.auth'],function($api){

              //获取系统配置项
              $api->get('get_set_list','App\Http\Controllers\Shop\API\CommonController@getSetList');

              $api->get('get_set/{name}','App\Http\Controllers\Shop\API\CommonController@getSetObj');


              //获取指定横幅 getBanners
              $api->get('get_banners/{slug?}','App\Http\Controllers\Shop\API\CommonController@getBanners');

              //获取所有通知消息
              $api->get('get_notices','App\Http\Controllers\Shop\API\CommonController@getAllNotices');

              //查找商品
              $api->get('find_products','App\Http\Controllers\Shop\API\CommonController@findProducts');

              //文章搜索searchPosts
              $api->get('search_posts','App\Http\Controllers\Shop\API\CommonController@searchPosts');

              //文章收藏操作actionCollectPost
               $api->get('action_collect_post','App\Http\Controllers\Shop\API\CommonController@actionCollectPost');

               //用户收藏的文章列表userCollectPosts
               $api->get('user_collect_posts','App\Http\Controllers\Shop\API\CommonController@userCollectPosts');

               //文件上传
               $api->post('upload','App\Http\Controllers\Shop\API\CommonController@uploadFile');

               //获取第一级城市列表
               $api->get('get_basic_cities','App\Http\Controllers\Shop\API\CommonController@getBasicLevelCities');

               //根据城市id获取子列表
               $api->get('get_child_cities/{id}','App\Http\Controllers\Shop\API\CommonController@getChildCitiesById');

               //推广软文
              $api->get('get_advertorial', 'App\Http\Controllers\Shop\API\CommonController@advertorial');
  
          });


          /**
           * 商城显示模块-达人
           */
          $api->group(['prefix'=>'daren','middleware' => 'api.auth'],function($api){

                  ##获取音频权威课程
                  $api->get('get_sound_posts','App\Http\Controllers\Shop\API\AmazingManController@getSoundPosts');

                  ##获取音频课程详情
                  $api->get('get_sound_post/{sound_post_id}','App\Http\Controllers\Shop\API\AmazingManController@getSoundPostDetail');

                  ##保存音频观看记录,并且顺带获取课程额外积分
                  $api->get('save_watch_sound_post_log/{id}','App\Http\Controllers\Shop\API\AmazingManController@saveSoundPostWatchLog');
                
                  ##获取所有直播间列表
                  $api->get('get_lives_room','App\Http\Controllers\Shop\API\AmazingManController@getLivesRoom');

                  ##获取直播间详情
                  $api->get('get_live_room/{live_room_id}','App\Http\Controllers\Shop\API\AmazingManController@getLiveRoomDetail');

                  ##获取所有黑科技文章
                  $api->get('get_hkj_posts','App\Http\Controllers\Shop\API\AmazingManController@getHkjPosts');

                  ##获取所有黑科技文章分类
                  $api->get('get_hkj_cats','App\Http\Controllers\Shop\API\AmazingManController@getHkjCats');

                  ##获取指定分类的黑科技文章
                  $api->get('get_cat_hkj_posts/{hkj_cat_id}','App\Http\Controllers\Shop\API\AmazingManController@getHkjPostsByCatId');
                  
                  ##获取黑科技文章详情
                  $api->get('get_hkj_post_detail/{hkj_post_id}','App\Http\Controllers\Shop\API\AmazingManController@getHkjPostDetail');

                  ##获取所有达人
                  $api->get('get_amazing_mans','App\Http\Controllers\Shop\API\AmazingManController@getAllAmazingMan');

                  ##获取达人详情
                  $api->get('get_amazing_man/{amazing_man_id}','App\Http\Controllers\Shop\API\AmazingManController@getAmazingManDetail');

                  ##获取音视频课程所有分类
                  $api->get('get_kecheng_all_cats','App\Http\Controllers\Shop\API\AmazingManController@getCacheAllCat');

                  ##根据分类id获取课程列表 get_kechengs_by_catid/{cat_id} getKechengsByCatId
                  $api->get('get_kechengs_by_catid/{cat_id}','App\Http\Controllers\Shop\API\AmazingManController@getKechengsByCatId');

                  ##根据会员卡名称获取课程列表 get_kechengs_by_catid/{cat_id} getKechengsByCatId
                  $api->get('get_kechengs_by_cardname','App\Http\Controllers\Shop\API\AmazingManController@getKechengsByCardName');

          });

          /**
           * 商城显示模块-我的
           */
            $api->group(['prefix'=>'myself','middleware' => 'api.auth'],function($api){

                ##获取订单记录
                $api->get('get_orders/{type}','App\Http\Controllers\Shop\API\UserController@getMyordersOfType');
                
                ##获取我的收藏商品列表 get_collect_products productListCollect
                $api->get('get_collect_products','App\Http\Controllers\Shop\API\UserController@productListCollect');

                ##获取订单详情
                $api->get('get_order/{id}','App\Http\Controllers\Shop\API\UserController@getOrderDetail');

                ## 取消订单 cancelOrderAction
                $api->get('cancle_order/{id}','App\Http\Controllers\Shop\API\UserController@cancelOrderAction');

                ## 发起订单商品评价 evalPublish
                $api->post('topic_order','App\Http\Controllers\Shop\API\UserController@evalPublish');
                ## 获取我的积分记录 creditLogs
                $api->get('get_credits_log','App\Http\Controllers\Shop\API\UserController@creditLogs');



                ##订单确认收货 order_confirm/{order_id} enterOrder
                $api->get('order_confirm/{order_id}', 'App\Http\Controllers\Shop\API\UserController@enterOrder');

                ##查找订单物流 order_search_wuliu/{order_id} enterOrder
                $api->get('order_search_wuliu/{order_id}', 'App\Http\Controllers\Shop\API\UserController@searchOrderKuaiDi');

                ##订单提醒发货
                $api->get('order_notify/{order_id}', 'App\Http\Controllers\Shop\API\UserController@orderNotify');

                 ##设置安全码 
                $api->get('set_safe_code', 'App\Http\Controllers\Shop\API\UserController@setSafaCode');

                ##设置支付宝账号 set_alipay_count setSafaCode
                $api->get('set_alipay_count', 'App\Http\Controllers\Shop\API\UserController@setAlipayAccount');


                //用户的余额
                $api->get('user_money', 'App\Http\Controllers\API\MemberController@userMoney');
                //收入
                $api->get('income', 'App\Http\Controllers\API\MemberController@income');
                //提现记录
                $api->get('withdraw', 'App\Http\Controllers\API\MemberController@withdraw');
                //提现申请
                $api->post('withdraw', 'App\Http\Controllers\API\MemberController@postWithdraw');
                //面对面开通账号
                $api->post('registerF2F', 'App\Http\Controllers\API\AuthController@registerF2F');
                 //个人推广二维码
                $api->get('product_personal', 'App\Http\Controllers\API\ShareController@personalShare');
                //我的代理
                //用户推荐的人
                $api->get('my_members', 'App\Http\Controllers\API\MemberController@myMembers');

            });
          //myself/get_orders/{type}
          //getMyordersOfType
          
          /**
           * 商城显示模块-马上贷
           */
           $api->group(['prefix'=>'mashang','middleware' => 'api.auth'],function($api){
              ##马上贷
              $api->get('xyk_list', 'App\Http\Controllers\Shop\API\MaShangController@xyk_list');
              ##马上贷产品详情
              $api->get('share_product/{id}', 'App\Http\Controllers\Shop\API\MaShangController@product');
              ##马上贷产品二维码
              $api->get('product_erweima/{id}', 'App\Http\Controllers\Shop\API\MaShangController@productErweima');
                //个人专属二维码 
              $api->get('my_personal_erweima', 'App\Http\Controllers\API\ShareController@getPersonalShare');
             /**
              * 信用卡积分兑换
              */
              $api->get('bankList', 'App\Http\Controllers\Shop\API\JifenController@bankList');
              $api->get('price/{id}', 'App\Http\Controllers\Shop\API\JifenController@price');
              $api->get('gift_detail/{tagId}', 'App\Http\Controllers\Shop\API\JifenController@tagDetail');
              $api->get('gifts/{id}', 'App\Http\Controllers\Shop\API\JifenController@postGifts');
              $api->get('jife_records', 'App\Http\Controllers\Shop\API\JifenController@jifenRecords');
              $api->post('gift_apply', 'App\Http\Controllers\Shop\API\JifenController@giftApply');
            });

           /**
            * 游戏常用接口
            */
              $api->group(['prefix'=>'game','middleware' => 'api.auth'],function($api){

                  $api->get('login', 'App\Http\Controllers\Game\GameController@gameLogin');
                

              });

        /**
         * 反馈管理
         */
        $api->group(['prefix'=>'fankui','middleware' => 'api.auth'], function ($api) {

            ##保存反馈记录 save_log saveLog
            $api->get('save_log','App\Http\Controllers\Shop\API\FanKuiController@saveLog');
            
        });
    });

});

