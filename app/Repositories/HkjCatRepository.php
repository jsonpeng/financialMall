<?php

namespace App\Repositories;

use App\Models\HkjCat;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Config;

/**
 * Class HkjCatRepository
 * @package App\Repositories
 * @version December 13, 2017, 3:40 pm CST
 *
 * @method HkjCat findWithoutFail($id, $columns = ['*'])
 * @method HkjCat find($id, $columns = ['*'])
 * @method HkjCat first($columns = ['*'])
*/
class HkjCatRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'sort',
        'shoufei'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return HkjCat::class;
    }

    // public function allCached()
    // {
    //     return Cache::remember('all_hkj_cats', 10, function(){
    //         return $this->all();
    //     });
    // }

    /**
     * 黑科技分类
     * @param string $value [description]
     */
    public function CacheAll()
    {
        return Cache::remember('hkj_allCats', Config::get('zcjy.timecache'), function() {
            try {
                return $this->all();
            } catch (Exception $e) {
                return;
            }
        });
    }
}
