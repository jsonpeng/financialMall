<?php

namespace App\Repositories;

use App\Models\CreditLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CreditLogRepository
 * @package App\Repositories
 * @version February 6, 2018, 5:53 pm CST
 *
 * @method CreditLog findWithoutFail($id, $columns = ['*'])
 * @method CreditLog find($id, $columns = ['*'])
 * @method CreditLog first($columns = ['*'])
*/
class CreditLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'time',
        'amount',
        'change',
        'detail',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditLog::class;
    }

    /**
     * 用户积分记录
     * @param  [type]  $user [description]
     * @param  integer $skip [description]
     * @param  integer $take [description]
     * @return [type]        [description]
     */
    public function creditLogs($user, $skip = 0, $take = 20,$type = 1)
    {
        $logs =  $user->creditLogs();
        if($type == 2)
        {
            $logs = $logs->where('change','>',0);
        }
        elseif($type == 3)
        {
            $logs = $logs->where('change','<',0);
        }
        $logs = $logs->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        $logs = app('commonRepo')->attachWeek($logs);
        return $logs;
    }
}
