<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JifenRecord
 * @package App\Models
 * @version July 28, 2018, 9:50 pm CST
 *
 * @property string oemChannelId
 * @property string clientNo
 * @property string channelTagId
 * @property string content
 * @property string type
 * @property float money_all
 * @property float money_user
 * @property float money_level1
 * @property float money_level2
 */
class JifenRecord extends Model
{
    use SoftDeletes;

    public $table = 'jifen_records';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'oemChannelId',
        'clientNo',
        'channelTagId',
        'content',
        'type',
        'bank',
        'title',
        'money_all',
        'money_user',
        'money_level1',
        'money_level2',
        'kefu',
        'transNo',
        'user_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'oemChannelId' => 'string',
        'clientNo' => 'string',
        'channelTagId' => 'string',
        'content' => 'string',
        'type' => 'string',
        'money_all' => 'float',
        'money_user' => 'float',
        'money_level1' => 'float',
        'money_level2' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
