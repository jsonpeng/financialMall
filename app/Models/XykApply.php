<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class XykApply
 * @package App\Models
 * @version March 2, 2018, 2:51 pm CST
 *
 * @property string name
 * @property string mobile
 * @property string info
 */
class XykApply extends Model
{
    use SoftDeletes;

    public $table = 'xyk_applies';
    
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'mobile',
        'info'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'mobile' => 'string',
        'info' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'mobile' => 'required',
        'info' => 'required'
    ];

    
}
