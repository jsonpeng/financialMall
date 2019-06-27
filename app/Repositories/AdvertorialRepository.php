<?php

namespace App\Repositories;

use App\Models\Advertorial;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AdvertorialRepository
 * @package App\Repositories
 * @version May 6, 2018, 10:35 pm CST
 *
 * @method Advertorial findWithoutFail($id, $columns = ['*'])
 * @method Advertorial find($id, $columns = ['*'])
 * @method Advertorial first($columns = ['*'])
*/
class AdvertorialRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'account',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Advertorial::class;
    }
}
