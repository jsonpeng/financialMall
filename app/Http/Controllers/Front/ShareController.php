<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ShareDk;
use App\Models\ShareDkRecord;
use App\Models\CashIncome;
use App\Models\JifenRecord;
use App\User;
use App\Models\SysSetting;

use GuzzleHttp\Client;
use Log;
use Config;
use RsaCrypt;

use Intervention\Image\ImageManagerStatic as Image;
use QrCode;

class ShareController extends Controller
{
    /**
     * 贷款超市首页
     * @return [type] [description]
     */
    public function shareDks()
    {
        $user = auth('web')->user();
    	$share_dks = ShareDk::where('type', '贷款')->where('shelf', 1)->get();
        $share_xyks = ShareDk::where('type', '信用卡')->where('shelf', 1)->get();
    	return view('front.share_dk.index', compact('share_dks', 'share_xyks', 'user'));
    }

    /**
     * 我的专属超贷二维码
     * @return [type] [description]
     */
    public function shareCommon(Request $request)
    {
        $user = auth('web')->user();
        $share_link = $request->root().'/share_personal/'.$user->id;

        //生成二维码图片
        $picPath = public_path().'/qrcodes/share_personal'.$user->id.'.png';
        QrCode::format('png')->size(300)->generate($share_link, $picPath);

        //打开底图
        $img = Image::make(public_path().'/images/share_shop.jpg');
        $img->text(time(), 300, 680, function($font) {
            $font->file(public_path().'/font/XinH_CuJW.TTF');
            $font->size(24);
            $font->color('#000');
        });
        //插入二维码
        $qcode = Image::make($picPath)->resize(190, 190);
        $img->insert($qcode, 'top-left', 213, 467);

        $img_url = '/qrcodes/share_personal'.$user->id.'.jpg';

        $img->save(public_path().$img_url, 80);

        return view('front.share_dk.common', compact('share_link', 'img_url'));
    }

