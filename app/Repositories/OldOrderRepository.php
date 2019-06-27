<?php

namespace App\Repositories;

use App\Models\OldOrder;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @version November 20, 2017, 10:47 am CST
 *
 * @method Order findWithoutFail($id, $columns = ['*'])
 * @method Order find($id, $columns = ['*'])
 * @method Order first($columns = ['*'])
*/
class OldOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'money',
        'pay_no'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OldOrder::class;
    }
}
