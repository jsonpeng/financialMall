<?php

namespace App\Repositories;

use App\Models\ToolCat;
use InfyOm\Generator\Common\BaseRepository;
use App\Models\Tool;

/**
 * Class ToolCatRepository
 * @package App\Repositories
 * @version August 14, 2018, 10:34 pm CST
 *
 * @method ToolCat findWithoutFail($id, $columns = ['*'])
 * @method ToolCat find($id, $columns = ['*'])
 * @method ToolCat first($columns = ['*'])
*/
class ToolCatRepository extends BaseRepository
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
        return ToolCat::class;
    }




}
