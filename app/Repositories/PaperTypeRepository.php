<?php

namespace App\Repositories;

use App\Models\PaperType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PaperTypeRepository
 * @package App\Repositories
 * @version June 25, 2018, 9:47 am CST
 *
 * @method PaperType findWithoutFail($id, $columns = ['*'])
 * @method PaperType find($id, $columns = ['*'])
 * @method PaperType first($columns = ['*'])
*/
class PaperTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PaperType::class;
    }

}
