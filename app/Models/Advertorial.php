<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Advertorial
 * @package App\Models
 * @version May 6, 2018, 10:35 pm CST
 *
 * @property string account
 * @property longtext content
 */
class Advertorial extends Model
{
    use SoftDeletes;

    public $table = 'advertorials';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'account',
        'content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'account' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'account' => 'required'
    ];

    
}
