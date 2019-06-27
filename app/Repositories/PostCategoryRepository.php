<?php

namespace App\Repositories;

use App\Models\PostCategory;
use InfyOm\Generator\Common\BaseRepository;
use Cache;
use Config;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version November 14, 2017, 3:05 pm CST
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
*/
class PostCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PostCategory::class;
    }

    /**
     * 文章分类
     * @return [type] [description]
     */
    public function CacheAll()
    {
        return Cache::remember('post_allCats', Config::get('zcjy.timecache'), function() {
            try {
                return PostCategory::orderBy('sort', 'desc')->get();
            } catch (Exception $e) {
                return;
            }
        });
    }
}
