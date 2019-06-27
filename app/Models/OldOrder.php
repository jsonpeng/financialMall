<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @version November 20, 2017, 10:47 am CST
 *
 * @property integer user_id
 * @property float money
 * @property string pay_no
 */
class OldOrder extends Model
{
    use SoftDeletes;

    public $table = 'old_orders';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'money',
        'pay_no',
        'platform',
        'pay_status',
        'level_name',
        'level_id',
        'trade_no'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'money' => 'float',
        'pay_no' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'money' => 'required',
        'pay_no' => 'required'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    
}
