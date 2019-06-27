<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class XykNew
 * @package App\Models
 * @version August 30, 2018, 3:51 pm CST
 *
 * @property string name
 * @property string image
 * @property integer applier
 * @property integer hot
 * @property string intro
 */
class XykNew extends Model
{
    use SoftDeletes;

    public $table = 'xyk_news';

    //protected $connection = 'mysql-xyk-new';
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'applier',
        'hot',
        'intro',
        'link',
        'sort'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'applier' => 'integer',
        'hot' => 'integer',
        'intro' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'image' => 'required'
    ];

    
}
