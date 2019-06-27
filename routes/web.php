<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Config;

//支付宝异步通知 购买会员成功
Route::any('/alipay/buy_mem/notify', 'Front\PayController@buyMemAliNotify');
Route::any('/alipay/buy_shop/notify', 'Front\PayController@buyShopAliNotify');

#游戏中心
Route::group(['prefix'=>'game'],function(){

	Route::group(['middleware' => 'api.auth'],function(){
		Route::get('login','Game\GameController@gameLogin');
	});

	#积分乐园
	Route::get('/tiger','Game\GameController@tiger');
	Route::post('/ajax/tiger','Game\GameController@tigerRun');
	Route::get('/spin','Game\GameController@spin');
	Route::post('/ajax/spin','Game\GameController@spinRun');
	Route::post('/ajax/spin_save_info/{spin_id}','Game\GameController@spinSaveInfo');
});

//推荐会员注册
Route::get('/invite_register', 'Front\MobileController@inviteRegister');

Route::group(['middleware' => ['web'], 'namespace' => 'Front'], function () {
	//贷款申请
	Route::get('/share_dk/view/{id}', 'ShareController@shareDkView');
	Route::post('/ajax/dk_apply/{id}', 'ShareController@ajaxDkApply');
	//第三发回调(微洽通)
	Route::any('/loan_callback', 'ShareController@loanCallback');
	Route::any('/xyk_callback', 'ShareController@xykCallback');
	//积分兑换回调
	Route::post('/jifen_callback', 'ShareController@jifenCallback');

	//信用卡申请
	Route::get('/share_xyk/view/{id}', 'ShareController@shareXykView');
	Route::post('/ajax/xyk_apply/{id}', 'ShareController@ajaxXykApply');
	//个人专属超贷
	Route::get('/share_personal/{id}', 'ShareController@sharePersonal');
	//发送短信验证码
	Route::get('/sendCode', 'MobileController@sendCode');
	Route::post('/post_register', 'MobileController@postRegister');
	//发送注册信息
	Route::post('/post_mobile', 'MobileController@postMobile');
});
Route::get('/app_download', 'Front\MobileController@appDownload');
//单个统计
Route::get('/stats', 'Front\IndexController@stats');