    /**
     * 个人专属商超
     * @return [type] [description]
     */
    public function sharePersonal(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return redirect('/share_dks');
        }
        $share_dks = ShareDk::where('type', '贷款')->get();
        $share_xyks = ShareDk::where('type', '信用卡')->get();
        return view('front.share_dk.index_personal', compact('user', 'share_dks', 'share_xyks'));
    }

    /**
     * 贷款产品介绍
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function shareDk(Request $request, $id)
    {
        $user = auth('web')->user();
    	$daikuan = ShareDk::find($id);
    	return view('front.share_dk.detail', compact('daikuan', 'user'));
    }

    /**
     * 贷款产品分享二维码
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function shareDkCode(Request $request, $id)
    {
        $daikuan = ShareDk::find($id);
        $user = auth('web')->user();
        $share_link = null;
        if ($daikuan->type == '贷款') {
            $share_link = $request->root().'/share_dk/view/'.$id.'?i='.$user->id;
        } 
        if ($daikuan->type == '信用卡') {
            $share_link = $request->root().'/share_xyk/view/'.$id.'?i='.$user->id;
        }
        //二维码
        $img_url = '/qrcodes/share_product_'.$id.'_'.$user->id.'.png';

        $picPath = public_path().$img_url;
        QrCode::format('png')->size(300)->generate($share_link, $picPath);

        //打开底图
        $img = Image::make(public_path().'/images/share_kouzi.jpg');
        // $img->text(time(), 300, 665, function($font) {
        //     $font->file(public_path().'/font/XinH_CuJW.TTF');
        //     $font->size(24);
        //     $font->color('#FFF');
        // });
        //插入二维码
        $qcode = Image::make($picPath)->resize(173, 173);
        $img->insert($qcode, 'top-left', 220, 710);

        //插入产品图标和文字
        $product_img = Image::make($daikuan->image)->resize(56, 56);
        $img->insert($product_img, 'top-left', 215, 50);

        $img->text($daikuan->name, 280, 85, function($font) {
            $font->file(public_path().'/font/XinH_CuJW.TTF');
            $font->size(24);
            $font->color('#fff');
        });

        $img->save(public_path().$img_url, 80);
        
    	return view('front.share_dk.code', compact('daikuan', 'share_link', 'img_url'));
    }

    /**
     * 贷款产品申请页面
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function shareDkView(Request $request, $id)
    {
    	$daikuan = ShareDk::find($id);
        if(empty($daikuan))
        {
            return redirect('/');
        }
    	return view('front.share_dk.view', compact('daikuan'));
    }

    public function shareXykView(Request $request, $id)
    {
        $daikuan = ShareDk::find($id);
        if(empty($daikuan))
        {
            return redirect('/');
        }
        return view('front.share_xyk.view', compact('daikuan'));
    }


    public function ajaxDkApply(Request $request, $id)
    {
    	$input  = $request->all();
    	if (!array_key_exists('name', $input) || empty($input['name'])) {
    		return ['code' => 1, 'message' => '请填写姓名'];
    	}
    	if (!array_key_exists('mobile', $input) || empty($input['mobile'])) {
    		return ['code' => 1, 'message' => '请填写手机号'];
    	}
    	//定位产品
    	$daikuan = ShareDk::where('type', '贷款')->where('id', $id)->first();

    	$shareDkRecord = ShareDkRecord::create([
    		'terminal_id' => time(),
    		'user_id' => $request->has('invitor') ? $input['invitor'] : 0,
    		'applier_name' => $input['name'],
    		'applier_mobile' => $input['mobile'],
    		'type' => '贷款',
    		'product_id' => $id,
    		'status' => '申请中'
    	]);

    	// Create a client with a base URI
		$client = new Client(['base_uri' => 'https://api.51ley.com/apis/']);
		$response = $client->request('POST', 'api/loan/save/'.Config::get('zcjy.USER_ID'), [
		    'body' => "{
                        \"stationid\":'".Config::get('zcjy.STATION_ID')."',
                        \"userId\":'".Config::get('zcjy.USER_ID')."',
                        \"mobile\":".$input['mobile'].",
                        \"stationChannelId\":".$daikuan->channel_id.",
                        \"callbackUrl\": \"".$request->root()."/loan_callback\",
                        \"clientNo\":\"".$shareDkRecord->terminal_id."\"
                    }",
            'headers' => [
                'content-type' => 'application/json',
            ]
		]);

		$data = json_decode($response->getBody());
		// Log::info($response->getBody());
		if ($data->status == 200) {
            $shareDkRecord->update(['transNo' => $data->result->transNo]);
			return ['code' => 0, 'message' => [
				'url' => $data->result->url,
				'transNo' => $data->result->transNo
			]];
		}else{
			return ['code' => 1, 'message' => $data->message];
		}
    }

    public function ajaxXykApply(Request $request, $id)
    {
        $input  = $request->all();
        if (!array_key_exists('name', $input) || empty($input['name'])) {
            return ['code' => 1, 'message' => '请填写姓名'];
        }
        if (!array_key_exists('mobile', $input) || empty($input['mobile'])) {
            return ['code' => 1, 'message' => '请填写手机号'];
        }
        if (!array_key_exists('shenfenzheng', $input) || empty($input['shenfenzheng'])) {
            return ['code' => 1, 'message' => '请填写身份证'];
        }
        //定位产品
        $daikuan = ShareDk::where('type', '信用卡')->where('id', $id)->first();

        $shareDkRecord = ShareDkRecord::create([
            'terminal_id' => time(),
            'user_id' => $request->has('invitor') ? $input['invitor'] : 0,
            'applier_name' => $input['name'],
            'applier_mobile' => $input['mobile'],
            'shenfenzheng' => $input['shenfenzheng'],
            'type' => '信用卡',
            'product_id' => $id,
            'status' => '申请中'
        ]);

        // Log::info("{
        //                 \"stationid\":'".Config::get('zcjy.STATION_ID')."',
        //                 \"userId\":'".Config::get('zcjy.USER_ID')."',
        //                 \"name\":'".$input['name']."',
        //                 \"mobile\":'".$input['mobile']."',
        //                 \"idCard\":'".$input['shenfenzheng']."',
        //                 \"stationChannelId\":".$daikuan->channel_id.",
        //                 \"callbackUrl\": \"".$request->root()."/xyk_callback\",
        //                 \"clientNo\":\"".$shareDkRecord->terminal_id."\"
        //             }");
        

        // Create a client with a base URI
        $client = new Client(['base_uri' => 'https://api.51ley.com/apis/']);
        $response = $client->request('POST', 'api/station/stationCardAccessRecords/save/'.Config::get('zcjy.USER_ID'), [
            'body' => "{
                        \"stationid\":'".Config::get('zcjy.STATION_ID')."',
                        \"userId\":'".Config::get('zcjy.USER_ID')."',
                        \"name\":'".$input['name']."',
                        \"mobile\":'".$input['mobile']."',
                        \"idCard\":'".$input['shenfenzheng']."',
                        \"stationChannelId\":".$daikuan->channel_id.",
                        \"callbackUrl\": \"".$request->root()."/xyk_callback\",
                        \"clientNo\":\"".$shareDkRecord->terminal_id."\"
                    }",
            'headers' => [
                'content-type' => 'application/json',
            ]
        ]);

        $data = json_decode($response->getBody());
        //Log::info($response->getBody());
        if ($data->status == 200) {
            $shareDkRecord->update(['transNo' => $data->result->tradeNo]);
            return ['code' => 0, 'message' => [
                'url' => $data->result->url,
                'transNo' => $data->result->tradeNo
            ]];
        }else{
            return ['code' => 1, 'message' => $data->message];
        }
    }

    public function loanCallback(Request $request)
    {
        $input = $request->all();
        // Log::info($input);
        if ($input['callbackType'] == 'CALLBACK_SUCCESS') {
            $shareDkRecord = ShareDkRecord::where('terminal_id', $input['clientNo'])->first();
            if (!empty($shareDkRecord) && $shareDkRecord->status == '申请中') {

                $amount = 0;
                if ($shareDkRecord->type == '贷款') {
                    //回调的amount单位是分
                    $shareDkRecord->update([
                        'status' => '已完成',
                        'amount' => $input['amount'] / 100
                    ]);

                    $amount = $input['amount'];
                }

                if ($shareDkRecord->type == '信用卡') {
                    $shareDkRecord->update([
                        'status' => '已完成'
                    ]);
                }
                
                
                $this->yongjin($shareDkRecord, $amount);
            }
        }else{
            $shareDkRecord->update([
                'status' => '失败'
            ]);
        }

        return ['result' =>[
            'message' => '',
            'callbackType' => 'CALLBACK_SUCCESS'
        ]];
    }

    public function xykCallback(Request $request)
    {
        $input = $request->all();
        // Log::info($input);
        if ($input['callbackType'] == 'CALLBACK_SUCCESS') {
            $shareDkRecord = ShareDkRecord::where('terminal_id', $input['clientNo'])->first();
            if (!empty($shareDkRecord) && $shareDkRecord->status == '申请中') {
                //更新状态
                //回调的amount单位是分
                $shareDkRecord->update([
                    'status' => '已完成'
                ]);
                //发佣金
                $this->yongjin($shareDkRecord, 0);
            }
        }else{
            $shareDkRecord->update([
                'status' => '失败'
            ]);
        }

        return ['result' =>[
            'message' => '',
            'callbackType' => 'CALLBACK_SUCCESS'
        ]];
    }

    public function jifenCallback(Request $request)
    {
        $input = $request->all();

        $private_key = Config::get('zcjy.JIFEN_PRI_KEY');

        $timestamp = RsaCrypt::decryptPrivate($input['sign'], $private_key);

        //判断签名
        if ($timestamp != $input['timestamp']) {
            # 签名不正确
            Log::info('签名不正确');
            Log::info($input);
            Log::info($timestamp);
        }

        //返佣，更新状态
        if ($input['callbackType'] == 'CALLBACK_SUCCESS') {
            $record = JifenRecord::where('clientNo', $input['clientNo'])->first();
            if (!empty($record) && $record->status == '申请中') {
                //更新状态
                //回调的amount单位是分
                $record->update([
                    'status' => '已完成'
                ]);
                //发佣金
                $this->yongjinJifen($record);
            }
        }else{
            $record->update([
                'status' => '失败'
            ]);
        }

        return ['result' =>[
            'message' => '',
            'callbackType' => 'CALLBACK_SUCCESS'
        ]];
    }

    /**
     * 积分兑换
     * @Author   yangyujiazi
     * @DateTime 2018-07-29
     * @param    [type]      $record [description]
     * @return   [type]              [description]
     */
    private function yongjinJifen($record)
    {
        if (!empty($record) && !empty($record->user_id)) {
            //用户兑换收入
            $user = User::where('id', $record->user_id)->first();
            $user->update([
                'money' => $user->money +  $record->money_user,
                'money_all' => $user->money_all +  $record->money_user
            ]);
            CashIncome::create([
                'type' => '推广收入',
                'count' => $record->money_user,
                'user_id' => $user->id,
                'des' => '积分兑换收入，订单号：'.$record->clientNo
            ]);

            //一级用户分佣
            if ($record->money_level1) {
                $parent_01 = User::where('id', $user->leader1)->first();
                $parent_01->update([
                    'money' => $parent_01->money +  $record->money_level1,
                    'money_all' => $parent_01->money_all +  $record->money_level1
                ]);
                CashIncome::create([
                    'type' => '推广收入',
                    'count' => $record->money_level1,
                    'user_id' => $parent_01->id,
                    'des' => '推荐用户:'.$user->nickname.'(1级)积分兑换奖励'
                ]);
            }

            if ($record->money_level2) {
                $parent_02 = User::where('id', $user->leader2)->first();
                $parent_02->update([
                    'money' => $parent_02->money +  $record->money_level2,
                    'money_all' => $parent_02->money_all +  $record->money_level2
                ]);
                CashIncome::create([
                    'type' => '推广收入',
                    'count' => $record->money_level2,
                    'user_id' => $parent_02->id,
                    'des' => '推荐用户:'.$user->nickname.'(2级)积分兑换奖励'
                ]);
            }
        }
    }

    /**
     * [yongjin description]
     * @Author   yangyujiazi
     * @DateTime 2018-06-27
     * @param    [type]      $shareDkRecord [description]
     * @param    [type]      $amount        佣金，单位是分
     * @return   [type]                     [description]
     */
    private function yongjin($shareDkRecord, $amount)
    {
        if (!empty($shareDkRecord->user_id)) {
            $daikuan = ShareDk::where('id', $shareDkRecord->product_id)->first();
            if (!empty($daikuan) && $daikuan->money_level1) {
                //一级佣金
                $parent_01 = User::where('id', $shareDkRecord->user_id)->first();
                if (!empty($parent_01)) {
                    //计算用户提成金额
                    $money = 0;
                    if ($daikuan->return_type == '百分比') {
                        $money = ($amount / 100) * $daikuan->money_level1 / 100;
                    }else{
                        $money = $daikuan->money_level1;
                    }
                    //更新用户账户余额
                    $parent_01->update([
                            'money' => $parent_01->money +  $money,
                            'money_all' => $parent_01->money_all +  $money
                        ]);
                    //更新用户账户记录
                    CashIncome::create([
                        'type' => '贷款收入',
                        'count' => $money,
                        'user_id' => $parent_01->id,
                        'custorm_name' => $shareDkRecord->applier_name,
                        'custorm_mobile' => $shareDkRecord->applier_mobile,
                        'des' => '您推荐的用户'.$shareDkRecord->applier_name.'办理了'.$shareDkRecord->type.'业务'
                    ]);

                    //二级佣金
                    if (!empty($parent_01->leader1)) {
                        $parent_02 = User::where('id', $parent_01->leader1)->first();
                        if (!empty($parent_02)) {
                            //计算用户提成金额
                            $money = 0;
                            if ($daikuan->return_type == '百分比') {
                                $money = ($amount / 100) * $daikuan->money_level2 / 100;
                            }else{
                                $money = $daikuan->money_level2;
                            }
                            //更新用户账户余额
                            $parent_02->update([
                                    'money' => $parent_02->money +  $money,
                                    'money_all' => $parent_02->money_all +  $money
                                ]);
                            //更新用户账户记录
                            CashIncome::create([
                                'type' => '贷款收入',
                                'count' => $money,
                                'user_id' => $parent_02->id,
                                'custorm_name' => $shareDkRecord->applier_name,
                                'custorm_mobile' => $shareDkRecord->applier_mobile,
                                'des' => '您推荐的二级用户'.$shareDkRecord->applier_name.'办理了贷款业务'
                            ]);
                        }

                        //三级佣金
                        // if (!empty($parent_01->leader2)) {
                        //     $parent_03 = User::where('id', $parent_01->leader2)->first();
                        //     if (!empty($parent_03)) {
                        //         //计算用户提成金额
                        //         $money = 0;
                        //         if ($daikuan->return_type == '百分比') {
                        //             $money = ($amount / 100) * $daikuan->money_level3 / 100;
                        //         }else{
                        //             $money = $daikuan->money_level3;
                        //         }
                        //         //更新用户账户余额
                        //         $parent_03->update([
                        //                 'money' => $parent_03->money +  $money,
                        //                 'money_all' => $parent_03->money_all +  $money
                        //             ]);
                        //         //更新用户账户记录
                        //         CashIncome::create([
                        //             'type' => '贷款收入',
                        //             'count' => $money,
                        //             'user_id' => $parent_03->id,
                        //             'custorm_name' => $shareDkRecord->applier_name,
                        //             'custorm_mobile' => $shareDkRecord->applier_mobile,
                        //             'des' => '您推荐的三级用户'.$shareDkRecord->applier_mobile.'办理了贷款业务'
                        //         ]);
                        //     }
                        // }
                    }
                }
            }
        }
    }

}