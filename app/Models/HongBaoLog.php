<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HongBaoLog
 * @package App\Models
 * @version February 20, 2019, 10:37 pm CST
 *
 * @property string type
 * @property float count
 * @property string des
 * @property string status
 * @property string reason
 * @property string order_no
 * @property integer user_id
 * @property string ali_name
 * @property string ali_account
 * @property string trade_no
 * @property string out_trade_no
 * @property timestamp operation_time
 */
class HongBaoLog extends Model
{
    use SoftDeletes;

    public $table = 'hong_bao_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'count',
        'des',
        'status',
        'reason',
        'order_no',
        'user_id',
        'ali_name',
        'ali_account',
        'trade_no',
        'out_trade_no',
        'operation_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'count' => 'float',
        'des' => 'string',
        'status' => 'string',
        'reason' => 'string',
        'order_no' => 'string',
        'user_id' => 'integer',
        'ali_name' => 'string',
        'ali_account' => 'string',
        'trade_no' => 'string',
        'out_trade_no' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
