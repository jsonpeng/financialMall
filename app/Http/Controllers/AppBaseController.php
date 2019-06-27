<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;


class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    /**
     * [初始化查询索引状态]
     * @param  [Repository / Model] $obj [description]
     * @return [type]                    [description]
     */
    public function defaultSearchState($obj){
        return defaultSearchState($obj);
    }

    /**
     * [模型默认分页]
     * @param  [type] $obj             [description]
     * @param  [type] $page            [description]
     * @param  string $created_at_sort [description]
     * @return [type]                  [description]
     */
    public function defaultPaginate($obj,$page=null,$created_at_sort='desc'){
    	return defaultPaginate($obj,$page,$created_at_sort);
    }

    /**
     * 获取分页数目
     * @return [type] [description]
     */
    public function defaultPage(){
        return empty(getSettingValueByKey('records_per_page')) ? 15 : getSettingValueByKey('records_per_page');
    }

    /**
     * 验证是否展开
     * @return [int] [是否展开tools 0不展开 1展开]
     */
    public function varifyTools($input,$order=false){
        $tools=0;
        if(count($input)){
            $tools=1;
            if(array_key_exists('page', $input) && count($input)==1) {
                $tools = 0;
            }
            if($order){
                if(array_key_exists('menu_type', $input) && count($input)==1) {
                    $tools = 0;
                }
            }
        }
        return $tools;
    }

    //清空缓存
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return ['status'=>true,'msg'=>''];
    }
}
