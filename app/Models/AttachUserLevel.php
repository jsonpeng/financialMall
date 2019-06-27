<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttachUserLevel
 * @package App\Models
 * @version February 27, 2019, 3:21 pm CST
 *
 * @property integer user_id
 * @property integer level_id
 */
class AttachUserLevel extends Model
{
    use SoftDeletes;

    public $table = 'attach_user_levels';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'level_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'level_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
