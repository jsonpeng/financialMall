<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ShareDk;
use App\Models\SysSetting;
use Intervention\Image\ImageManagerStatic as Image;
use QrCode;

class ShareController extends Controller
{
    public function xyk_list()
    {
    	$share_dks = ShareDk::where('type', '贷款')->where('shelf', 1)->get();
        $share_xyks = ShareDk::where('type', '信用卡')->where('shelf', 1)->get();
        return response()->json(['status_code' => 0, 'data' => ['xyk' => $share_xyks, 'dk' => $share_dks] ]);
    }

    public function product(Request $request, $id)
    {
    	$product = ShareDk::where('id', $id)->first();
    	if (empty($product)) {
    		return response()->json(['status_code' => 1, 'data' => ['error' => '产品不存在'] ]);
    	} else {
    		return response()->json(['status_code' => 0, 'data' => $product ]);
    	}
    	
    }

    public function productErweima(Request $request, $id)
    {
    	$daikuan = ShareDk::find($id);
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
        
    	return response()->json(['status_code' => 0, 'data' => $request->root().$img_url ]);
    }

    /**
     * 获取个人推广二维码及链接
     *
     * @SWG\Get(path="/api/shop/myself/product_personal",
     *   tags={"商城显示模块-我的"},
     *   summary="获取个人推广二维码及链接",
     *   description="获取个人推广二维码及链接,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回积分数据列表及当前用户剩余总积分",
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
    public function personalShare(Request $request)
    {
    	$user = auth()->user();

        if(!$user->member)
        {
             return response()->json(['status_code' => 1, 'data' =>'是会员才可以有推广二维码']);
        }

        if(empty($user->share_code))
        {
            $user->update(['share_code'=>app('commonRepo')->randomCode()]);
        }
        
        $shareLink = $request->root().'/invite_register/?invitor='.$user->share_code;
        //生成二维码图片
        $picPath = public_path().'/qrcodes/'.$user->id.'.png';
        QrCode::format('png')->size(300)->generate($shareLink, $picPath);

        $setting = SysSetting::first();
        //打开底图
        $img = null;
        if (empty($setting->base_share_img)) {
            $img = Image::make(public_path().'/images/share_base.jpg');
        } else {
            $img = Image::make($setting->base_share_img);
        }
        
        $img->text($user->nickname.'向您推荐了'.$setting->name, 230, 630, function($font) {
            $font->file(public_path().'/font/XinH_CuJW.TTF');
            $font->size(24);
            $font->color('#000');
        });
        //插入二维码
        $qcode = Image::make($picPath)->resize(221, 221);
        $img->insert($qcode, 'top-left', 230, 654);

        $img->save(public_path().'/qrcodes/user_share'.$user->id.'.jpg', 80);
        
        $img_url = $request->root().'/qrcodes/user_share'.$user->id.'.jpg';

        $data = [
            'img_link'    => $img_url,
            'share_link'  => $shareLink
        ];

        return response()->json(['status_code' => 0, 'data' =>$data]);
    }

    /**
     * 获取个人专属二维码
     *
     * @SWG\Get(path="/api/shop/mashang/my_personal_erweima",
     *   tags={"商城显示模块-马上贷"},
     *   summary="获取个人专属二维码",
     *   description="获取个人专属二维码,需要带上token参数后获取",
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
     *         description="status_code=0请求成功,status_code=1请求失败(缺少请求参数,参数验证失败等),data返回链接及二维码地址",
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
    public function getPersonalShare(Request $request)
    {
        $user = auth()->user();

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

        $img_url = $request->root().$img_url;

        $data = [
            'img'    => $img_url,
            'link'  => $share_link
        ];

        return response()->json(['status_code' => 0, 'data' =>$data]);
    }
}
