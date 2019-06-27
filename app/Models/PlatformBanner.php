<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlatformBanner
 * @package App\Models
 * @version December 20, 2017, 2:25 pm CST
 *
 * @property string image
 * @property string link
 * @property integer sort
 */
class PlatformBanner extends Model
{
    use SoftDeletes;

    public $table = 'platform_banners';
    

    protected $dates = ['deleted_at'];
    protected $connection = 'mysql-shop';

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
