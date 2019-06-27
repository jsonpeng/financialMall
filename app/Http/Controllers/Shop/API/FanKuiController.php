<?php


namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FanKuiController extends Controller
{

  
    /**
     * 保存反馈记录
     *
     * @SWG\Get(path="/api/shop/fankui/save_log",
     *   tags={"意见反馈模块"},
     *   summary="保存反馈记录",
     *   description="保存反馈记录,需要带上token参数后获取",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="反馈类型",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="content",
     *     type="string",
     *     description="反馈内容",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="commit",
     *     type="string",
     *     description="联系方式",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="image",
     *     type="string",
     *     description="反馈图 链接多个用,隔开",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回操作结果",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期或者token字段验证失败",
     *     )
     * )
     */
    public function saveLog(Request $request)
    {
        return app('commonRepo')->ComplaintLogRepo()->saveLog($request->all(),auth()->user());
    }
}
