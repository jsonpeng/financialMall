<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MoneyRecord
 * @package App\Models
 * @version October 25, 2017, 9:58 am CST
 *
 * @property integer user_id
 * @property float money
 * @property string status
 * @property string type
 * @property string info
 */
class MoneyRecord extends Model
{
    use SoftDeletes;

    public $table = 'money_records';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'money',
        'status',
        'type',
        'info',
        'remark',
        'card_id',
        'name',
        'bank_name',
        'user_name',
        'mobile',
        'count',
        'pay_no'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'money' => 'float',
        'status' => 'string',
        'type' => 'string',
        'info' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'money' => 'required',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
