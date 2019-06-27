<?php

namespace App\Repositories;

use Config;
use Overtrue\EasySms\EasySms;
use App\Models\SysSetting;
use App\Models\UserLevel;
use App\Models\OldOrder;
use App\Models\Order;
use App\Models\OrderAction;
use App\Models\CreditLog;
use App\Models\MoneyLog;

use App\Models\HongBaoLog;
use App\Models\SpinResult;
use App\Models\TigerResult;


use Carbon\Carbon;
use App\User;

use App\Repositories\BannerRepository;
use App\Repositories\HkjCatRepository;
use App\Repositories\NoticeRepository;
use App\Repositories\HkjRepository;
use App\Repositories\OldProductRepository;
use App\Repositories\PlatFormRepository;
use App\Repositories\PlatFormCatRepository;
use App\Repositories\CreditCardBankRepository;
use App\Repositories\CreditCardThemeRepository;
use App\Repositories\ToolRepository;
use App\Repositories\MiddleLevelInfoRepository;
use App\Repositories\PageRepository;
use App\Repositories\LiveRepository;
use App\Repositories\PaperTypeRepository;
use App\Repositories\PaperListRepository;
use App\Repositories\TopicsRepository;
use App\Repositories\SelectionsTopicRepository;
use App\Repositories\TestRecordsRepository;
use App\Repositories\JifenRecordRepository;
use App\Repositories\PostCategoryRepository;
use App\Repositories\SoundPostRepository;
use App\Repositories\AmazingManPostRepository;
use App\Repositories\AmazingManRepository;
use App\Repositories\CreditCardRepository;
use App\Repositories\AttachUserLevelRepository;
use App\Repositories\UserPostRepository;
use App\Repositories\SoundPostCatRepository;
use App\Repositories\ComplaintLogRepository;

//原商城引用
use App\Repositories\AddressRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SpecProductPriceRepository;
use App\Repositories\OrderPrompRepository;
use App\Repositories\OrderRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\TeamSaleRepository;
use App\Repositories\FlashSaleRepository;
use App\Repositories\SettingRepository;
use App\Repositories\StoreRepository;
use App\Repositories\ProductEvalRepository;
use App\Repositories\CreditLogRepository;

//商品会员等级价格
use App\Repositories\ProductLevelPriceRepository;
use Log;
use Image;
use Illuminate\Http\Request;

/**
 * Class BankCardRepository
 * @package App\Repositories
 * @version October 25, 2017, 9:56 am CST
 *
 * @method BankCard findWithoutFail($id, $columns = ['*'])
 * @method BankCard find($id, $columns = ['*'])
 * @method BankCard first($columns = ['*'])
*/
class CommonRepository
{
    private $bannerRepository;
    private $hkjCatRepository;
    private $OldProductRepository;
    private $noticeRepository;
    private $platFormCatRepository;
    private $platFormRepository;
    private $creditCardThemeRepository;
    private $creditCardBankRepository;
    private $toolRepository;
    private $hkjRepository;
    private $middleLevelInfoRepository;
    private $pageRepository;
    private $liveRepository;
    private $paperTypeRepository;
    private $paperListRepository;
    private $topicsRepository;
    private $selectionsTopicRepository;
    private $testRecordsRepository;
    private $jifenRecordRepository;
    private $PostCategoryRepository;
    private $SoundPostRepository;
    private $AmazingManPostRepository;
    private $AmazingManRepository;
    private $CreditCardRepository;
    private $AttachUserLevelRepository;
    private $UserPostRepository;
    private $SoundPostCatRepository;
    private $ComplaintLogRepository;

    //原商城引用
    private $addressRepository;
    private $productRepository;
    private $couponRepository;
    private $categoryRepository;
    private $couponUserRepository;
    private $specProductPriceRepository;
    private $orderPrompRepository;
    private $orderRepository;
    private $cityRepository;
    private $countryRepository;
    private $teamSaleRepository;
    private $flashSaleRepository;
    private $settingRepository;
    private $storeRepository;
    private $productEvalRepository;
    private $creditLogRepository;
    // private $statRepositoryRepository;
    private $productLevelPriceRepository;

