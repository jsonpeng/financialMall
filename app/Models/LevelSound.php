<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LevelSound
 * @package App\Models
 * @version February 15, 2019, 1:59 pm CST
 *
 * @property integer level_info_id
 * @property integer sound_post_id
 */
class LevelSound extends Model
{
    use SoftDeletes;

    public $table = 'level_sounds';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'level_info_id',
        'sound_post_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'level_info_id' => 'integer',
        'sound_post_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