if (Config::get('zcjy.OPEN_WEB')) {

	// 首页
	Route::get('/', 'Front\IndexController@index');
	//统计
	Route::get('/stats', 'Front\IndexController@stats');
	//工具
	Route::get('/tools', 'Front\IndexController@tools');
	//金融工具
	Route::get('/tools/jinrong', 'Front\IndexController@toolsJinrong');
	//跳转页面
	Route::get('/jump', 'Front\IndexController@jump');
	//会员介绍
	Route::get('/mem_intro', 'Front\IndexController@mem_intro');
	//用户协议
	Route::get('/law', 'Front\IndexController@law');
	//支付成功
	Route::get('/pay_success', 'Front\IndexController@pay_success');
	//Route::get('/pay_failure', 'Front\IndexController@pay_success');

	//微信公众号支付
	Route::get('/buy_card', 'Front\PayController@buyCard');
	Route::any('/notify', 'Front\PayController@payNotify');
	//支付宝
	Route::get('/buy_card_alipay', 'Front\PayController@buyCardAlipay');

	Route::any('/alipay_return',  'Front\PayController@webReturn');
	//pays api
	Route::get('/pays_api', 'Front\PayController@paysApi');
	Route::any('/paysapi_return', 'Front\PayController@paysapiReturn');
	Route::any('/paysapi_notify', 'Front\PayController@paysapiNotify');

	//第三方佣金提现回调
	Route::any('/notify_3rd', 'Front\PayController@notify_3rd');
	Route::any('/tixian_notify_3rd', 'Front\PayController@tixian_notify_3rd');

	//授权
	Auth::routes();

	// 会员注册
	Route::get('/register', 'Front\MobileController@register');
	


	


	Route::get('/find_password', 'Front\MobileController@findPassword');
	Route::post('/post_find_password', 'Front\MobileController@postFindPassword');


	Route::group(['middleware' => ['web'], 'namespace' => 'Front'], function () {

		Route::get('/xyk_return_apply', 'ApplyController@xyk');
		Route::post('/api/save_xyk_apply', 'ApplyController@postXyk');

		Route::get('/pos_return_apply', 'ApplyController@pos');
		Route::post('/api/save_pos_apply', 'ApplyController@postPos');

		
		
		//网贷口子
		Route::get('/dk', 'DkController@index');
		Route::get('/dk/list/{range}/{type}', 'DkController@list');
		Route::get('/dk_cat/{id?}', 'DkController@cat');
		//Route::group(['middleware' => ['member']], function () {
			Route::get('/dk_detail/{id}', 'DkController@detail');
		//});

		Route::group(['middleware' => ['auth.user']], function () {

			//黑科技会员权限自己判断，不通过MIDDLEWARE
			Route::get('/hkj_detail/{id?}', 'HkjController@detail');

			//重置密码
			Route::get('/reset_password', 'MobileController@resetPassword');
			Route::post('/post_reset_password', 'MobileController@postResetPassword');

			//推广二维码
			Route::get('/share', 'UserController@share');
			Route::get('/erweima', 'UserController@erweima');
			//伙伴列表
			Route::get('/members', 'UserController@user_memebers');

			//银行卡
			Route::get('/bankcard', 'UserController@bankcard');
			Route::get('/bankcard/add', 'UserController@bankcard_add');
			Route::post('/bankcard/add', 'UserController@bankcard_store');
			Route::get('/bankcard/edit/{id}', 'UserController@bankcard_edit');
			Route::get('/bankcard/delete/{id}', 'UserController@bankcard_delete');
			Route::get('/bankcard/update/{id}', 'UserController@bankcard_update');		

			//用户中心
			Route::get('/user_center', 'UserController@userCenter');
			Route::get('/user_info', 'UserController@userInfo');
			Route::get('/wallet', 'UserController@wallet');
			Route::get('/face2face', 'UserController@face2face');
			Route::get('/advertorial', 'UserController@advertorial');
			Route::get('/cash_withdraw', 'UserController@cashWithdraw');
			Route::post('/ajax/post_withdraw', 'UserController@postWithdraw');
			Route::get('/income', 'UserController@income');
			//积分兑换记录
			Route::get('/xyk_jifen_records', 'UserController@xykJifenRecords');

			//购买会员
			Route::get('/member', 'IndexController@member');
			//分享版购买会员
			Route::group(['middleware' => ['wechat.oauth']], function () {
				Route::get('/member_buy_v2', 'IndexController@memberBuyV2');
			});
			
			//分化平台
			Route::get('/share_dks', 'ShareController@shareDks');
			Route::get('/share_common', 'ShareController@shareCommon');
			Route::get('/share_dk/{id}', 'ShareController@shareDk');
			Route::get('/share_dk/code/{id}', 'ShareController@shareDkCode');

			//中级会员
			Route::get('/middle_level', 'MemberLevelController@middleLevel');
			Route::get('/kecheng_detail/{id}', 'MemberLevelController@kechengDetail');
			//高级会员
			Route::get('/high_level', 'MemberLevelController@highLevel');
			//特级会员
			Route::get('/super_level', 'MemberLevelController@superLevel');

			Route::get('/all_level', 'MemberLevelController@allLevel');

			//学习
			Route::get('/learn', 'MemberLevelController@index');

			//直播
			Route::get('lives', 'IndexController@live');
			Route::get('live/{id}', 'IndexController@liveDetail');

			//考试库
			Route::get('kaoshis', 'KaoshiController@index');
			Route::get('kaoshi/{id}', 'KaoshiController@papers');
			Route::get('question/{id}', 'KaoshiController@question');
			Route::get('ajax_question/{id}', 'KaoshiController@ajaxQuestion');
			Route::get('ajax_store_record', 'KaoshiController@ajaxStoreRecord');
			Route::get('kaoshi_records', 'KaoshiController@records');

			//积分兑换
			Route::get('xyk_jifen', 'JifenController@index');
			Route::get('bankList', 'JifenController@bankList');
			Route::get('price/{id}', 'JifenController@price');
			Route::get('gifts/{id}', 'JifenController@gifts');
			Route::get('gift_detail/{id}', 'JifenController@giftDetail');
			Route::get('ajax/gifts/{id}', 'JifenController@postGifts');
			Route::get('baodan/{id}', 'JifenController@baodan');
			Route::post('ajax/gift_apply', 'JifenController@giftApply');

			//上传图片
			Route::post('ajax/upload_images','JifenController@uploadImage');
		});
		
	
		
		//提现
		/*
		Route::get('/tixian', 'UserController@tixian');
		Route::get('/tixian/shenqing', 'UserController@tixian_shenqing');
		Route::post('/tixian/shenqing', 'UserController@tixian_shenqing_post');
		Route::get('/tixian/detail/{id}', 'UserController@tixian_detail');
		*/
		//客服
		Route::get('/kefu', 'UserController@kefu');
		
		//文章分类
		Route::get('/category/{id}', 'CategoryController@index');
		//文章详情
		Route::get('/post/{id}', 'CategoryController@post');
		//黑科技首页
		Route::get('/hkj', 'HkjController@index');
		Route::get('/hkj_cat/{id?}', 'HkjController@cat');
		
		//信用卡
		Route::get('/xyk', 'XykController@index');
		Route::get('/xyk_bank/{id}', 'XykController@bank');
		Route::get('/xyk_theme/{id}', 'XykController@theme');
		
		//第三方支付购买会员
		Route::get('/buy_card_third', 'PayController@buyCardThird');
		//余额不足提示
		Route::get('/yue', 'IndexController@yue');
		
		//公告
		Route::get('/notice/{id}', 'NoticeController@show');
		//最近购买用户
		Route::get('/members_justnow', 'IndexController@members_justnow');

		//用户留资料表格
		Route::get('/apply/dk', 'IndexController@showDkForm');
		Route::post('/submit_info', 'IndexController@ajaxSubmitInfo');
	});
}else{
	//推荐会员注册
	// Route::get('/', 'Front\MobileController@appDownload');
	// Route::get('/invite_register', 'Front\MobileController@inviteRegister');
	// //发送短信验证码
	// Route::get('/sendCode', 'Front\MobileController@sendCode');
	// Route::post('/post_mobile', 'Front\MobileController@postMobile');
	// Route::post('/post_register', 'Front\MobileController@postRegister');
	// Route::get('/app_download', 'Front\MobileController@appDownload');
	// Route::any('/alipay_notify',  'Front\PayController@webNotify');
	// Route::any('/alipay_return',  'Front\PayController@webReturn');
}

//Route::get('submits', 'SubmitInfoLogController@front');



// Route::resource('productLevelPrices', 'ProductLevelPriceController');



// Route::resource('levelSounds', 'LevelSoundController');



// Route::resource('amazingManPosts', 'AmazingManPostController');

// Route::resource('attachUserLevels', 'AttachUserLevelController');

// Route::resource('userPosts', 'UserPostController');



// Route::resource('soundPostUserLogs', 'SoundPostUserLogController');

