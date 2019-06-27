<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserPost
 * @package App\Models
 * @version February 28, 2019, 11:06 am CST
 *
 * @property integer user_id
 * @property string type
 */
class UserPost extends Model
{
    use SoftDeletes;

    public $table = 'user_posts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'post_id',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'post_id integer text'
    ];

    
}
