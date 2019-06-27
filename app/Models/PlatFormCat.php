<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlatFormCat
 * @package App\Models
 * @version December 13, 2017, 3:46 pm CST
 *
 * @property string name
 * @property string image
 * @property integer sort
 */
class PlatFormCat extends Model
{
    use SoftDeletes;

    public $table = 'plat_form_cats';

    protected $dates = ['deleted_at'];

    // protected $connection = 'mysql-xyk';
    protected $connection = 'mysql-shop';
    public $fillable = [
        'name',
        'image',
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
        'sort' => 'integer'
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
