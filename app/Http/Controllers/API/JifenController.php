<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Log;
use RsaCrypt;
use RSAUtils;
use CURLFile;

use GuzzleHttp\Client;
use App\Models\JifenRecord;

class JifenController extends Controller
{

    public function bankList()
    {

        $result = app('commonRepo')->jifenRepo()->bankList();
    	
        return response()->json(['status_code' => 0, 'data' => $result] );
    }

    public function giftApply(Request $request)
    {
    	$input = $request->all();
    	if ($this->varifyInputParam($input, ['oemId', 'tagId', 'type'], true)) {
    		return response()->json(['status_code' => 1, 'data' => '参数错误'] );
    	}

        if ($input['type'] == 'EXCHANGE_CODE') {
            if ($this->varifyInputParam($input, ['code'], true)) {
                return response()->json(['status_code' => 1, 'data' => '请填写兑换码'] );
            }
        }
        if ($input['type'] == 'QR_CODE') {
            if ($this->varifyInputParam($input, ['image'], true)) {
                return response()->json(['status_code' => 1, 'data' => '请上传图片'] );
            }
        }

        //查询类目详情
        $tagDetail = json_decode(app('commonRepo')->jifenRepo()->tagDetail($input['tagId']));
        if ($tagDetail->status != 200) {
            return response()->json(['status_code' => 1, 'data' => $tagDetail->message] );
        }

        //查询通道价格
        $price = json_decode(app('commonRepo')->jifenRepo()->price($input['oemId']));
        if ($price->status != 200) {
            return response()->json(['status_code' => 1, 'data' => $price->message] );
        }

        // if (Config::get('zcjy.JIFEN_USER_PERCENT') && Config::get('zcjy.JIFEN_USER_PERCENT') != 100) {
        //     $price->result->price = intval($price->result->price*(Config::get('zcjy.JIFEN_USER_PERCENT') ? Config::get('zcjy.JIFEN_USER_PERCENT') : 100)/100);
        // }

        $user = auth()->user();

        $money_total = $tagDetail->result->credit/1000000*$price->result->price;

        $result = app('commonRepo')->jifenRepo()->save($input['oemId'], $input['tagId'], $input['code'], $input['image'], $input['type'], $price->result->name, $tagDetail->result->title, $money_total, $user, $request->root().'/jifen_callback');

        return response()->json(['status_code' => 0, 'data' => $result] );
    }


    public function tagDetail($tagId)
    {
        $result = app('commonRepo')->jifenRepo()->tagDetail($tagId);
        return response()->json(['status_code' => 0, 'data' => json_decode($result)] );
    }

    public function postGifts(Request $request, $id)
    {
        $result = app('commonRepo')->jifenRepo()->gifts($id);
        return response()->json(['status_code' => 0, 'data' => json_decode($result)] );
    }

    public function price(Request $request, $id)
    {
    	$result = app('commonRepo')->jifenRepo()->price($id);
        $result = json_decode($result);

        if ($result->status == 200) {
            if (Config::get('zcjy.JIFEN_USER_PERCENT') && Config::get('zcjy.JIFEN_USER_PERCENT') != 100) {
                $result->result->price = intval($result->result->price*(Config::get('zcjy.JIFEN_USER_PERCENT') ? Config::get('zcjy.JIFEN_USER_PERCENT') : 100)/100);
            }
            return response()->json(['status_code' => 0, 'data' => $result] );
        } else {
             return response()->json(['status_code' => 1, 'data' => $result->message] );
        }        
    }

    public function jifenRecords(Request $request)
    {
        $inputs = $request->all();
        $user = auth()->user();
        $skip = 0;
        $take = 20;
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        $records = JifenRecord::where('user_id', $user->id)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        return response()->json(['status_code' => 0, 'data' => $records] );
    }

    private function varifyInputParam($input, $attr=[], $check_empty=false){
    	//$result = false;
    	if(count($attr)){
	    	foreach ($attr as $key => $val) {
				if(!array_key_exists($val,$input)){
					return true;
				}
				if ($check_empty && empty($input[$val])) {
					return true;
				}
	    	}
    	}
		return false;
    }

}
