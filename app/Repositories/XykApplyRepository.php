<?php

namespace App\Repositories;

use App\Models\XykApply;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class XykApplyRepository
 * @package App\Repositories
 * @version March 2, 2018, 2:51 pm CST
 *
 * @method XykApply findWithoutFail($id, $columns = ['*'])
 * @method XykApply find($id, $columns = ['*'])
 * @method XykApply first($columns = ['*'])
*/
class XykApplyRepository extends BaseRepository
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
        return XykApply::class;
    }
}
