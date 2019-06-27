<?php

namespace App\Repositories;

use App\Models\PlatFormCat;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PlatFormCatRepository
 * @package App\Repositories
 * @version December 13, 2017, 3:46 pm CST
 *
 * @method PlatFormCat findWithoutFail($id, $columns = ['*'])
 * @method PlatFormCat find($id, $columns = ['*'])
 * @method PlatFormCat first($columns = ['*'])
*/
class PlatFormCatRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PlatFormCat::class;
    }

    public function cacheAll()
    {
        return PlatFormCat::orderBy('sort','desc')->get();
    }
}
