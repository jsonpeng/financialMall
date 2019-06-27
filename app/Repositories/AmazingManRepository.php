<?php

namespace App\Repositories;

use App\Models\Admin;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AmazingManRepository
 * @package App\Repositories
 * @version February 15, 2019, 6:05 pm CST
 *
 * @method AmazingMan findWithoutFail($id, $columns = ['*'])
 * @method AmazingMan find($id, $columns = ['*'])
 * @method AmazingMan first($columns = ['*'])
*/
class AmazingManRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'image',
        'job',
        'des',
        'fans',
        'contact',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Admin::class;
    }

    /**
     * 计算唯一性
     * @param  string $ziduan [description]
     * @param  [type] $val    [description]
     * @return [type]         [description]
     */
    public function countUnique($val = null,$ziduan = 'email')
    {
        return Admin::where($ziduan,$val)->count();
    }

    /**
     * 所有达人
     * @return [type] [description]
     */
    public function allMans($skip = 0 , $take = 20)
    {
        return Admin::where('type','达人')
        ->orderBy('created_at','desc')
        ->skip($skip)
        ->take($take)
        ->get();
    }

    /**
     * 获取达人详情
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getAmazingManDetail($id)
    {
        $admin = Admin::where('type','达人')->where('id',$id)->first();

        if(empty($admin))
        {
            return zcjy_callback_data('没有找到该达人',1);
        }

        #达人发布的黑科技文章
        $hkj = app('commonRepo')->AmazingManPostRepo()->amazingManPublishs($id,'hkj')->get();

        #达人发布的音频课程
        $soundPost = app('commonRepo')->AmazingManPostRepo()->amazingManPublishs($id,'soundPost')->get();

        return zcjy_callback_data([
            'detail'=>$admin,'hkj'=>$hkj,'soundPost'=>$soundPost
        ]);
    }
}
