<?php

namespace App\Repositories;

use App\Models\XykIntro;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class XykIntroRepository
 * @package App\Repositories
 * @version March 2, 2018, 2:48 pm CST
 *
 * @method XykIntro findWithoutFail($id, $columns = ['*'])
 * @method XykIntro find($id, $columns = ['*'])
 * @method XykIntro first($columns = ['*'])
*/
class XykIntroRepository extends BaseRepository
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
        return XykIntro::class;
    }
}
