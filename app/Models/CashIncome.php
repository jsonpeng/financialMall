<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CashIncome
 * @package App\Models
 * @version May 7, 2018, 2:42 pm CST
 *
 * @property integer user_id
 * @property string type
 * @property float count
 * @property string des
 * @property integer from_user_id
 */
class CashIncome extends Model
{
    use SoftDeletes;

    public $table = 'cash_incomes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'type',
        'count',
        'des',
        'custorm_name',
        'custorm_mobile'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'type' => 'string',
        'count' => 'float',
        'des' => 'string',
        'from_user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required'
    ];

    
}
