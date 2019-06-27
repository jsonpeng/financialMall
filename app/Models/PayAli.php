<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PayAli
 * @package App\Models
 * @version April 27, 2018, 11:46 am CST
 *
 * @property string app_id
 * @property longtext public_key
 * @property longtext private_key
 * @property integer account_id
 */
class PayAli extends Model
{
    use SoftDeletes;

    public $table = 'pay_alis';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'app_id',
        'account'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'app_id' => 'string',
        'account' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'app_id' => 'required'
    ];

}
