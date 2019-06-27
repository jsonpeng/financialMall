<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HkjBanner
 * @package App\Models
 * @version November 14, 2017, 2:55 pm CST
 *
 * @property string image
 * @property string link
 * @property integer sort
 */
class HkjBanner extends Model
{
    use SoftDeletes;

    public $table = 'hkj_banners';
    
    //protected $connection = 'mysql-post';
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'image',
        'link',
        'sort'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
        'link' => 'string',
        'sort' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'image' => 'required'
    ];

    
}
