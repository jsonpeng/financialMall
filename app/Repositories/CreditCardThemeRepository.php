<?php

namespace App\Repositories;

use App\Models\CreditCardTheme;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CreditCardThemeRepository
 * @package App\Repositories
 * @version December 13, 2017, 3:55 pm CST
 *
 * @method CreditCardTheme findWithoutFail($id, $columns = ['*'])
 * @method CreditCardTheme find($id, $columns = ['*'])
 * @method CreditCardTheme first($columns = ['*'])
*/
class CreditCardThemeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'brief',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditCardTheme::class;
    }
}
