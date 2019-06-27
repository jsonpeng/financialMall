<?php

namespace App\Repositories;

use App\Models\OldProduct;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductRepository
 * @package App\Repositories
 * @version November 14, 2017, 2:53 pm CST
 *
 * @method Product findWithoutFail($id, $columns = ['*'])
 * @method Product find($id, $columns = ['*'])
 * @method Product first($columns = ['*'])
*/
class OldProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'price',
        'des',
        'sales',
        'intro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OldProduct::class;
    }


    public function mem_intro()
    {
        return OldProduct::first();
    }
}
