<?php

namespace App\Repositories;

use App\Models\Live;
use InfyOm\Generator\Common\BaseRepository;

use Config;
use Cache;

/**
 * Class LiveRepository
 * @package App\Repositories
 * @version June 13, 2018, 9:09 am CST
 *
 * @method Live findWithoutFail($id, $columns = ['*'])
 * @method Live find($id, $columns = ['*'])
 * @method Live first($columns = ['*'])
*/
class LiveRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'content',
        'time',
        'end_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Live::class;
    }

    public function allCached($user)
    {
        return Cache::remember('active_lives'.$user->id, Config::get('zcjy.timecache'), function() use ($user) {
            try {
                $now = \Carbon\Carbon::now();
                $lives = Live::where('time', '<', $now)->where('end_time', '>', $now)->get();
                foreach ($lives as $key => $live) {
                      $live['can_read'] = 0;
                      if($user->member)
                      {
                            $live['can_read'] = 1;
                      }
                }
                return $lives;
            } catch (Exception $e) {
                return;
            }
        });
    }

    public function getById($id,$user)
    {
        return Cache::remember('live_id_'.$id.$user->id, Config::get('zcjy.timecache'), function() use($id,$user) {
            try {
                $live = $this->findWithoutFail($id);
                $live['can_read'] = 0;
                if($user->member)
                {
                    $live['can_read'] = 1;
                }
                return $live;
            } catch (Exception $e) {
                return;
            }
        });
    }
    
}
