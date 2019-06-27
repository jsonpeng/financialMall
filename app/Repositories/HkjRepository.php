<?php

namespace App\Repositories;

use App\Models\Hkj;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Log;

/**
 * Class HkjRepository
 * @package App\Repositories
 * @version November 14, 2017, 3:17 pm CST
 *
 * @method Hkj findWithoutFail($id, $columns = ['*'])
 * @method Hkj find($id, $columns = ['*'])
 * @method Hkj first($columns = ['*'])
*/
class HkjRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'intro',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Hkj::class;
    }

    public function getHkj($skip = 0, $take = 20, $cat = 0)
    {
        return Cache::remember('hkjs_'.$skip.'_'.$take.'_'.$cat, 10, function() use($skip, $take, $cat){
            $hkjs = Hkj::orderBy('hot', 'desc')->orderBy('created_at', 'desc');
            if ($cat != 0) {
                $hkjs = $hkjs->where('hkj_cat_id', $cat);
            }
            $hkjs = $hkjs->skip($skip)->take($take)->get();
            foreach ($hkjs as $key => $kecheng) 
            {
                $hkjs[$key] = app('commonRepo')->attachKeChenLevelInfo($kecheng);
                $kecheng['publish_info'] = app('commonRepo')->AmazingManPostRepo()->pulishManObj($kecheng->id,'hkj');
            }
            return $hkjs;
        });
    }
    //->select('id', 'name', 'image', 'view', 'intro', 'created_at')

    public function getHkjDetail($id,$user = null)
    {
        //return Cache::remember('hkj_'.$id.'_'.$user, 10, function() use($id,$user){
            $detail = $this->findWithoutFail($id);
            if(empty($detail))
            {
                return zcjy_callback_data('没有找到该文章',1);
            }
            $detail = app('commonRepo')->attachKeChenLevelInfo($detail);
            $detail['can_read'] = app('commonRepo')->varifyUserCanMem($user,$detail);
             return zcjy_callback_data([
                'detail'         => $detail,
                'publish_info'   => app('commonRepo')->AmazingManPostRepo()->pulishManObj($id,'hkj'),
                'collect_status' => app('commonRepo')->UserPostRepo()->userCollectStatus(optional($user)->id,$id,'hkj') ? 1 : 0
            ]);
        //});
    }
}
