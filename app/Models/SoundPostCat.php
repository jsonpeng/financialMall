<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SoundPostCat
 * @package App\Models
 * @version March 1, 2019, 3:09 pm CST
 *
 * @property string name
 */
class SoundPostCat extends Model
{
    use SoftDeletes;

    public $table = 'sound_post_cats';
    
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
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
