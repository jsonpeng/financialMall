<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class XykIntro
 * @package App\Models
 * @version March 2, 2018, 2:48 pm CST
 *
 * @property longtext intro
 */
class XykIntro extends Model
{
    use SoftDeletes;

    public $table = 'xyk_intros';
    
    protected $connection = 'mysql-shop';
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
