<?php

namespace App\Repositories;

use App\Models\ShareDk;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShareDkRepository
 * @package App\Repositories
 * @version May 26, 2018, 6:45 pm CST
 *
 * @method ShareDk findWithoutFail($id, $columns = ['*'])
 * @method ShareDk find($id, $columns = ['*'])
 * @method ShareDk first($columns = ['*'])
*/
class ShareDkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'channel_name',
        'channel_id',
        'des',
        'image',
        'name',
        'return_type',
        'money_level1',
        'money_level2',
        'money_level3',
        'intro',
        'applied',
        'share_base',
        'period',
        'shelf'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShareDk::class;
    }
}
