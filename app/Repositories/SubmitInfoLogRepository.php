<?php

namespace App\Repositories;

use App\Models\SubmitInfoLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SubmitInfoLogRepository
 * @package App\Repositories
 * @version September 27, 2018, 11:16 am CST
 *
 * @method SubmitInfoLog findWithoutFail($id, $columns = ['*'])
 * @method SubmitInfoLog find($id, $columns = ['*'])
 * @method SubmitInfoLog first($columns = ['*'])
*/
class SubmitInfoLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'mobile',
        'whether_mobile_lg_half_year',
        'whether_shimingzhi',
        'age',
        'whether_has_xycard',
        'whether_normal_use',
        'whether_has_delay',
        'whether_give_xycard_log',
        'zhimafen',
        'whether_is_wanghei',
        'whether_wangdai',
        'whether_had_job',
        'whether_has_shebao',
        'whether_has_gongjijin',
        'whether_is_student',
        'whether_has_xuexinwang',
        'whether_know_dk'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SubmitInfoLog::class;
    }
}
