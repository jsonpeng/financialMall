<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notice
 * @package App\Models
 * @version November 22, 2017, 2:32 pm CST
 *
 * @property string name
 * @property integer view
 * @property longtext intro
 * @property string image
 */
class Notice extends Model
{
    use SoftDeletes;

    public $table = 'notices';

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'view',
        'intro',
        'image',
        'popup'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'view' => 'integer',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    
}