    public function __construct(
        BannerRepository $bannerRepo,
        HkjRepository $hkjRepo,
        HkjCatRepository $hkjCatRepo,
        OldProductRepository $catRepo,
        NoticeRepository $noticeRepo,
        PlatFormRepository $platFormRepo,
        PlatFormCatRepository $platFormCatRepo,
        CreditCardThemeRepository $creditCardThemeRepo,
        CreditCardBankRepository $creditCardBankRepo,
        ToolRepository $toolRepository,
        MiddleLevelInfoRepository $middleLevelInfoRepo,
        PageRepository $pageRepo,
        LiveRepository $liveRepo,
        PaperTypeRepository $paperTypeRepo,
        PaperListRepository $paperListRepo,
        TopicsRepository $topicsRepo,
        SelectionsTopicRepository $selectionsTopicRepo,
        TestRecordsRepository $testRecordsRepo,
        JifenRecordRepository $jifenRecordRepo,
        PostCategoryRepository $PostCategoryRepo,
        SoundPostRepository $SoundPostRepo,
        AmazingManPostRepository $AmazingManPostRepo,
        AmazingManRepository $AmazingManRepo,
        CreditCardRepository $CreditCardRepo,
        UserPostRepository $UserPostRepo,
        SoundPostCatRepository $SoundPostCatRepo,
        ComplaintLogRepository $ComplaintLogRepo,

        AddressRepository $addressRepo,
        CouponRepository $couponRepo, 
        CategoryRepository $categoryRepo, 
        CouponUserRepository $couponUserRepo, 
        ProductRepository $productRepo,
        SpecProductPriceRepository $specProductPriceRepo,
        OrderRepository $orderRepo,
        OrderPrompRepository $orderPrompRepo,
        CityRepository $cityRepo,
        CountryRepository $countryRepo,
        TeamSaleRepository $teamSaleRepo,
        FlashSaleRepository $flashSaleRepo,
        SettingRepository $settingRepo,
        StoreRepository $storeRepo,
        ProductEvalRepository $productEvalRepo,
        CreditLogRepository $creditLogRepo,
        ProductLevelPriceRepository $productLevelPriceRepo,
        AttachUserLevelRepository $AttachUserLevelRepo
        // StatRepositoryRepository $statRepo
    )
    {
        $this->testRecordsRepository = $testRecordsRepo;
        $this->selectionsTopicRepository = $selectionsTopicRepo;
        $this->topicsRepository = $topicsRepo;
        $this->paperListRepository = $paperListRepo;
        $this->paperTypeRepository = $paperTypeRepo;
        $this->bannerRepository = $bannerRepo;
        $this->hkjCatRepository = $hkjCatRepo;
        $this->OldProductRepository = $catRepo;
        $this->noticeRepository = $noticeRepo;
        $this->platFormCatRepository = $platFormCatRepo;
        $this->platFormRepository = $platFormRepo;
        $this->creditCardThemeRepository = $creditCardThemeRepo;
        $this->creditCardBankRepository = $creditCardBankRepo;
        $this->toolRepository = $toolRepository;
        $this->hkjRepository = $hkjRepo;
        $this->middleLevelInfoRepository = $middleLevelInfoRepo;
        $this->pageRepository = $pageRepo;
        $this->liveRepository = $liveRepo;
        $this->jifenRecordRepository = $jifenRecordRepo;
        $this->PostCategoryRepository = $PostCategoryRepo;
        $this->SoundPostRepository = $SoundPostRepo;
        $this->AmazingManPostRepository = $AmazingManPostRepo;
        $this->AmazingManRepository = $AmazingManRepo;
        $this->CreditCardRepository = $CreditCardRepo;
        $this->AttachUserLevelRepository = $AttachUserLevelRepo;
        $this->UserPostRepository = $UserPostRepo;
        $this->SoundPostCatRepository = $SoundPostCatRepo;

        $this->addressRepository = $addressRepo;
        $this->productRepository = $productRepo;
        $this->couponRepository = $couponRepo;
        $this->categoryRepository = $categoryRepo;
        $this->couponUserRepository = $couponUserRepo;
        $this->specProductPriceRepository = $specProductPriceRepo;
        $this->orderPrompRepository = $orderPrompRepo;
        $this->orderRepository = $orderRepo;
        $this->cityRepository=$cityRepo;
        $this->countryRepository = $countryRepo;
        $this->teamSaleRepository = $teamSaleRepo;
        $this->flashSaleRepository = $flashSaleRepo;
        $this->settingRepository =$settingRepo;
        $this->storeRepository = $storeRepo;
        $this->productEvalRepository = $productEvalRepo;
        $this->creditLogRepository = $creditLogRepo;
        // $this->statRepositoryRepository = $statRepo;
        $this->productLevelPriceRepository = $productLevelPriceRepo;
        $this->ComplaintLogRepository = $ComplaintLogRepo;
    }

    public function ComplaintLogRepo()
    {
        return $this->ComplaintLogRepository;
    }

    public function cityRepo()
    {
        return $this->cityRepository;
    }

    public function SoundPostCatRepo()
    {
        return $this->SoundPostCatRepository;
    }

    public function UserPostRepo()
    {
        return $this->UserPostRepository;
    }

    public function AttachUserLevelRepo()
    {
        return $this->AttachUserLevelRepository;
    }

    public function CreditCardRepo()
    {
        return $this->CreditCardRepository;
    }

    public function AmazingManRepo()
    {
        return $this->AmazingManRepository;
    }

    public function AmazingManPostRepo()
    {
        return $this->AmazingManPostRepository;
    }

    public function SoundPostRepo()
    {
        return $this->SoundPostRepository;
    }

    public function specProductPriceRepo()
    {
        return $this->specProductPriceRepository;
    }

    //  public function statRepo(){
    //     return $this->statRepositoryRepository;
    // }
    public function productLevelPriceRepo()
    {
        return $this->productLevelPriceRepository;
    }

    public function creditLogRepo(){
        return $this->creditLogRepository;
    }


    public function productEvalRepo(){
        return $this->productEvalRepository;
    }


    public function storeRepo(){
        return $this->storeRepository;
    }

    public function addressRepo(){
        return $this->addressRepository;
    }

    public function settingRepo(){
        return $this->settingRepository;
    }


    public function orderRepo()
    {
        return $this->orderRepository;
    }

    public function countryRepo()
    {
        return $this->countryRepository;
    }

    public function categoryRepo()
    {
        return $this->categoryRepository;
    }

    public function teamSaleRepo()
    {
        return $this->teamSaleRepository;
    }

