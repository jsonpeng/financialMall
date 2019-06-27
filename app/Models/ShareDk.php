<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShareDk
 * @package App\Models
 * @version May 26, 2018, 6:45 pm CST
 *
 * @property string channel_name
 * @property string channel_id
 * @property string des
 * @property string image
 * @property string name
 * @property string return_type
 * @property float money_level1
 * @property float money_level2
 * @property float money_level3
 * @property string intro
 * @property integer applied
 * @property string share_base
 * @property string period
 * @property integer shelf
 */
class ShareDk extends Model
{
    use SoftDeletes;

    public $table = 'share_dks';
    

    protected $dates = ['deleted_at'];
    protected $connection = 'mysql-shop';

    public $fillable = [
        'channel_name',
        'channel_id',
        'des',
        'image',
        'name',
        'type',
        'return_type',
        'money_level1',
        'money_level2',
        'money_level3',
        'intro',
        'applied',
        'share_base',
        'period',
        'shelf',
        'max_mount',
        'rate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'channel_name' => 'string',
        'channel_id' => 'string',
        'des' => 'string',
        'image' => 'string',
        'name' => 'string',
        'return_type' => 'string',
        'money_level1' => 'float',
        'money_level2' => 'float',
        'money_level3' => 'float',
        'intro' => 'string',
        'applied' => 'integer',
        'share_base' => 'string',
        'period' => 'string',
        'shelf' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'channel_name' => 'required',
        'name' => 'required',
        'return_type' => 'required',
        'money_level1' => 'required'
    ];

    
}
