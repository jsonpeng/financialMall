<?php

namespace App\Repositories;

use App\Models\MiddleLevelInfo;
use InfyOm\Generator\Common\BaseRepository;

use Cache;
use Config;

/**
 * Class MiddleLevelInfoRepository
 * @package App\Repositories
 * @version June 11, 2018, 11:09 am CST
 *
 * @method MiddleLevelInfo findWithoutFail($id, $columns = ['*'])
 * @method MiddleLevelInfo find($id, $columns = ['*'])
 * @method MiddleLevelInfo first($columns = ['*'])
*/
class MiddleLevelInfoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'des',
        'type',
        'link',
        'intro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MiddleLevelInfo::class;
    }

    public function getById($id)
    {
        return Cache::remember('middle_level_info_'.$id, Config::get('zcjy.timecache'), function() use ($id){
            try {
                return $this->findWithoutFail($id);
            } catch (Exception $e) {
                return;
            }
        });
        
    }

    public function infoes($skip, $take, $level, $type)
    {
        return Cache::remember('infoes_'.$skip.'_'.$take.'_'.$level.'_'.$type, Config::get('zcjy.timecache'), function() use ($skip, $take, $level, $type){
            try {
                return MiddleLevelInfo::where('level', $level)
                    ->where('type', $type)
                    ->orderBy('created_at', 'desc')
                    ->skip($skip)
                    ->take($take)
                    ->get();
            } catch (Exception $e) {
                return;
            }
        });

    }
}
