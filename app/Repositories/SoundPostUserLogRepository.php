<?php

namespace App\Repositories;

use App\Models\SoundPostUserLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SoundPostUserLogRepository
 * @package App\Repositories
 * @version March 7, 2019, 10:22 am CST
 *
 * @method SoundPostUserLog findWithoutFail($id, $columns = ['*'])
 * @method SoundPostUserLog find($id, $columns = ['*'])
 * @method SoundPostUserLog first($columns = ['*'])
*/
class SoundPostUserLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'last_see_time',
        'sound_post_id',
        'whether_end'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SoundPostUserLog::class;
    }
}
