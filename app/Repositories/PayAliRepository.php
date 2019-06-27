<?php

namespace App\Repositories;

use App\Models\PayAli;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PayAliRepository
 * @package App\Repositories
 * @version April 27, 2018, 11:46 am CST
 *
 * @method PayAli findWithoutFail($id, $columns = ['*'])
 * @method PayAli find($id, $columns = ['*'])
 * @method PayAli first($columns = ['*'])
*/
class PayAliRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'app_id',
        'public_key',
        'private_key',
        'account_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PayAli::class;
    }
}
