<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 * @version November 14, 2017, 2:53 pm CST
 *
 * @property string name
 * @property string image
 * @property float price
 * @property string des
 * @property integer sales
 * @property longtext intro
 */
class OldProduct extends Model
{
    use SoftDeletes;

    public $table = 'old_products';

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'price',
        'des',
        'sales',
        'intro'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'price' => 'float',
        'sales' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        // 'image' => 'required'
    ];

    
}
