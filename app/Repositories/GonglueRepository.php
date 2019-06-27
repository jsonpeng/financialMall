<?php

namespace App\Repositories;

use App\Models\Gonglue;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GonglueRepository
 * @package App\Repositories
 * @version October 22, 2018, 4:41 pm CST
 *
 * @method Gonglue findWithoutFail($id, $columns = ['*'])
 * @method Gonglue find($id, $columns = ['*'])
 * @method Gonglue first($columns = ['*'])
*/
class GonglueRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'sort',
        'content',
        'shelf'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Gonglue::class;
    }
}
