<?php

namespace App\Repositories;

use App\Models\XykNew;
use InfyOm\Generator\Common\BaseRepository;

use Cache;

/**
 * Class XykNewRepository
 * @package App\Repositories
 * @version August 30, 2018, 3:51 pm CST
 *
 * @method XykNew findWithoutFail($id, $columns = ['*'])
 * @method XykNew find($id, $columns = ['*'])
 * @method XykNew first($columns = ['*'])
*/
class XykNewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'applier',
        'hot',
        'intro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return XykNew::class;
    }

    public function sortedAll()
    {
        return Cache::remember('XykNew_all', 10, function(){
            return XykNew::orderBy('sort', 'desc')->get();
        });
    }
}
