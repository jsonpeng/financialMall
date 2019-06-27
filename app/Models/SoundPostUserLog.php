<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SoundPostUserLog
 * @package App\Models
 * @version March 7, 2019, 10:22 am CST
 *
 * @property integer user_id
 * @property string last_see_time
 * @property integer sound_post_id
 * @property integer whether_end
 */
class SoundPostUserLog extends Model
{
    use SoftDeletes;

    public $table = 'sound_post_user_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'last_see_time',
        'sound_post_id',
        'whether_end'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'last_see_time' => 'string',
        'sound_post_id' => 'integer',
        'whether_end' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
