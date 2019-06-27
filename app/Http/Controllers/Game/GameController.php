<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{

    /**
     * 游戏用户登录
     *
     * @SWG\Get(path="/api/shop/game/login",
     *   tags={"游戏接口"},
     *   summary="游戏用户登录",
     *   description="游戏用户登录,需要前面获取的token,需要注意接收返回的data(token)用于后面打开的web中调用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token令牌",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回游戏中token用户标识密钥",
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
    public function gameLogin(Request $request)
    {
        $user = auth()->user();
        return zcjy_callback_data(generateToken($user));
    }

    public function tiger()
    {
    	return view('front.game.tiger');
    }

    public function tigerRun()
    {
    	// $user = auth()->user();
    	return app('commonRepo')->tigerRun($user);
    }


    public function spin(Request $request)
    {
        $token = $request->input('token');
    	return view('front.game.spin',compact('token'));
    }

    public function spinRun(Request $request)
    {
    	$user = zcjy_api_user($request->input('token'));
    	return app('commonRepo')->spinRun($user);
    }

    //保存信息
    public function spinSaveInfo(Request $request,$spin_id)
    {
        return app('commonRepo')->spinSaveInfo($spin_id,$request);
    }
}
