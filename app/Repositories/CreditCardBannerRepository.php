<?php

namespace App\Repositories;

use App\Models\CreditCardBanner;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CreditCardBannerRepository
 * @package App\Repositories
 * @version December 20, 2017, 2:26 pm CST
 *
 * @method CreditCardBanner findWithoutFail($id, $columns = ['*'])
 * @method CreditCardBanner find($id, $columns = ['*'])
 * @method CreditCardBanner first($columns = ['*'])
*/
class CreditCardBannerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'image',
        'link',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditCardBanner::class;
    }
}
