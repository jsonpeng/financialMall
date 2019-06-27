<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Level
 * @package App\Models
 * @version February 27, 2019, 10:35 am CST
 *
 * @property string name
 */
class Level extends Model
{
    use SoftDeletes;

    public $table = 'levels';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'sort',
        'level1',
        'level2',
        'level3',
        'level_more',
        'level1_1',
        'level1_2',
        'level2_1',
        'level2_2'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    
}
