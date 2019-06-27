<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CashWithdraw
 * @package App\Models
 * @version May 7, 2018, 1:52 pm CST
 *
 * @property integer user_id
 * @property integer count
 * @property string name
 * @property string zhifubao
 * @property string status
 * @property string trade_no
 * @property string out_trade_no
 * @property string reason
 * @property string account
 * @property timestamp operate_time
 */
class CashWithdraw extends Model
{
    use SoftDeletes;

    public $table = 'cash_withdraws';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'count',
        'name',
        'zhifubao',
        'status',
        'trade_no',
        'out_trade_no',
        'reason',
        'account',
        'operate_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'count' => 'float',
        'name' => 'string',
        'zhifubao' => 'string',
        'status' => 'string',
        'trade_no' => 'string',
        'out_trade_no' => 'string',
        'reason' => 'string',
        'account' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'count' => 'required',
        'name' => 'required',
        'zhifubao' => 'required'
    ];

    
}
