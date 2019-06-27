<?php 

namespace App\Http\Controllers\Shop\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ShareDk;
use App\Models\SysSetting;
use Intervention\Image\ImageManagerStatic as Image;
use QrCode;

class MaShangController extends Controller
{


	/**
     * 获取所有马上贷产品
     *
     * @SWG\Get(path="/api/shop/mashang/xyk_list",
     *   tags={"商城显示模块-马上贷"},
     *   summary="获取所有马上贷产品",
     *   description="获取所有马上贷产品,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回信用卡及贷款列表",
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
	public function xyk_list()
    {
    	$share_dks = ShareDk::where('type', '贷款')->where('shelf', 1)->get();
        $share_xyks = ShareDk::where('type', '信用卡')->where('shelf', 1)->get();
        return response()->json(['status_code' => 0, 'data' => ['xyk' => $share_xyks, 'dk' => $share_dks] ]);
    }

    /**
     * 获取马上贷产品详情
     *
     * @SWG\Get(path="/api/shop/mashang/share_product/{id}",
     *   tags={"商城显示模块-马上贷"},
     *   summary="获取马上贷产品详情",
     *   description="获取马上贷产品详情,需要带上token参数后获取",
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
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="产品id",
     *     required=true,
     *   ),  
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回产品详情",
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
    public function product(Request $request, $id)
    {
    	$product = ShareDk::where('id', $id)->first();
    	if (empty($product)) {
    		return response()->json(['status_code' => 1, 'data' => ['error' => '产品不存在'] ]);
    	} else {
    		return response()->json(['status_code' => 0, 'data' => $product ]);
    	}
    	
    }

    /**
     * 获取马上贷产品二维码
     *
     * @SWG\Get(path="/api/shop/mashang/product_erweima/{id}",
     *   tags={"商城显示模块-马上贷"},
     *   summary="获取马上贷产品二维码",
     *   description="获取马上贷产品二维码,需要带上token参数后获取",
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
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="产品id",
     *     required=true,
     *   ),  
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回产品二维码",
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
    public function productErweima(Request $request, $id)
    {
    	$daikuan = ShareDk::find($id);
    	if(empty($daikuan))
    	{
    		return zcjy_callback_data('没有找到该贷款',1);
    	}
        $user = auth()->user();
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
        $data = [
            'name' => $daikuan->name,
            'link' => $share_link,
            'img'  => $request->root().$img_url
        ];
    	return response()->json(['status_code' => 0, 'data' =>$data ]);
    }





}