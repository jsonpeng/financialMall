<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AmazingManPost
 * @package App\Models
 * @version February 18, 2019, 11:28 am CST
 *
 * @property integer admin_id
 * @property integer post_id
 * @property string type
 */
class AmazingManPost extends Model
{
    use SoftDeletes;

    public $table = 'amazing_man_posts';
    
    protected $dates = ['deleted_at'];
    
    protected $connection = 'mysql-shop';

    public $fillable = [
        'admin_id',
        'post_id',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'admin_id' => 'integer',
        'post_id' => 'integer',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