    public function flashSaleRepo()
    {
        return $this->flashSaleRepository;
    }

    public function productRepo()
    {
        return $this->productRepository;
    }


    public function testRecordsRepo(){
        return $this->testRecordsRepository;
    }

    public function selectionsTopicRepo(){
        return $this->selectionsTopicRepository;
    }

    public function topicsRepo(){
        return $this->topicsRepository;
    }

    public function paperRepo(){
        return $this->paperListRepository;
    }

    public function paperTypeRepo(){
        return $this->paperTypeRepository;
    }

    public function bannerRepo()
    {
        return $this->bannerRepository;
    }

    public function hkjCatRepo()
    {
        return $this->hkjCatRepository;
    }

    public function hkjRepo()
    {
        return $this->hkjRepository;
    }

    public function catRepo()
    {
        return $this->PostCategoryRepository;
    }

    public function noticeRepo()
    {
        return $this->noticeRepository;
    }

    public function platFormCatRepo()
    {
        return $this->platFormCatRepository;
    }
    public function platFormRepo()
    {
        return $this->platFormRepository;
    }

    public function creditCardThemeRepo()
    {
        return $this->creditCardThemeRepository;
    }
    public function creditCardBankRepo()
    {
        return $this->creditCardBankRepository;
    }
    public function toolRepo()
    {
        return $this->toolRepository;
    }
    public function middleLevelInfoRepo()
    {
        return $this->middleLevelInfoRepository;
    }
    public function pageRepo()
    {
        return $this->pageRepository;
    }
    public function liveRepo()
    {
        return $this->liveRepository;
    }
    public function jifenRepo()
    {
        return $this->jifenRecordRepository;
    }

    /**
     * 生成不重复的随机推荐码
     * @Author   yangyujiazi
     * @DateTime 2018-06-30
     * @return   [type]      [description]
     */
    public function randomCode()
    {
        $scode = $this->shuffleCode();
        if (User::where('share_code', $scode)->count()) {
            return $this->randomCode();
        } else {
            return $scode;
        }
    }

    /**
     * 获取详细的会员价格
     * @param  [type] $user    [description]
     * @param  [type] $product [description]
     * @return [type]          [description]
     */
    public function getMemberPrice($user,$product,$spec=null)
    {
        if(isset($user))
        {
            $level = $user->level()->first();
        }
        
        $price = $product->price;

        if(!empty($spec))
        {
            $price = $spec->price;
        }

        if(!empty($level))
        {
            #取出对应会员等级的商品价格
            $level_product_price = $this->productLevelPriceRepo()->getlevelProductDetail('product',$level->id,$product->id);
            #如果还存在规格信息
            if(!empty($spec))
            {
                $level_product_price = $this->productLevelPriceRepo()->getlevelProductDetail('spec',$level->id,$spec->id);
            }
            #如果能查到对应的价格
            if(!empty($level_product_price))
            {
                $price = $level_product_price->price;
            }
        }

        return $price;
    }

    /**
     * [默认直接通过数组的值 否则通过数组的键]
     * @param  [type] $input      [description]
     * @param  array  $attr       [description]
     * @param  string $valueOrKey [description]
     * @return [type]             [description]
     */
    public function varifyInputParam($input,$attr=[],$valueOrKey='value'){
        $status = false;
        #第一种带键值但值为空的情况
        foreach ($input as $key => $val) {
            if(array_key_exists($key,$input)){
                if(empty($input[$key]) && $input[$key]!=0){
                    $status = '参数不完整';
                }
            }
        }
        #第二种是针对提交的指定键值
        if(count($attr)){
            foreach ($attr as $key => $val) {
                if($valueOrKey == 'value'){
                    if(!array_key_exists($val,$input) || array_key_exists($val,$input) && empty($input[$val]) && $input[$val] != 0){
                        $status = '参数不完整';
                    }
                }
                else{
                     if(!array_key_exists($key,$input) || array_key_exists($key,$input) && empty($input[$key]) && $input[$key] != 0){
                        $status = '参数不完整';
                    }
                }
            }
        }

        return $status;
    }

    private function shuffleCode(){
        $str="1234567890qwertyuiopasdfghjklzxcvbnm";
        str_shuffle($str);
        return substr(str_shuffle($str),0,4);
    }

    /**
     * 获取支付宝配置信息
     * @param  [type] $request [description]
     * @param  string $type    [description]
     * @return [type]          [description]
     */
    public function getAlipayConfig($request = null,$type = 'buy_mem')
    {
        $config = Config::get('pay.alipay');
        
        $alipay_app_id = getSettingValueByKey('alipay_app_id');
        if($alipay_app_id)
        {
            $config['app_id'] = $alipay_app_id;
        }

        $ali_public_key = getSettingValueByKey('alipay_public_key');
        if($ali_public_key)
        {
            $config['ali_public_key'] = $ali_public_key;
        }

        $ali_private_key = getSettingValueByKey('alipay_private_key');
        if($ali_private_key)
        {
            $config['private_key'] = $ali_private_key;
        }

        if(!empty($request))
        {
            $config['notify_url'] = $request->root().'/alipay/'.$type.'/notify';
            $config['return_url'] = $request->root().'/alipay_return';
        }
        //Log::info($config);
        return $config;
    }

