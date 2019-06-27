<?php

use Illuminate\Support\Facades\Config;


//地图
Route::get('map','Shop\SettingController@map');

// Route::get('403',function(){
//    return view('errors.403');
// });


Route::post('/zcjy/cities/getAjaxSelect/{id}','Shop\CitiesController@CitiesAjaxSelect');



Route::group([ 'middleware' => ['auth.admin:admin'], 'prefix' => 'shop', 'namespace' => 'Shop'], function () {

	Route::get('/', 'OrderController@index');

	/**
	 * ajax操作
	 */
	Route::group([ 'prefix' => 'ajax' ], function () {
		//积分修改
		Route::post('/user/{user_id}/credits_change','UserController@updateUserCredits');
		//余额修改
		Route::post('/user/{user_id}/money_change','UserController@updateUserMoney');
		//主题颜色设置
	    Route::post('/set_theme_color', 'SettingController@postThemeSetting');
	    //根据城市id返回对应的运费模板信息
	    Route::get('/getfreighttem/cid/{cid}','CitiesController@GetFreightTemByCid');
	    //文章额外字段设置
	    Route::post('/wordset/{id}','ProductController@wordsListUpdate');
	    //为当前管理员赋予权限
	    Route::post('/perm/{id}/add','PermissionsController@addPermToAdmin');
	    //为当前管理员移除权限
	    Route::post('/perm/{id}/del','PermissionsController@delPermToAdmin');
	    //冻结用户
	    Route::post('/freezeuser/{userid}','UserController@freezeUserById');
	    //操作分销资格
	    Route::post('/distributeUser/{userid}','UserController@distributeUser');
	    //图片上传
	    Route::post('/uploads','AjaxController@uploadImage');
	    //发送通知消息
	    Route::get('/send_notices','AjaxController@sendNotices');
	});



	//店铺管理
	Route::resource('stores', 'StoreController');


	//查找分类信息
    Route::get('categories/searchCatsFrame','CategoryController@searchCatsFrame');
    
	//产品分类
	Route::resource('categories', 'CategoryController');
	Route::get('childCategories/{parent_id}', 'CategoryController@categoriesOfParent'); 
	//产品模型
	Route::resource('productTypes', 'ProductTypeController');
	//产品规格
	Route::resource('specs', 'SpecController');
	//商品属性
	Route::resource('productAttrs', 'ProductAttrController');
	//产品品牌查找
	Route::get('brands/iframe','BrandController@iframe');
	//产品品牌
	Route::resource('brands', 'BrandController');
	//产品管理
	Route::get('products/ajaxGetSpecSelect', 'ProductController@ajaxGetSpecSelect');
    //allLowGoods
    //商品库存报警列表
    Route::get('all_products/allLowGoods','ProductController@allLowGoods')->name('products.alllow');
    //获取商品规格组合列表
    Route::post('products/ajaxGetProductList','ProductController@ajaxGetProductList');
    //根据商品id获取商品信息
    Route::post('products/getSingleProductById/{id}','ProductController@getSingleProductById');
    //商品附加信息列表
    Route::get('word_products','ProductController@wordsList')->name('wordlist.index');
    Route::get('word_products/add','ProductController@wordsListAdd')->name('wordlist.create');
    Route::post('word_products/add','ProductController@wordsListStore')->name('wordlist.store');
    Route::post('word_products/delete/{id}','ProductController@wordsListDestroy')->name('wordlist.destroy');

    //查找商品信息
    Route::get('products/searchGoodsFrame','ProductController@searchGoodsFrame');
    

	Route::post('products/ajaxGetSpecInput/{product_id}', 'ProductController@ajaxGetSpecInput'); 
	Route::get('products/ajaxGetAttrInput', 'ProductController@ajaxGetAttrInput'); 
	Route::post('products/ajaxSaveTypeAttr/{product_id}', 'ProductController@ajaxSaveTypeAttr');
	Route::post('products/ajaxDelSpecInputByKey', 'ProductController@ajaxDelSpecInputByKey');
	
	Route::resource('products', 'ProductController');
	Route::resource('productImages', 'ProductImageController');
	//订单管理
    //订单中加入商品
    Route::get('/order/print/{id}','OrderController@print');
    Route::post('orders/addProductList','OrderController@addProductList');
    Route::post('orders/delProductList/{item_id}','OrderController@delProductList');
    Route::get('orders/{id}/delete','OrderController@deleteOrder');
	Route::get('orders/{id}/print', 'OrderController@printOrder'); 
	Route::get('orders/{id}/tripperprint', 'OrderController@tripperprintOrder')->name('order.print');

    Route::post('orders/{order_id}/report', 'OrderController@reportOrder')->name('order.report');
    //reportOrderToMany
    Route::post('orders/reportMany', 'OrderController@reportOrderToMany')->name('order.report.many');

	Route::resource('orders', 'OrderController');
	Route::resource('orderActions', 'OrderActionController'); //订单操作记录
	Route::resource('orderCancels', 'OrderCancelController'); //取消订单
	Route::resource('refundMoneys', 'RefundMoneyController'); // 退款信息查询

	Route::get('refunds/{id}/update','OrderRefundController@getUpdate');
	Route::resource('orderRefunds', 'OrderRefundController'); //退换货
	//订单商品
	Route::resource('items', 'ItemController');

	//统计信息
	Route::get('statics', 'StatController@index')->name('stat.index');
	Route::post('report', 'StatController@report')->name('stat.report');


	Route::resource('themes', 'ThemeController');

	//商城设置
	Route::get('settings/system', 'SettingController@system')->name('settings.system');
	Route::get('settings/setting', 'SettingController@setting')->name('settings.setting');
	Route::post('settings/setting', 'SettingController@update')->name('settings.setting.update');
	Route::get('settings/themeSetting', 'SettingController@themeSetting')->name('settings.themeSetting');
	Route::get('settings/themeSetting/{theme}', 'SettingController@themeSettingActive')->name('settings.themeSettingActive');
	

	// 三级分销
	Route::get('distributions/stats', 'DistributionController@stats')->name('distributions.stats');
	Route::get('distributions/lists', 'DistributionController@lists')->name('distributions.lists');
	Route::get('distributions/settings', 'DistributionController@settings')->name('distributions.settings');

	//分销分佣记录
	Route::resource('distributionLogs', 'DistributionLogController');

	//优惠券
	Route::get('coupons/given', 'CouponController@given')->name('coupons.given');
    Route::post('coupons/given', 'CouponController@postGiven');
    //用户列表
    Route::get('/frame/givenUserList','CouponController@givenUserList');

	Route::get('coupons/given_integer', 'CouponController@givenInteger')->name('coupons.integer');
	Route::post('coupons/given_integer', 'CouponController@postGivenInteger');
	Route::get('coupons/stats', 'CouponController@stats')->name('coupons.stats');
	Route::resource('coupons', 'CouponController');
	Route::resource('couponRules', 'CouponRuleController');

    Route::get('Promps/pageSet','ProductPrompController@prompPageSetView')->name('promps.pageset');
    Route::post('Promps/pageSetApi','ProductPrompController@prompPageSetApi')->name('promps.pageset.update');
	//产品促销
	Route::resource('productPromps', 'ProductPrompController');
	//订单促销
	Route::resource('orderPromps', 'OrderPrompController');
	//秒杀
	Route::resource('flashSales', 'FlashSaleController');
	//拼团列表
	Route::resource('teamSales', 'TeamSaleController');
	Route::resource('teamFounds', 'TeamFoundController');
	Route::resource('teamFollows', 'TeamFollowController');
	Route::resource('teamLotteries', 'TeamLotteryController');
	//团购列表
	Route::resource('groupSales', 'GroupSaleController');
    //银行卡设置
    Route::resource('bankSets', 'BankSetsController');
    //地区设置
    Route::resource('cities','CitiesController');
    //运费模板
    Route::resource('freightTems', 'FreightTemController');
    //根据pid查看到地区列表
    Route::get('cities/pid/{pid}','CitiesController@ChildList')->name('cities.child.index');
    //为指定父级城市添加地区页面
    Route::get('cities/pid/{pid}/add','CitiesController@ChildCreate')->name('cities.child.create');
    //省市区三级选择
    Route::get('cities/frame/select','CitiesController@CitiesSelectFrame')->name('cities.select.frame');
    //直接根据id返回市区县地区列表
    Route::post('cities/getAjaxSelect/{id}','CitiesController@CitiesAjaxSelect');

    //地区对应的模板信息
    Route::get('cities/frame/freighttem/{cid}','CitiesController@GetFreightTemByCidFrame')->name('cities.freighttem.frame');

 

    //钱包用户操作记录
    Route::resource('withDrawls', 'WithDrawlController');
    

    //产地
    Route::resource('countries', 'CountryController');

});









