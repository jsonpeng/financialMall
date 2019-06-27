<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreditCardBank
 * @package App\Models
 * @version December 13, 2017, 3:54 pm CST
 *
 * @property string name
 * @property string image
 * @property integer sort
 */
class CreditCardBank extends Model
{
    use SoftDeletes;

    public $table = 'credit_card_banks';
    
    // protected $connection = 'mysql-xyk';
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


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
        'name' => 'required',
        'image' => 'required'
    ];

    
}
