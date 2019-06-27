<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserLevel
 * @package App\Models
 * @version March 17, 2018, 6:53 pm CST
 *
 * @property string name
 * @property string des
 * @property integer money
 */
class UserLevel extends Model
{
    use SoftDeletes;

    public $table = 'user_levels';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'des',
        'money',
        'days',
        'level',
        'level_money_11',
        'level_money_12',
        'attach_words'
        // 'level_money_21',
        // 'level_money_22',
        // 'level_money_31',
        // 'level_money_32',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'des' => 'string',
        'money' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'money' => 'required',
        'days' => 'required'
    ];

    
}
