<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SpinResult
 * @package App\Models
 * @version February 23, 2019, 4:31 pm CST
 *
 * @property integer user_id
 * @property integer coin_in
 * @property integer coin_out
 * @property integer result
 */
class SpinResult extends Model
{
    use SoftDeletes;

    public $table = 'spin_results';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'coin_in',
        'coin_out',
        'account',
        'result',
        'name',
        'rec_name',
        'rec_mobile',
        'rec_address'
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
        'result' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
