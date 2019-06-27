<?php

namespace App\Http\Controllers\Front;

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

	public function index()
	{
		//$banks = $this->bankList();
		return view('front.jifen.index');
	}

    public function bankList()
    {

        $result = app('commonRepo')->jifenRepo()->bankList();
    	
        return $result;
    }

    


    public function gifts(Request $request, $id)
    {
    	$price = 0;
    	if ($request->has('price')) {
    		$price = $request->input('price');
    	}
    	return view('front.jifen.gifts', compact('id', 'price'));
    }

    public function baodan(Request $request, $id)
    {

    	return view('front.jifen.baodan');
    }


    public function giftApply(Request $request)
    {
    	$input = $request->all();
    	if ($this->varifyInputParam($input, ['oemId', 'tagId', 'type'], true)) {
    		return ['code' => 1, 'message' => '参数错误'];
    	}

        if ($input['type'] == 'EXCHANGE_CODE') {
            if ($this->varifyInputParam($input, ['code'], true)) {
                return ['code' => 1, 'message' => '请填写兑换码'];
            }
        }
        if ($input['type'] == 'QR_CODE') {
            if ($this->varifyInputParam($input, ['image'], true)) {
                return ['code' => 1, 'message' => '请填写兑换码'];
            }
        }

        //查询类目详情
        $tagDetail = json_decode(app('commonRepo')->jifenRepo()->tagDetail($input['tagId']));
        if ($tagDetail->status != 200) {
            return ['code' => 1, 'message' => $tagDetail->message];
        }

        //查询通道价格
        $price = json_decode(app('commonRepo')->jifenRepo()->price($input['oemId']));
        if ($price->status != 200) {
            return ['code' => 1, 'message' => $price->message];
        }

        $user = auth('web')->user();

        // if (Config::get('zcjy.JIFEN_USER_PERCENT') && Config::get('zcjy.JIFEN_USER_PERCENT') != 100) {
        //     $price->result->price = intval($price->result->price*(Config::get('zcjy.JIFEN_USER_PERCENT') ? Config::get('zcjy.JIFEN_USER_PERCENT') : 100)/100);
        // }

        $money_total = $tagDetail->result->credit/1000000*$price->result->price;

        $result = app('commonRepo')->jifenRepo()->save($input['oemId'], $input['tagId'], $input['code'], $input['image'], $input['type'], $price->result->name, $tagDetail->result->title, $money_total, $user, $request->root().'/jifen_callback');

        return ['code' => 0, 'message' => $result];
    }


    public function tagDetail($tagId)
    {
        return app('commonRepo')->jifenRepo()->tagDetail($tagId);
    }

    public function postGifts(Request $request, $id)
    {
        return app('commonRepo')->jifenRepo()->gifts($id);
    }

    public function price(Request $request, $id)
    {
    	$result = json_decode(app('commonRepo')->jifenRepo()->price($id));
        if (Config::get('zcjy.JIFEN_USER_PERCENT') && Config::get('zcjy.JIFEN_USER_PERCENT') != 100) {
            $result->result->price = intval($result->result->price*(Config::get('zcjy.JIFEN_USER_PERCENT') ? Config::get('zcjy.JIFEN_USER_PERCENT') : 100)/100);
        }
        return $result;
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

    public function uploadImage(){
        $file =  Input::file('file');
        return app('commonRepo')->uploadImages($file,'web',auth('web')->user());
    }

}
