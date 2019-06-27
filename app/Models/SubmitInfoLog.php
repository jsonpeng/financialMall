<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SubmitInfoLog
 * @package App\Models
 * @version September 27, 2018, 11:16 am CST
 *
 * @property string name
 * @property string mobile
 * @property string whether_mobile_lg_half_year
 * @property string whether_shimingzhi
 * @property integer age
 * @property string whether_has_xycard
 * @property string whether_normal_use
 * @property string whether_has_delay
 * @property string whether_give_xycard_log
 * @property integer zhimafen
 * @property string whether_is_wanghei
 * @property string whether_wangdai
 * @property string whether_had_job
 * @property string whether_has_shebao
 * @property string whether_has_gongjijin
 * @property string whether_is_student
 * @property string whether_has_xuexinwang
 * @property string whether_know_dk
 */
class SubmitInfoLog extends Model
{
    use SoftDeletes;

    public $table = 'submit_info_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
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
        'whether_know_dk',
        'shenfenzheng',
        'sex'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'mobile' => 'string',
        'whether_mobile_lg_half_year' => 'string',
        'whether_shimingzhi' => 'string',
        'age' => 'integer',
        'whether_has_xycard' => 'string',
        'whether_normal_use' => 'string',
        'whether_has_delay' => 'string',
        'whether_give_xycard_log' => 'string',
        'zhimafen' => 'integer',
        'whether_is_wanghei' => 'string',
        'whether_wangdai' => 'string',
        'whether_had_job' => 'string',
        'whether_has_shebao' => 'string',
        'whether_has_gongjijin' => 'string',
        'whether_is_student' => 'string',
        'whether_has_xuexinwang' => 'string',
        'whether_know_dk' => 'string'
    ];


    public static $rule = [
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
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
