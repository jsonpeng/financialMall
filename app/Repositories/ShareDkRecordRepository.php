<?php

namespace App\Repositories;

use App\Models\ShareDkRecord;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShareDkRecordRepository
 * @package App\Repositories
 * @version May 26, 2018, 6:48 pm CST
 *
 * @method ShareDkRecord findWithoutFail($id, $columns = ['*'])
 * @method ShareDkRecord find($id, $columns = ['*'])
 * @method ShareDkRecord first($columns = ['*'])
*/
class ShareDkRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'terminal_id',
        'user_id',
        'type',
        'product_id',
        'status',
        'amount',
        'shenpi'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShareDkRecord::class;
    }
}
