<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreditCardTheme
 * @package App\Models
 * @version December 13, 2017, 3:55 pm CST
 *
 * @property string name
 * @property string image
 * @property string brief
 * @property integer sort
 */
class CreditCardTheme extends Model
{
    use SoftDeletes;

    public $table = 'credit_card_themes';
    
    // protected $connection = 'mysql-xyk';
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'brief',
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
        'brief' => 'string',
        'sort' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'image' => 'required',
        'brief' => 'required'
    ];

    
}
