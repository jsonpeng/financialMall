<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gonglue
 * @package App\Models
 * @version October 22, 2018, 4:41 pm CST
 *
 * @property string name
 * @property string image
 * @property integer sort
 * @property longtext content
 * @property integer shelf
 */
class Gonglue extends Model
{
    use SoftDeletes;

    public $table = 'gonglues';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'sort',
        'content',
        'shelf'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'sort' => 'integer',
        'shelf' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'image' => 'required',
        'content' => 'required'
    ];

    
}
