<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Live
 * @package App\Models
 * @version June 13, 2018, 9:09 am CST
 *
 * @property string name
 * @property string image
 * @property string content
 * @property string time
 * @property string end_time
 */
class Live extends Model
{
    use SoftDeletes;

    public $table = 'lives';

    // protected $connection = 'mysql-post';
    protected $connection = 'mysql-shop';

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'content',
        'time',
        'end_time',
        'member'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'content' => 'string',
        'time' => 'string',
        'end_time' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'image' => 'required',
        'content' => 'required',
        'time' => 'required',
        'end_time' => 'required'
    ];

    
}
