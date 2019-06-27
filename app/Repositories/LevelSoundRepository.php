<?php

namespace App\Repositories;

use App\Models\LevelSound;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LevelSoundRepository
 * @package App\Repositories
 * @version February 15, 2019, 1:59 pm CST
 *
 * @method LevelSound findWithoutFail($id, $columns = ['*'])
 * @method LevelSound find($id, $columns = ['*'])
 * @method LevelSound first($columns = ['*'])
*/
class LevelSoundRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'level_info_id',
        'sound_post_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LevelSound::class;
    }
}
