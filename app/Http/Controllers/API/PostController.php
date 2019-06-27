<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\PosIntro;
use App\Models\PosApply;
use App\Models\XykIntro;
use App\Models\XykApply;
use App\Models\PostCategory;
use App\Models\SubmitForm;
use App\Models\MiddleLevelInfo;
use App\Models\Page;
use App\Models\Advertorial;
use Log;

class PostController extends Controller
{
    public function post(Request $request, $id)
    { 
    	return response()->json( ['status_code' => 0, 'data' => ['message' => Post::where('id', $id)->first() ]] );
    }

    public function postsOfCat(Request $request, $id)
    {
    	$skip = 0;
    	$take = 20;
    	if ($request->has('skip')) {
    		$skip = $request->input('skip');
    	}
    	if ($request->has('take')) {
    		$take = $request->input('take');
    	}
        $posts = [];

        if ($id > 0) {
            $posts = Post::where('category_id', $id)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        } else {
            $posts = Post::orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        }
        
    	return response()->json( ['status_code' => 0, 'data' => ['message' =>$posts ]] );
    }

    public function pos()
    {
    	return response()->json( ['status_code' => 0, 'data' => ['message' => PosIntro::first() ]] );
    }

    public function postPos(Request $request)
    {
    	if (!$request->has('name')) {
    		return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入姓名' ]] );
    	}
    	if (!$request->has('mobile')) {
    		return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入手机号' ]] );
    	}
    	if (!$request->has('card_num')) {
    		return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入信用卡数量' ]] );
    	}
    	if (!$request->has('address')) {
    		return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入邮寄地址' ]] );
    	}
    	PosApply::create($request->all());
    	return response()->json( ['status_code' => 0, 'data' => ['message' => '成功' ]] );
    }

    public function xyk()
    {
    	return response()->json( ['status_code' => 0, 'data' => ['message' => XykIntro::first() ]] );
    }

    public function postXyk(Request $request)
    {
    	if (!$request->has('name')) {
    		return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入姓名' ]] );
    	}
    	if (!$request->has('mobile')) {
    		return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入手机号' ]] );
    	}
    	if (!$request->has('info')) {
    		return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入信用卡使用状况' ]] );
    	}
    	XykApply::create($request->all());
    	return response()->json( ['status_code' => 0, 'data' => ['message' => '成功' ]] );
    }

    public function list(Request $request)
    {
        $skip = 0;
        $take = 20;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }

        $categories = PostCategory::where('shoufei', 1)->get();
        $catArray = [];
        foreach ($categories as $element) {
            array_push($catArray, $element->id);
        }
        $posts = Post::whereIn('category_id', $catArray)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();

        $posts = $posts->each(function ($item, $key) {
            $item['decription'] = $item->des;
            $item->intro = '';
        });
        
        return response()->json( ['status_code' => 0, 'data' => ['message' =>$posts ]] );
        
    }

    public function applyDk(Request $request)
    {
        // if (!$request->has('name')) {
        //     return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入姓名' ]] );
        // }
        // if (!$request->has('mobile')) {
        //     return response()->json( ['status_code' => 1, 'data' => ['error' => '请输入手机号' ]] );
        // }

        SubmitForm::create($request->all());

        return response()->json( ['status_code' => 0, 'data' => ['message' =>'提交成功' ]] );
    }

    public function kechengs(Request $request)
    {
        $inputs = $request->all();

        $skip = 0;
        $take = 20;
        $level = '中级会员';
        $type = '语音';
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        if (array_key_exists('level', $inputs)) {
            $level = $inputs['level'];
        }
        if (array_key_exists('type', $inputs)) {
            $type = $inputs['type'];
        }

        $kechengs = MiddleLevelInfo::where('type', $type);
        if ($level != '全部') {
            $kechengs = $kechengs->where('level', $level);
        }

        $kechengs = $kechengs->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($take)
            ->get();

        return response()->json( ['status_code' => 0, 'data' => ['message' =>$kechengs ]] );
    }

    public function kecheng(Request $request, $id)
    {
        $kecheng = app('commonRepo')->middleLevelInfoRepo()->getById($id);
        return response()->json( ['status_code' => 0, 'data' => ['message' =>$kecheng ]] );
    }

    public function page(Request $request)
    {
        $slug = null;
        $input = $request->all();
        if ( !array_key_exists('slug', $input) || empty($input['slug'])) {
            return response()->json( ['status_code' => 1, 'data' => ['error' =>'参数不正确' ]] );
        }
        $page = Page::where('slug', $input['slug'])->first();
        if (empty($page)) {
            $page = Page::create([
                'name' => '标题',
                'image' => '',
                'slug' => $input['slug'],
                'content' => ''
            ]);
        }
        return response()->json( ['status_code' => 0, 'data' => ['message' =>$page ]] );
    }

    public function advertorial()
    {
        $advertorial = Advertorial::first();
        return response()->json( ['status_code' => 0, 'data' => $advertorial] );
    }
}
