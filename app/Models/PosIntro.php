<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PosIntro
 * @package App\Models
 * @version March 2, 2018, 2:50 pm CST
 *
 * @property longtext intro
 */
class PosIntro extends Model
{
    use SoftDeletes;

    public $table = 'pos_intros';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'intro'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'intro' => 'required'
    ];

    
}
