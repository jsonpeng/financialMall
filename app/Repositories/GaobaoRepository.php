<?php

namespace App\Repositories;

use App\Models\Gaobao;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GaobaoRepository
 * @package App\Repositories
 * @version July 25, 2018, 11:26 am CST
 *
 * @method Gaobao findWithoutFail($id, $columns = ['*'])
 * @method Gaobao find($id, $columns = ['*'])
 * @method Gaobao first($columns = ['*'])
*/
class GaobaoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'link'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Gaobao::class;
    }
}
