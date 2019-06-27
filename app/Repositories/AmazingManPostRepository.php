<?php

namespace App\Repositories;

use App\Models\AmazingManPost;
use InfyOm\Generator\Common\BaseRepository;
use App\Models\Admin;
use App\Models\Hkj;
use App\Models\SoundPost;

/**
 * Class AmazingManPostRepository
 * @package App\Repositories
 * @version February 18, 2019, 11:28 am CST
 *
 * @method AmazingManPost findWithoutFail($id, $columns = ['*'])
 * @method AmazingManPost find($id, $columns = ['*'])
 * @method AmazingManPost first($columns = ['*'])
*/
class AmazingManPostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'admin_id',
        'post_id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AmazingManPost::class;
    }

    /**
     * 达人发布文章的时候关联文章信息
     * @param  [type] $post_id [description]
     * @param  [type] $type    [description]
     * @param  string $action  [description]
     * @return [type]          [description]
     */
    public function syncSavePost($post_id,$type,$action = 'create')
    {
        $admin = auth('admin')->user();
        if($admin->type == '达人')
        {
            AmazingManPost::create([
                'admin_id'  => $admin->id,
                'post_id'   => $post_id,
                'type'      => $type
            ]);
        }
    }

    /**
     * 达人发布的文章信息
     * @param  [type] $admin_id [description]
     * @return [type]           [description]
     */
    public function amazingManPublishs($admin_id,$type = 'hkj')
    {
        $amazingManPostObj = AmazingManPost::where('admin_id',$admin_id)
                             ->where('type',$type)
                             ->get();
        $objIdArr = [];
        foreach ($amazingManPostObj as $key => $val) 
        {
            $objIdArr[] = $val->post_id;
        }

        if($type == 'hkj')
        {
            return Hkj::whereIn('id',$objIdArr);
        }
        elseif($type == 'soundPost')
        {
            return SoundPost::whereIn('id',$objIdArr);
        }
    }

    /**
     * 后台 达人/管理员 发布的信息类型
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public function adminAmazingManPublishs($type= 'hkj')
    {
        $admin = auth('admin')->user();
        if($admin->type == '管理员')
        {
            if($type == 'hkj')
            {
                return Hkj::orderBy('created_at','desc');
            }
            elseif($type == 'soundPost')
            {
                return SoundPost::orderBy('created_at','desc');
            }
        }
        elseif ($admin->type == '达人') 
        {
            return $this->amazingManPublishs($admin->id,$type)->orderBy('created_at','desc');
        }
    }

    /**
     * 发布人的名字
     * @param  [type] $post_id [description]
     * @param  string $type    [description]
     * @return [type]          [description]
     */
    public function publishManName($post_id,$type = 'hkj')
    {
        $admin = AmazingManPost::where('type',$type)
                ->where('post_id',$post_id)
                ->first();
                
        if(!empty($admin))
        {
            $admin = Admin::find($admin->admin_id);
            if(!empty($admin))
            {
                return $admin->name;
            }
        }
        else
        {
            return '平台管理员';
        }
    }

    public function pulishManObj($post_id,$type = 'hkj')
    {
        $name = $this->publishManName($post_id,$type);
        $man = Admin::where('name',$name)->first();
        return ['man'=>$man,'name'=>$name];
    }
}
