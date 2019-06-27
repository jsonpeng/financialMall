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
Route::get('test',function(){
	$arrays = \Zcjy::paginateArray();
	// dd();
	//app('commonRepo')->autoCode();
});

//自动生成api文档
Route::group(['prefix' => 'swagger'], function () {
    Route::get('json', 'API\SwaggerController@getJSON');
  
});
//刷新缓存
Route::post('/clearCache','AppBaseController@clearCache');
//管理员
Route::group([ 'prefix' => 'zcjy'], function () {
	Route::get('login', 'Auth\AdminAuthController@showLoginForm');
	Route::post('login', 'Auth\AdminAuthController@login');
	Route::get('logout', 'Auth\AdminAuthController@logout');
});

Route::group(['middleware' => ['web', 'auth.admin'], 'prefix' => 'zcjy'], function () {
	//首页
	Route::get('/', 'HkjController@index');

	Route::get('/stat/tongji', 'TongjiController@index')->name('tongji.index');
	//文章分类
	Route::resource('categoriescat', 'CategoryController');
	//文章列表
	Route::resource('posts', 'PostController');
	//黑科技横幅
	Route::resource('hkjBanners', 'HkjBannerController');
	//黑科技
	Route::resource('hkjs', 'HkjController');
	//音频课程
	Route::resource('soundPosts', 'SoundPostController');
	//横幅
	Route::resource('banners', 'BannerController');
	//横幅详情
	Route::resource('{banner_id}/bannerItems', 'BannerItemController');
	//黑科技分类
	Route::resource('hkjCats', 'HkjCatController');
	//平台BANNER
	Route::resource('platformBanners', 'PlatformBannerController');
	//平台分类
	Route::resource('platFormCats', 'PlatFormCatController');
	//平台
	Route::resource('platForms', 'PlatFormController');
	//信用卡横幅
	Route::resource('creditCardBanners', 'CreditCardBannerController');
	//信用卡银行
	Route::resource('creditCardBanks', 'CreditCardBankController');
	//信用卡主题
	Route::resource('creditCardThemes', 'CreditCardThemeController');
	//信用卡
	Route::resource('creditCards', 'CreditCardController');
	//网站公告
	Route::resource('notices', 'NoticeController');

	Route::resource('xykIntros', 'XykIntroController');

	Route::resource('posIntros', 'PosIntroController');

	Route::resource('posApplies', 'PosApplyController');

	Route::resource('xykApplies', 'XykApplyController');

	Route::resource('advertorials', 'AdvertorialController');

	Route::resource('products', 'ProductController');

	//用户列表
	Route::get('/user_list', 'UserController@userList')->name('user.user_list');
	Route::get('/user_show/{id}', 'UserController@show')->name('user.show');
	Route::get('/user_create', 'UserController@create')->name('user.create');
	//更新用户积分记录
	Route::get('/user/{user_id}/update_credit', 'UserController@updateUserCredits')->name('user.update_credit');
	//修改会员等级
	Route::post('/user/{id}/update_level', 'UserController@updateUserLevel')->name('user.update_level');
	
	
	Route::post('/user/create', 'UserController@createAction')->name('user.createAction');
	//开通会员
	Route::get('/kaitonghuiyuan/{id}', 'UserController@kaitonghuiyuan');
	//开通分享资格
	Route::get('/kaitongfenxiang/{id}', 'UserController@kaitongfenxiang');
	//设置提成比例
	Route::get('/changeScale/{id}/{scale}', 'UserController@changeScale');
	//设置真实姓名
	Route::get('/changeName/{id}', 'UserController@changeName');
	///Route::get('/changeScale2/{id}/{scale}', 'UserController@changeScale2');
	//设置推荐
	Route::get('save_leader/{id}', 'UserController@setLeader');

	//会员购买记录
	Route::resource('memOrders', 'OrderController');
	//金额记录
	Route::resource('moneyRecords', 'MoneyRecordController');

	//服务协议
	Route::get('settings/service_protocal', 'SettingController@serviceProtocal');
	Route::get('settings/sale_protocal', 'SettingController@saleProtocal');
	//平台介绍
	Route::get('settings/intro', 'SettingController@intro');
	//客服设置
	Route::get('settings/kefu', 'SettingController@kefu');
	//首页语音
	Route::get('settings/index_voice', 'SettingController@indexVoice');
	//网站设置
	Route::resource('settings', 'SettingController');
	//会员卡设置
	Route::resource('products', 'ProductController');

	Route::resource('userLevels', 'UserLevelController');

	Route::resource('tools', 'ToolController');
	Route::resource('toolCats', 'ToolCatController');

	Route::resource('pages', 'PageController');

	Route::resource('advertorials', 'AdvertorialController');
	Route::resource('shareDks', 'ShareDkController');
	Route::resource('shareDkRecords', 'ShareDkRecordController');
	Route::resource('cashWithdraws', 'CashWithdrawController');
	Route::get('ajax/confirm_cash_withdraw/{id}', 'CashWithdrawController@confirmCashWithdraw'); 
	Route::get('ajax/confirm_cash_byhand/{id}', 'CashWithdrawController@confirmCashWithdrawByHand'); 
	Route::get('ajax/reject_cash_withdraw/{id}', 'CashWithdrawController@rejectCashWithdraw'); 

	//支付账号设置
	Route::resource('payAlis', 'PayAliController');

	//用户提交的表单
	Route::resource('submitForms', 'SubmitFormController');

	//中级课程
	Route::resource('middleLevelInfos', 'MiddleLevelInfoController');
	//高级课程
	Route::post('qiniu_file_upload', 'MiddleLevelInfoController@fileUpload'); 
	//特级课程
	Route::get('super_kecheng', 'PageController@superKecheng');
	//直播
	Route::resource('lives', 'LiveController');
	//试卷类型
	Route::resource('paperTypes', 'PaperTypeController');
	//试卷列表
	Route::resource('paperLists', 'PaperListController');
	//题目列表
	Route::resource('{paper_id}/topics', 'TopicsController');
	//题目选项
	Route::resource('{topic_id}/selectionsTopics', 'SelectionsTopicController');
	//考试记录
	Route::resource('testRecords', 'TestRecordsController');

	//修改黑科技的发布时间
	Route::get('ajax/refresh_hkj_date/{id}', 'HkjController@refreshHkjDate'); 

	Route::resource('gaobaos', 'GaobaoController');
	//申请攻略
	Route::resource('gonglues', 'GonglueController');
	//积分兑换
	Route::resource('jifenRecords', 'JifenRecordController');

	//达人管理
	Route::resource('amazingMen', 'AmazingManController');
	
	//会员等级管理
	Route::resource('levels', 'LevelController');
	//音频课程系列分类管理
	Route::resource('soundPostCats', 'SoundPostCatController');
	//反馈信息列表
	Route::resource('complaintLogs', 'ComplaintLogController');
});


//申请信息
Route::resource('submitInfoLogs', 'SubmitInfoLogController');