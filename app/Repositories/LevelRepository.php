<?php

namespace App\Repositories;

use App\Models\Level;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LevelRepository
 * @package App\Repositories
 * @version February 27, 2019, 10:35 am CST
 *
 * @method Level findWithoutFail($id, $columns = ['*'])
 * @method Level find($id, $columns = ['*'])
 * @method Level first($columns = ['*'])
*/
class LevelRepository extends BaseRepository
{
    use \ZcjyRepoTrait;
    /**
     * @var array
     */
    protected $fieldSearchable = 
    [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Level::class;
    }
}
