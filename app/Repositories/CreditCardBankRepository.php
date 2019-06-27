<?php

namespace App\Repositories;

use App\Models\CreditCardBank;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CreditCardBankRepository
 * @package App\Repositories
 * @version December 13, 2017, 3:54 pm CST
 *
 * @method CreditCardBank findWithoutFail($id, $columns = ['*'])
 * @method CreditCardBank find($id, $columns = ['*'])
 * @method CreditCardBank first($columns = ['*'])
*/
class CreditCardBankRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditCardBank::class;
    }

    public function cacheAll()
    {
        return CreditCardBank::orderBy('sort','desc')->get();
    }
}
