<?php

namespace App\Repositories;

use App\Models\JifenRecord;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Cache;
use Log;
use RsaCrypt;
use RSAUtils;
use CURLFile;

use GuzzleHttp\Client;

/**
 * Class JifenRecordRepository
 * @package App\Repositories
 * @version July 28, 2018, 9:50 pm CST
 *
 * @method JifenRecord findWithoutFail($id, $columns = ['*'])
 * @method JifenRecord find($id, $columns = ['*'])
 * @method JifenRecord first($columns = ['*'])
*/
class JifenRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'oemChannelId',
        'clientNo',
        'channelTagId',
        'content',
        'type',
        'money_all',
        'money_user',
        'money_level1',
        'money_level2'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JifenRecord::class;
    }

    public function bankList()
    {
        // return Cache::remember('bankList', Config::get('zcjy.timecache'), function(){
        //     try {
                $time = $this->getMillisecond();
                $station_id = Config::get('zcjy.JIFEN_STATION_ID');
                $mch_id = Config::get('zcjy.JIFEN_MCH_ID');
                $sign = $this->sign($time);

                $client = new Client(['base_uri' => 'https://lion-api.51ley.com/apis/']);
                $response = $client->request('GET', 'conversion/open/channel/list', [
                    'body' => "{}",
                    'headers' => [
                        'X-Auth-OEM' => $station_id,
                        'X-Open-Sign' => $sign,
                        'X-Open-Merchant' => $mch_id,
                        'X-Open-Timestamp' => $time,
                    ]
                ]);

                $banks = json_decode($response->getBody())->result;

                $result = [];

                foreach ($banks as $key => $value) {
                    if ($value->platformChannel->type == 'EXCHANGE_CODE') {
                        array_push($result, $value);
                    }
                }

                return $result;
        //     } catch (Exception $e) {
        //         return null;
        //     }
        // });
        
    }

    public function tagDetail($tagId)
    {
        // return Cache::remember('tagDetail_'.$tagId, Config::get('zcjy.timecache'), function() use ($tagId) {
        //     try {
                $time = $this->getMillisecond();
                $station_id = Config::get('zcjy.JIFEN_STATION_ID');
                $mch_id = Config::get('zcjy.JIFEN_MCH_ID');
                $sign = $this->sign($time);
           
                $client = new Client(['base_uri' => 'https://lion-api.51ley.com/apis/']);
                $response = $client->request('GET', 'conversion/open/channel/tag/'.$tagId, [
                    'headers' => [
                        'X-Auth-OEM' => $station_id,
                        'X-Open-Sign' => $sign,
                        'X-Open-Merchant' => $mch_id,
                        'X-Open-Timestamp' => $time,
                    ]
                ]);
                return $response->getBody();
        //     } catch (Exception $e) {
        //         return null;
        //     }
        // });
    }

    public function gifts($channelId)
    {
        // return Cache::remember('gifts_'.$channelId, Config::get('zcjy.timecache'), function() use ($channelId) {
        //     try {
                $time = $this->getMillisecond();
                $station_id = Config::get('zcjy.JIFEN_STATION_ID');
                $mch_id = Config::get('zcjy.JIFEN_MCH_ID');
                $sign = $this->sign($time);
           
                $client = new Client(['base_uri' => 'https://lion-api.51ley.com/apis/']);
                $response = $client->request('GET', 'conversion/open/channel/tags?channelId='.$channelId, [
                    'headers' => [
                        'X-Auth-OEM' => $station_id,
                        'X-Open-Sign' => $sign,
                        'X-Open-Merchant' => $mch_id,
                        'X-Open-Timestamp' => $time,
                    ]
                ]);

                return $response->getBody();
        //     } catch (Exception $e) {
        //         return null;
        //     }
        // });
    }

    public function price($channelId)
    {
        // return Cache::remember('price_'.$channelId, Config::get('zcjy.timecache'), function() use ($channelId) {
        //     try {
                $time = $this->getMillisecond();
                $station_id = Config::get('zcjy.JIFEN_STATION_ID');
                $mch_id = Config::get('zcjy.JIFEN_MCH_ID');
                $sign = $this->sign($time);
                $client = new Client(['base_uri' => 'https://lion-api.51ley.com/apis/']);
                $response = $client->request('GET', 'conversion/open/channel/price/'.$channelId, [

                    'headers' => [
                        'X-Auth-OEM' => $station_id,
                        'X-Open-Sign' => $sign,
                        'X-Open-Merchant' => $mch_id,
                        'X-Open-Timestamp' => $time,
                    ]
                ]);
                return $response->getBody();
        //     } catch (Exception $e) {
        //         return null;
        //     }
        // });

        
    }

    public function save($oemId, $tagId, $code, $image, $type, $bank, $title, $money_total, $user, $callback_url)
    {
        //记录并提交
        $jifen = JifenRecord::create([
            'oemChannelId' => $oemId,
            'clientNo' => time(),
            'channelTagId' => $tagId,
            'content' => empty($code) ? $image : $code,
            'type' => $type,
            'bank' => $bank,
            'title' => $title,
            'money_all' => round( $money_total ,1 ),
            'money_user' => round( $money_total * (Config::get('zcjy.JIFEN_USER_PERCENT') ? Config::get('zcjy.JIFEN_USER_PERCENT') : 100)/100 , 1 ),
            'money_level1' => round( $money_total * (Config::get('zcjy.JIFEN_LEVEL1_PERCENT') ? Config::get('zcjy.JIFEN_LEVEL1_PERCENT') : 0)/100 , 1 ),
            'money_level2' => round( $money_total * (Config::get('zcjy.JIFEN_LEVEL2_PERCENT') ? Config::get('zcjy.JIFEN_LEVEL2_PERCENT') : 0)/100 , 1 ),
            'user_id' => $user->id,
            'status' => '申请中'
        ]);

        //保存订单
        $time = $this->getMillisecond();
        $station_id = Config::get('zcjy.JIFEN_STATION_ID');
        $mch_id = Config::get('zcjy.JIFEN_MCH_ID');
        $sign = $this->sign($time);

        $base_url = 'https://lion-api.51ley.com/apis/';
        $url = $base_url . "/conversion/open/channel/save";

        $headers = Array(
            "X-Auth-OEM:" . $station_id,
            "X-Open-Sign:" . $sign,
            "X-Open-Merchant:" . $mch_id,
            "X-Open-Timestamp:" . $time,
        );

        $params = Array(
            'oemChannelId' => $jifen->oemChannelId,//通道id  通道列表上的id
            'clientNo' => $jifen->clientNo, //自定义参数或订单号
            'callbackUrl' => $callback_url,
            'channelTagId' => $jifen->channelTagId, //类目id  类目列表上的id
            'content' => $jifen->content, //兑换码 当通道类型为EXCHANGE_CODE才填写该参数
            'type' => $jifen->type//通道类型  通道列表上的通道类型)
        );

        $result = form($url, $headers, $params);

        $result = json_decode($result);

        if ($result->status == 200) {
            $jifen->kefu = $result->result->customerServiceUrlPath;
            $jifen->transNo = $result->result->transNo;
            $jifen->save();
        }

        return $result;
    }

    private function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }

    private function sign($timestamp)
    {
        $public_key = Config::get('zcjy.JIFEN_PUB_KEY');
        $result = RsaCrypt::encryptPublic($timestamp, $public_key);
        return $result;
    }
}
