<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TigerResult
 * @package App\Models
 * @version February 23, 2019, 5:00 pm CST
 *
 * @property integer user_id
 * @property integer coin_in
 * @property integer coin_out
 * @property integer result
 * @property string account
 */
class TigerResult extends Model
{
    use SoftDeletes;

    public $table = 'tiger_results';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'coin_in',
        'coin_out',
        'result',
        'account'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'coin_in' => 'integer',
        'coin_out' => 'integer',
        'result' => 'integer',
        'account' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
