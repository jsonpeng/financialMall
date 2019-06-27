<?php

namespace App\Repositories;

use App\Models\SysSetting;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Cache;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @version October 8, 2017, 3:49 pm CST
 *
 * @method Setting findWithoutFail($id, $columns = ['*'])
 * @method Setting find($id, $columns = ['*'])
 * @method Setting first($columns = ['*'])
*/
class SysSettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'intro',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SysSetting::class;
    }

    public function setting(){
        return Cache::remember('setting', 2, function(){
            return SysSetting::first();
        });
    }
}
