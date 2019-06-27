<?php

namespace App\Repositories;

use App\Models\CashWithdraw;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CashWithdrawRepository
 * @package App\Repositories
 * @version May 7, 2018, 1:52 pm CST
 *
 * @method CashWithdraw findWithoutFail($id, $columns = ['*'])
 * @method CashWithdraw find($id, $columns = ['*'])
 * @method CashWithdraw first($columns = ['*'])
*/
class CashWithdrawRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'count',
        'name',
        'zhifubao',
        'status',
        'trade_no',
        'out_trade_no',
        'reason',
        'account',
        'operate_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CashWithdraw::class;
    }
}
