<?php

namespace App\Repositories;

use App\Models\PosApply;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PosApplyRepository
 * @package App\Repositories
 * @version March 2, 2018, 2:51 pm CST
 *
 * @method PosApply findWithoutFail($id, $columns = ['*'])
 * @method PosApply find($id, $columns = ['*'])
 * @method PosApply first($columns = ['*'])
*/
class PosApplyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'mobile',
        'info'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PosApply::class;
    }
}
