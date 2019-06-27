<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gaobao
 * @package App\Models
 * @version July 25, 2018, 11:26 am CST
 *
 * @property string name
 * @property string image
 * @property string link
 */
class Gaobao extends Model
{
    use SoftDeletes;

    public $table = 'gaobaos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'link'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'link' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
