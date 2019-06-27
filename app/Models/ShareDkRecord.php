<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShareDkRecord
 * @package App\Models
 * @version May 26, 2018, 6:48 pm CST
 *
 * @property string terminal_id
 * @property integer user_id
 * @property string type
 * @property integer product_id
 * @property string status
 * @property float amount
 * @property sting shenpi
 */
class ShareDkRecord extends Model
{
    use SoftDeletes;

    public $table = 'share_dk_records';
    

    protected $dates = ['deleted_at'];
    //protected $connection = 'mysql-shop';

    public $fillable = [
        'terminal_id',
        'user_id',
        'type',
        'product_id',
        'status',
        'amount',
        'shenpi',
        'applier_name',
        'applier_mobile',
        'shenfenzheng',
        'transNo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'terminal_id' => 'string',
        'user_id' => 'integer',
        'type' => 'string',
        'product_id' => 'integer',
        'status' => 'string',
        'amount' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
