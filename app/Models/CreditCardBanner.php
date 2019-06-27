<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreditCardBanner
 * @package App\Models
 * @version December 20, 2017, 2:26 pm CST
 *
 * @property string image
 * @property string link
 * @property integer sort
 */
class CreditCardBanner extends Model
{
    use SoftDeletes;

    public $table = 'credit_card_banners';
    
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