    /**
     * 生成会员卡订单
     * @param  [type] $user     [description]
     * @param  [type] $card_id  [description]
     * @param  [type] $pay_type [description]
     * @return [type]           [description]
     */
    public function generateOrder($user, $card_id, $pay_type,$code = null)
    {
        $userLevel = UserLevel::where('id', $card_id)->first();
        if (empty($userLevel)) {
            return ['code' => 1, 'message' => '会员信息不存在'];
        }

        $order = null;
        $body = '课程订阅';

        if ($user->member && Carbon::now()->lt(Carbon::parse($user->member_end_time))) {
            //用户现在已经是会员
            if ($userLevel->level < $user->mem_level) {
                return ['code' => 1, 'message' => '您是更高等级会员，无需购买低等级会员'];
            }

            //同级别会员，续费
            if ($userLevel->level == $user->mem_level) {
                $body = '课程续费';
            }

            if ($userLevel->level > $user->mem_level) {
                $body = '课程升级，升级到'.$userLevel->name;
            }else{
                $body = $userLevel->name.'购买';
            }
        }

        #先清除未支付的订单
        OldOrder::where('user_id',$user->id)
        ->where('pay_status','未支付')
        ->delete();

        $money = $userLevel->money;

        if(!empty($code))
        {
           if(getSettingValueByKey('buy_member_dis_code') == $code)
           {
              $dis_price = getSettingValueByKey('buy_member_dis_price') ? : 0;
              $money = $money - $dis_price;

              if($money < 0)
              {
                $money = $userLevel->money;
              }
           } 
        }

        $order = OldOrder::create([
            'money' => $money,
            'pay_status' => '未支付',
            'platform' => $pay_type,
            'user_id' => $user->id,
            'pay_no' => time().'_'.random_int(1, 20000),
            'level_name' => $userLevel->name,
            'level_id' => $userLevel->id,
        ]);

        return ['code' => 0, 'order' => $order, 'body' => $body];
    }

    /**
     * 分佣金额
     * @param  [type] $user  [购买的用户]
     * @param  [type] $order [订单信息]
     * @param  [type] $level [推荐人等级]
     * @return [type]        [被推荐的人]
     */
    public function returnMoney($user, $order, $level, $child = null)
    {
        //没有购买过会员的不分佣
        if ($user->member == 0) {
            return 0;
        }
        //会员卡信息不存在
        $userLevel = UserLevel::where('id', $order->level_id)->first();
        if (empty($userLevel)) {
            return 0;
        }
        // //一级推荐
        // if ($level == 1) {
        //     switch ($userLevel->level) {
        //         case 1:
        //             //购买初级VIP
        //             return empty($user->level_money_11) ? $userLevel->level_money_11 : $user->level_money_11;
        //             break;
        //         case 2:
        //             //购买中级VIP
        //             return empty($user->level_money_21) ? $userLevel->level_money_11 : $user->level_money_21;
        //             break;
        //         case 3:
        //             //购买搞级VIP
        //             return empty($user->level_money_31) ? $userLevel->level_money_11 : $user->level_money_31;
        //             break;
                
        //         default:
        //             return 0;
        //             break;
        //     }
        // }
        // //二级推荐
        // if ($level == 2) {
        //     switch ($userLevel->level) {
        //         case 1:
        //             //购买初级VIP
        //             return empty($user->level_money_12) ? $userLevel->level_money_12 : $user->level_money_12;
        //             break;
        //         case 2:
        //             //购买中级VIP
        //             return empty($user->level_money_22) ? $userLevel->level_money_12 : $user->level_money_22;
        //             break;
        //         case 3:
        //             //购买搞级VIP
        //             return empty($user->level_money_32) ? $userLevel->level_money_12 : $user->level_money_32;
        //             break;
                
        //         default:
        //             return 0;
        //             break;
        //     }
        // }
        return app('commonRepo')->AttachUserLevelRepo()->userReturnMoney($user,$level,$userLevel, $child);
    }

