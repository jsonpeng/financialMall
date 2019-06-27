<?php

namespace App\Repositories;

use App\Models\MoneyRecord;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MoneyRecordRepository
 * @package App\Repositories
 * @version October 25, 2017, 9:58 am CST
 *
 * @method MoneyRecord findWithoutFail($id, $columns = ['*'])
 * @method MoneyRecord find($id, $columns = ['*'])
 * @method MoneyRecord first($columns = ['*'])
*/
class MoneyRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'money',
        'status',
        'type',
        'info'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MoneyRecord::class;
    }
}
