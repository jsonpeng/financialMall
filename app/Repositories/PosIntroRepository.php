<?php

namespace App\Repositories;

use App\Models\PosIntro;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PosIntroRepository
 * @package App\Repositories
 * @version March 2, 2018, 2:50 pm CST
 *
 * @method PosIntro findWithoutFail($id, $columns = ['*'])
 * @method PosIntro find($id, $columns = ['*'])
 * @method PosIntro first($columns = ['*'])
*/
class PosIntroRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'intro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PosIntro::class;
    }
}