    public function sendVerifyCode($mobile)
    {
        $setting = SysSetting::first();
        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => $setting->sms_id,
                    'access_key_secret' => $setting->sms_key,
                    'sign_name' => $setting->sms_sign,
                ]
            ],
        ];

        $easySms = new EasySms($config);

        $num = rand(1000, 9999); 

        $easySms->send($mobile, [
            'content'  => '验证码'.$num.'，您正在注册成为新用户，感谢您的支持！',
            'template' => $setting->sms_template,
            'data' => [
                'code' => $num
            ],
        ]);

        return $num;
    }


     /**
     * 商品最大可买数量
     * @param  [type] $product [description]
     * @param  [type] $qty     [description]
     * @param  [type] $spec_id [description]
     * @return [type]          [description]
     */
    public function maxCanBuy($product, $qty, $spec_id = null)
    {
        if(empty($product))
        {
            return 0;
        }
        if ($product->prom_type == 1) {
            //秒杀
            $flashSale = $this->flashSaleRepository->findWithoutFail($product->prom_id);
            if (!empty($flashSale) && $flashSale->status == '进行中') {
                if ($qty > $flashSale->buy_limit) {
                    $qty = $flashSale->buy_limit;
                }
            }
        }
        else{
            //普通购买，检查库存
            if (empty($spec_id)) {
                if ($product->inventory != -1) {
                    $qty = $qty > $product->inventory ? $product->inventory : $qty;
                }
            }else{
                $specPrice = $this->specProductPriceRepository->findWithoutFail($spec_id);
                if(!empty($specPrice)){
                    if ($specPrice->inventory != -1) {
                        if (empty($specPrice)) {
                            $qty = 0;
                        } else {
                            $qty = $qty > $specPrice->inventory ? $specPrice->inventory : $qty;
                        }
                    }
                }
                else{
                    $qty = 0;
                }
            }
        }
        return $qty;
    }

    /**
     * [图片上传]
     * @param  [type]  $file      [description]
     * @param  [string] $api_type [description]
     * @return [type]             [description]
     */
    public function uploadImages($file,$api_type='web',$user=null){
        
        if(empty($file)){
            return zcjy_callback_data('图片文件不存在',1,$api_type);
        }

        $allowed_extensions = ["png", "jpg", "gif","jpeg"];
       
        if(!empty($file)) {
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return zcjy_callback_data('图片格式不正确',1,$api_type);
            }
        }

        #图片文件夹
        $destinationPath = empty($user) ? "uploads/admin/" : "uploads/user/".$user->id.'/';

        if (!file_exists($destinationPath)){
            mkdir($destinationPath,0777,true);
        }
       
        $extension = $file->getClientOriginalExtension();
        $fileName = str_random(10).'.'.$extension;
        $file->move($destinationPath, $fileName);

        $image_path=public_path().'/'.$destinationPath.$fileName;
        
        $img = Image::make($image_path);
        $img->resize(640, 640);
        $img->save($image_path,70);

        $host='http://'.$_SERVER["HTTP_HOST"];

       // if(env('online_version') == 'https')
        if(stripos(\Request::fullUrl(),'https') !== false)
        {
             $host = 'https://'.$_SERVER["HTTP_HOST"];
        }

        #图片路径
        $path=$host.'/'.$destinationPath.$fileName;

        return zcjy_callback_data([
                'src'=>$path,
                'current_time' => Carbon::now()
            ],0,$api_type);
    }

    //计算运费
    public function freight($address, $carts)
    {
        if (empty($address)) {
            return 0;
        }

        $total = $carts['price'];

        //满额免运费
        if (getSettingValueByKey('freight_free_limit') <= $total) {
            return 0;
        }

        $freight_data = $this->cityRepository->getFreightInfoByAddress($address);

        $lufei = 0;
        //计费方式
        $weightType = $freight_data['freight_type'];
        //首重重量
        $freight_first_weight = $freight_data['freight_first_count'];
        //首重价格
        $freight_first_price = $freight_data['freight_first_price'];
        //续重重量
        $freight_continue_weight = $freight_data['freight_continue_count'];
        //续重价格
        $freight_continue_price = $freight_data['freight_continue_price'];

        $items = $carts['items'];

        if ($weightType == 1) {
            //按重计费
            $weight = 0; //计算运费商品重量
            //$items = ShoppingCart::all();

            foreach ($items as $item) {
                //不带规格
                $product = $this->productRepository->findWithoutFail($item->product_id);
                if (!empty($product)) {
                    //计算运费
                    if (!$product->free_shipping) {
                        $weight += $product->weight * $item->count;
                    }
                }
            }
            if ($weight == 0) {
                $lufei = 0;
            } else {
                if ($freight_first_weight >= $weight) {
                    //首重内
                    $lufei = $freight_first_price;
                } else {
                    //超首重
                    $weight_exceed = $weight - $freight_first_weight;
                    if ($freight_continue_weight != 0) {
                        $exceed_num = ceil($weight_exceed/$freight_continue_weight);
                        $lufei = $freight_first_price + $exceed_num * $freight_continue_price;
                    }
                }
            }
        } else {
            //按件计费
            //$total_count = ShoppingCart::count();
            $total_count = 0;
            foreach ($items as $key => $value) {
                $total_count += $value->count;
            }
            if ($freight_first_weight >= $total_count) {
                //首次计件内
                $lufei = $freight_first_price;
            } else {
                //超首计件
                $weight_exceed = $total_count - $freight_first_weight;
                if ($freight_continue_weight != 0) {
                    $exceed_num = ceil($weight_exceed/$freight_continue_weight);
                    $lufei = $freight_first_price + $exceed_num * $freight_continue_price;
                }
            }
        }
        return empty($lufei) ? 0 : $lufei;
    }


    public function appAliPay($request,$order_info,$type ='',$pay_type = 'app')
    {
        $config = app('commonRepo')->getAlipayConfig($request,$type);
        $alipay = \Yansongda\Pay\Pay::alipay($config);
        
        if($request->has('pay_type'))
        {
            $pay_type = $request->get('pay_type');
        }

        if($pay_type == 'app')
        {
            $response = $alipay->app($order_info);
        }
        elseif($pay_type == 'web')
        {
             $response = $alipay->wap($order_info);
        }

        return $response->getContent();
    }

    /**
     * 计算积分减免金额
     * @param [mixed] $user       [用户对象]
     * @param [float] $totalprice [订单总金额]
     * @param [integer] $credits    [积分数目]
     */
    public function CreditPreference($user, $totalprice, $credits)
    {
        $useCredits = $credits;

        $credits = $user->credits > $credits ? $credits : $user->credits;
        //积分现金兑换比例
        $creditRate = getSettingValueByKeyCache('credits_rate');
        //积分最多可抵用金额比例
        $maxTotalRate = getSettingValueByKeyCache('credits_max');
        //最多抵扣金额
        $maxCancel = round($totalprice * $maxTotalRate / 100);

        $credits = ($credits > $maxCancel * $creditRate) ? $maxCancel * $creditRate : $credits;

        $creditPreference = round($credits / $creditRate, 2) < 0 ? 0 : round($credits / $creditRate, 2);

        if($totalprice ==0)
        {
            $credits = $useCredits;
            $creditPreference = 0;
        }

        $credits = $credits < 0 ? 0 : $credits;

        return ['credits' => $credits, 'creditPreference' => $creditPreference];
    }

    /**
     * 支付成功后，处理商品订单信息
     * @param  [mixed] $order [订单信息]
     * @return [type]        [description]
     */
    public function processShopOrder($pay_no, $pay_platform){

        $order = Order::where('snumber',$pay_no)->first();

        if (empty($order)) { // 如果订单不存在
            return 'failure';
        }

        // 如果订单存在
        // 检查订单是否已经更新过支付状态
        if ($order->pay_status == '已支付') {
            // 已经支付成功了就不再更新了
            return 'success'; 
        }

        //修改订单状态
        $order->update(['order_pay' => '已支付', 'pay_time' => Carbon::now(), 'pay_platform' => $pay_platform, 'pay_no' => $pay_no]);

        #充值订单
        // if(substr($order->out_trade_no, -2) == '_8'){
        //     $message = explode('_',$order->out_trade_no);
        //     $this->addUserMoney($message[1],$order->price);
        // }

        //加销量
        $this->orderRepository->dealOrderProductSales($order);

        //减库存
        if (getSettingValueByKey('inventory_consume') == '支付成功') {
            $this->orderRepository->deduceInventory($order->id);
        }
        
        //送积分
        $credit_rate = getSettingValueByKeyCache('consume_credits');
        if ($credit_rate) {
            $user = $order->customer;
            $newCredits = intdiv($order->price*$credit_rate, 100);
            if ($newCredits) {
                $user->credits += $newCredits;
                //添加积分记录
                app('commonRepo')->addCreditLog($user->credits, $newCredits, '用户购物赠送，订单编号为:'.$order->snumber, 2, $user->id);
            }
        }

        //分佣
        $this->shopOrderYongjin($order);
        //发送提醒
        // event(new OrderPay($order));

        //处理充值订单
        // $this->orderRepository->dealTopupOrder($order->out_trade_no);

        //填写支付记录
        
        //购物券
        // CouponUser::where('order_id', $order->id)->update(['status' => '已使用']);
        return 'success'; 
    }


    private function shopOrderYongjin($order)
    {
        if($order->price <= 0)
        {
            return;
        }

        $user = $order->customer;

        if(empty($user))
        {
            return;
        }

        //发佣金
        if (!empty($user->leader1)) {
            $parent = User::where('id', $user->leader1)->first();
            $leader1_rate = getSettingValueByKey('leader1_shop_order_rate');
            if (!empty($parent) && $leader1_rate) {
                //发奖金
                $addMoney = round($order->price * $leader1_rate / 100,2);
                //直接推荐人
                $parent->update(['money' => $parent->money+$addMoney, 'money_all' => $parent->money_all+$addMoney]);
                //操作记录
                CashIncome::create([
                    'type' => '推广收入',
                    'count' => $addMoney,
                    'user_id' => $parent->id,
                    'custorm_name' => $user->nickname,
                    'custorm_mobile' => $user->mobile,
                    'des' => '您推荐的1级用户'.$user->nickname.'购买了商品'
                ]);
                $leader2_rate = getSettingValueByKey('leader2_shop_order_rate');
                //二级推荐人
                if (!empty($user->leader2) && $leader2_rate) {
                    $granpa = User::where('id', $user->leader2)->first();
                    if (!empty($granpa)) {
                        //发奖金
                        $addMoney = round($order->price * $leader2_rate / 100,2);
                        if (!empty($addMoney)) {
                            //直接推荐人
                            $granpa->update(['money' => $granpa->money+$addMoney, 'money_all' => $granpa->money_all+$addMoney]);

                            //操作记录
                            CashIncome::create([
                                'type' => '推广收入',
                                'count' => $addMoney,
                                'user_id' => $granpa->id,
                                'custorm_name' => $user->nickname,
                                'custorm_mobile' => $user->mobile,
                                'des' => '您推荐的2级用户'.$user->nickname.'购买了商品'
                            ]);
                        }
                    }
                }
            }
        }
    }

    //为课程添加属性
    public function attachKeChenLevelInfo($kecheng)
    {
        // $kecheng = optional($kecheng);
        if(isset($kecheng->level_name) || isset($kecheng->level))
        {
            $level_name = $kecheng->level_name;
            if(!is_numeric($kecheng->level))
            {
                $level_name = $kecheng->level;
            }
            $kecheng['level_info'] = UserLevel::where('name',$level_name)->first();
        }
        else{
            $kecheng['level_info'] = null;
        }
        return $kecheng;
    }

    /**
     * 添加订单操作日志
     * @param [type] $order_status    [订单状态]
     * @param [type] $shipping_status [物流状态]
     * @param [type] $pay_status      [支付状态]
     * @param [type] $action          [操作]
     * @param [type] $status_desc     [描述]
     * @param [type] $user            [操作用户]
     * @param [type] $order_id        [订单ID]
     */
    public function addOrderLog($order_status, $shipping_status, $pay_status, $action, $status_desc, $user, $order_id)
    {
        OrderAction::create([
            'order_status' => $order_status,
            'shipping_status' => $shipping_status,
            'pay_status' => $pay_status,
            'action' => $action,
            'status_desc' => $status_desc,
            'user' => $user,
            'order_id' => $order_id,
        ]);
    }

    /**
     * 用户积分日志
     * @param [type] $amount  [积分余额]
     * @param [type] $change  [ 积分变动，正为增加，负为支出 ]
     * @param [type] $detail  [详情]
     * @param [type] $type    [0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗 4管理员操作 5积分卡充值 6观看视频赠送 7游戏额外赠送]
     * @param [type] $user_id [用户ID]
     */
    public function addCreditLog($amount, $change, $detail, $type, $user_id)
    {
        if (empty($change)) {
            return;
        }
        
        CreditLog::create([
            'amount' => $amount,
            'change' => $change,
            'detail' => $detail,
            'type' => $type,
            'user_id' => $user_id,
        ]);  
    }

    /**
     * 用户余额日志
     * @param [type] $amount  [余额余额]
     * @param [type] $change  [ 余额变动，正为增加，负为支出 ]
     * @param [type] $detail  [详情]
     * @param [type] $type    [0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗,4充值,5提现]
     * @param [type] $user_id [用户ID]
     */
    public function addMoneyLog($amount, $change, $detail, $type, $user_id)
    {
        if (empty($change)) {
            return;
        }
        MoneyLog::create([
            'amount' => $amount,
            'change' => $change,
            'detail' => $detail,
            'type' => $type,
            'user_id' => $user_id,
        ]);  
    }

    /**
     * 判断用户是否有查看权限
     * @param  [type] $user [description]
     * @param  [type] $item [description]
     * @return [type]       [description]
     */
    public function varifyUserCanMem($user,$item)
    {
        if(isset($item->level_info) && !empty($item->level_info))
        {
            $itemLevel = $item->level_info;
            $userLevel = $user->UserLevel;
            if(empty($userLevel))
            {
                return 0;
            }
            if($userLevel->level >= 1)
            {
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return 1;
        }
    }

        /**
     * [为数据添加星期]
     * @param  [type] $list [description]
     * @return [type]       [description]
     */
    public function attachWeek($list){
        $week_arr = [
           '周日',
           '周一',
           '周二',
           '周三',
           '周四',
           '周五',
           '周六'
        ];
        if(count($list)){
            foreach ($list as $key => $val) {
                if(isset($val->created_at)){
                    $val['week'] =  isset($week_arr[$val->created_at->dayOfWeek]) ? $week_arr[$val->created_at->dayOfWeek] : null;
                }
            }
        }
        return $list;
    }

    public function autoCode()
    {
        $users = User::all();
        foreach ($users as $key => $user) {
           if(empty($user->share_code))
           {
            $user->update(['share_code'=>app('commonRepo')->randomCode()]);
           }
        }
    }


    /**
     * 红包转盘游戏结果
     * @param string $value [description]
     */
    public function spinRun($user, $account = null)
    {
        if(empty($user))
        {
             return ['code' => 1, 'message' => '请先完成认证(token认证)'];
        }
        # 转一次需要的金币数量
        $consume_coin = valueOfKey('hongbao_coin');
        if ($user->credits < $consume_coin) {
            # 金币不足
            return ['code' => 1, 'message' => '账户金币不足'];
        }
        if (empty($consume_coin)) {
            # 金币不足
            return ['code' => 1, 'message' => '系统设置错误，请联系管理员'];
        }

        # 计算获奖结果
        $result = mt_rand(1, 6);

        #金币支出
        app('commonRepo')->addCreditLog($user->credits, -$consume_coin , '参与转盘抽奖游戏', 3, $user->id);

        $spinGameName = valueOfKey('hongbao_'.$result.'_name');

        if ($result != 2 && $result != 5) 
        {
            $total = SpinResult::count();
            $total_result = SpinResult::where('result', $result)->count();

            #目前的中奖比例
            $cur_ratio = empty($total) ? 0 : intval($total_result/$total*100);
            $set_ratio = valueOfKey('hongbao_'.$result);
           
            if ($cur_ratio < $set_ratio) 
            {
                $bonus = [10,0,200,100,0,50];
                # 没有达到设定的比例，可以中奖
                $SpinResult =  SpinResult::create([
                    'name'   => $spinGameName,
                    'user_id' => $user->id,
                    'coin_in' => $consume_coin,
                    'coin_out' => $bonus[$result-1],
                    'result' => $result,
                    'account' => $account
                ]);
                #扣除用户账户金币
                $user->credits -= $consume_coin;
                #增加用户积分
                app('commonRepo')->addCreditLog($user->credits,$bonus[$result-1], '参与转盘中奖', 7, $user->id);
                // #增加用户红包
                // HongBaoLog::create([
                //     'type' => '收入',
                //     'count' => $bonus[$result-1],
                //     'des' => '金币抽奖获得',
                //     'status' => '已通过',
                //     'order_no' => time(),
                //     'user_id' => $user->id
                // ]);
                $user->credits += $bonus[$result-1];
                $user->save();

                return ['code' => 0, 'message' => ['result' => $result, 'data' => $spinGameName,'spinresult' => $SpinResult->id ,'credits'=> $user->credits ]];
            }
        } 
        # 谢谢参与
        SpinResult::create([
            'name' => $spinGameName,
            'user_id' => $user->id,
            'coin_in' => $consume_coin,
            'coin_out' => 0,
            'result' => 1,
            'account' => $account
        ]);

        # 扣除用户账户金币
        $user->credits -= $consume_coin;
        $user->save();
        return ['code' => 0, 'message' => ['result' => 1, 'data' => 0,'credits'=> $user->credits]];
        
    }


    /**
     * 保存收货信息
     * @param  [type] $spin_id [description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function spinSaveInfo($spin_id,$request)
    {
        $SpinResult = SpinResult::find($spin_id);

        if(empty($SpinResult))
        {
            return zcjy_callback_data('没有找到该奖项',1,'web');
        }
        $input = $request->all();

        if(!isset($input['rec_name']) || !isset($input['rec_mobile']) || !isset($input['rec_address']))
        {
            return zcjy_callback_data('请填写完整的收货信息',1,'web');
        }
        $SpinResult->update($input);
        return zcjy_callback_data('收货信息填写完整,我们将第一时间给您送货',0,'web');
    }

    /**
     * 金币游戏结果
     * @param string $value [description]
     */
    public function tigerRun($user, $account = null)
    {
        # 转一次需要的金币数量
        $consume_coin = valueOfKey('coin_consume');
        if ($user->credits < $consume_coin) {
            # 金币不足
            return ['code' => 1, 'message' => '账户金币不足'];
        }

        if (empty($consume_coin)) {
            # 金币不足
            return ['code' => 1, 'message' => '系统设置错误，请联系管理员'];
        }

        # 计算获奖结果
        $result = mt_rand(1, 7);

        if ($result != 1) {
            $total = TigerResult::count();
            $total_result = TigerResult::where('result', $result)->count();

            #目前的中奖比例
            $cur_ratio = empty($total) ? 0 : intval($total_result/$total*100);
            $set_ratio = valueOfKey('coin_'.$result);
            if ($cur_ratio < $set_ratio) {
                $bonus = [10,0,200,100,0,50];
                # 没有达到设定的比例，可以中奖
                TigerResult::create([
                    'user_id' => $user->id,
                    'coin_in' => $consume_coin,
                    'coin_out' => $bonus[$result-1],
                    'result' => $result,
                    'account' => $account
                ]);
                #修改账户金币
                $user->credits -= $consume_coin;
                $user->credits += $bonus[$result-1];
                $user->save();

                #金币支出
                // creditLog::create([
                //     'type' => '支出',
                //     'count' => $consume_coin,
                //     'des' => '参与金币抽奖游戏',
                //     'status' => '正常',
                //     'order_no' => millisecond(),
                //     'user_id' => $user->id
                // ]);
                app('commonRepo')->addCreditLog($user->credits, -$consume_coin , '参与金币抽奖游戏', 3, $user->id);
                #金币收入
                // creditLog::create([
                //     'type' => '收入',
                //     'count' => $bonus[$result-1],
                //     'des' => '参与金币抽奖游戏',
                //     'status' => '正常',
                //     'order_no' => millisecond(),
                //     'user_id' => $user->id
                // ]);
                app('commonRepo')->addCreditLog($user->credits, $bonus[$result-1] , '参与金币抽奖游戏', 7, $user->id);

                return ['code' => 0, 'message' => ['result' => $result, 'data' => $bonus[$result-1]]];
            }
        }
        # 谢谢参与
        TigerResult::create([
            'user_id' => $user->id,
            'coin_in' => $consume_coin,
            'coin_out' => 0,
            'result' => 1,
            'account' => $account
        ]);

        # 扣除用户账户金币
        $user->credits -= $consume_coin;
        $user->save();

        #用户金币记录
        // creditLog::create([
        //     'type' => '支出',
        //     'count' => $consume_coin,
        //     'des' => '参与金币抽奖游戏',
        //     'status' => '正常',
        //     'order_no' => millisecond(),
        //     'user_id' => $user->id
        // ]);

        app('commonRepo')->addCreditLog($user->credits, -$consume_coin, '参与金币抽奖游戏', 3, $user->id);
        //[0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗 4管理员操作 5积分卡充值 6观看视频赠送 7游戏额外赠送]
        return ['code' => 0, 'message' => ['result' => 1, 'data' => 0]];
        
    }


    public function registerGivenCredits($user,$parent_id = null)
    {
        $given_credits = getSettingValueByKey('register_credits') ?:0;
        if($given_credits)
        {
            $user->credits += $given_credits;
            $user->save();
            app('commonRepo')->addCreditLog($user->credits, $given_credits , '注册赠送积分', 0, $user->id);
        }
        if(!empty($parent_id))
        {
            $invite_given_credits = getSettingValueByKey('invite_credits') ?:0;
            if($invite_given_credits)
            {
                $parent = User::find($parent_id);
                if(!empty($parent))
                {
                    $parent->credits += $given_credits;
                    $parent->save();
                    app('commonRepo')->addCreditLog($parent->credits, $invite_given_credits , '邀请人赠送积分', 1, $parent->id);
                }
            }
        }
    }

}
