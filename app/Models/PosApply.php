<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PosApply
 * @package App\Models
 * @version March 2, 2018, 2:51 pm CST
 *
 * @property string name
 * @property string mobile
 * @property string info
 */
class PosApply extends Model
{
    use SoftDeletes;

    public $table = 'pos_applies';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'mobile',
        'info',
        'card_num',
        'address'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'mobile' => 'string',
        'info' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'mobile' => 'required',
        'info' => 'required'
    ];

    
}
