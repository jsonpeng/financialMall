<?php

namespace App\Repositories;

use App\Models\PlatformBanner;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PlatformBannerRepository
 * @package App\Repositories
 * @version December 20, 2017, 2:25 pm CST
 *
 * @method PlatformBanner findWithoutFail($id, $columns = ['*'])
 * @method PlatformBanner find($id, $columns = ['*'])
 * @method PlatformBanner first($columns = ['*'])
*/
class PlatformBannerRepository extends BaseRepository
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
        return PlatformBanner::class;
    }
}
