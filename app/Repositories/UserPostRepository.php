<?php

namespace App\Repositories;

use App\Models\UserPost;
use App\Models\Hkj;
use App\Models\MiddleLevelInfo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserPostRepository
 * @package App\Repositories
 * @version February 28, 2019, 11:06 am CST
 *
 * @method UserPost findWithoutFail($id, $columns = ['*'])
 * @method UserPost find($id, $columns = ['*'])
 * @method UserPost first($columns = ['*'])
*/
class UserPostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserPost::class;
    }

    /**
     * 获取用户收藏状态
     * @param  [type] $user_id [description]
     * @param  [type] $post_id [description]
     * @param  string $type    [description]
     * @return [type]          [description]
     */
    public function userCollectStatus($user_id,$post_id,$type = 'hkj')
    {
        return UserPost::where('user_id',$user_id)
                ->where('post_id',$post_id)
                ->where('type',$type)
                ->first();
    }

    /**
     * 发起收藏操作
     * @param  [type] $user_id [description]
     * @param  [type] $post_id [description]
     * @param  string $type    [description]
     * @return [type]          [description]
     */
    public function collectAction($user_id,$post_id,$type = 'hkj')
    {
        $collect = $this->userCollectStatus($user_id,$post_id,$type);
        $action = '收藏成功';
        if($collect)
        {
            $action = '取消收藏成功';
            $collect->delete();
        }
        else{
            UserPost::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
                'type'    => $type
            ]);
        }
        return zcjy_callback_data($action);
    }


    public function userTypeList($user_id,$type = 'hkj')
    {
        $id_arr = [];
        $list = UserPost::where('user_id',$user_id)->where('type',$type)->get();
        foreach ($list as $key => $item) {
            $id_arr[] = $item->post_id;
        }
        $posts = [];
        if($type == 'hkj')
        {
             $posts = Hkj::whereIn('id',$id_arr)->get();
        }
        else{
             $posts = MiddleLevelInfo::whereIn('id',$id_arr)->get();
        }

        if(count($posts))
        {
            foreach ($posts as $key => $post) 
            {
                $post['publish_info'] = app('commonRepo')->AmazingManPostRepo()->pulishManObj($post->id,$type);
            } 
        }
  

        return $posts;
    }

    /**
     * 用户收藏列表
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function userCollectList($user_id)
    {
        $soundPosts = $this->userTypeList($user_id,'soundPost');
        $hkjs = $this->userTypeList($user_id,'hkj');
        return zcjy_callback_data(['soundPosts'=>$soundPosts,'hkjs'=>$hkjs]);
    }

    /**
     * 搜索文章
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function searchPosts($input)
    {
        if(isset($input['query']) && !empty($input['query']))
        {
            $hkjs = Hkj::where('name','like','%'.$input['query'].'%')->get();
            $soundPosts = MiddleLevelInfo::where('title','like','%'.$input['query'].'%')->get();
             return zcjy_callback_data(['soundPosts'=>$soundPosts,'hkjs'=>$hkjs]);
        }
        else{
            return zcjy_callback_data('请传入查询参数后查询',1);
        }
    }



}
