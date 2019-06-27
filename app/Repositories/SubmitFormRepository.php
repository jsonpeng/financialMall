<?php

namespace App\Repositories;

use App\Models\SubmitForm;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SubmitFormRepository
 * @package App\Repositories
 * @version June 8, 2018, 10:25 am CST
 *
 * @method SubmitForm findWithoutFail($id, $columns = ['*'])
 * @method SubmitForm find($id, $columns = ['*'])
 * @method SubmitForm first($columns = ['*'])
*/
class SubmitFormRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_name',
        'mobile',
        'province',
        'city',
        'district',
        'message',
        'extro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SubmitForm::class;
    }
}
