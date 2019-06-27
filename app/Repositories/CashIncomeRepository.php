<?php

namespace App\Repositories;

use App\Models\CashIncome;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CashIncomeRepository
 * @package App\Repositories
 * @version May 7, 2018, 2:42 pm CST
 *
 * @method CashIncome findWithoutFail($id, $columns = ['*'])
 * @method CashIncome find($id, $columns = ['*'])
 * @method CashIncome first($columns = ['*'])
*/
class CashIncomeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'type',
        'count',
        'des',
        'from_user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CashIncome::class;
    }
}
