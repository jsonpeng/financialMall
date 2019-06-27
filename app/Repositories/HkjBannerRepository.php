<?php

namespace App\Repositories;

use App\Models\HkjBanner;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class HkjBannerRepository
 * @package App\Repositories
 * @version November 14, 2017, 2:55 pm CST
 *
 * @method HkjBanner findWithoutFail($id, $columns = ['*'])
 * @method HkjBanner find($id, $columns = ['*'])
 * @method HkjBanner first($columns = ['*'])
*/
class HkjBannerRepository extends BaseRepository
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
        return HkjBanner::class;
    }
}
