<?php

namespace App\Repositories;

use App\Models\Notice;
use InfyOm\Generator\Common\BaseRepository;

use Config;
use Cache;

/**
 * Class NoticeRepository
 * @package App\Repositories
 * @version November 22, 2017, 2:32 pm CST
 *
 * @method Notice findWithoutFail($id, $columns = ['*'])
 * @method Notice find($id, $columns = ['*'])
 * @method Notice first($columns = ['*'])
*/
class NoticeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'view',
        'intro',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notice::class;
    }

    public function CacheAll()
    {
        return Cache::remember('allNotices', Config::get('zcjy.timecache'), function() {
            try {
                return Notice::orderBy('created_at', 'desc')->get();
            } catch (Exception $e) {
                return;
            }
        });
    }

    public function getBuyID($id)
    {
        return Cache::remember('getBuyID_'.$id, Config::get('zcjy.timecache'), function() use ($id){
            try {
                return $this->findWithoutFail($id);
            } catch (Exception $e) {
                return;
            }
        });
    }
    

    public function PopNotice()
    {
        return Cache::remember('PopNotice', Config::get('zcjy.timecache'), function() {
            try {
                return Notice::where('popup', 1)->first();
            } catch (Exception $e) {
                return;
            }
        });
    }
}
