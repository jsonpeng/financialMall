<?php

namespace App\Repositories;

use App\Models\CreditCard;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CreditCardRepository
 * @package App\Repositories
 * @version December 13, 2017, 3:58 pm CST
 *
 * @method CreditCard findWithoutFail($id, $columns = ['*'])
 * @method CreditCard find($id, $columns = ['*'])
 * @method CreditCard first($columns = ['*'])
*/
class CreditCardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'brief',
        'image',
        'view',
        'remark',
        'link',
        'hot'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditCard::class;
    }

    public function bankXyks($bank_id = null,$skip = 0,$take = 20)
    {
        $banks = CreditCard::orderBy('created_at','desc');

        if(!empty($bank_id))
        {
            $banks = $banks->where('credit_card_bank_id',$bank_id);
        }
        return $banks
        ->skip($skip)
        ->take($take)
        ->get();
    }
}
