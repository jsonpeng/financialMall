<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaperType
 * @package App\Models
 * @version June 25, 2018, 9:47 am CST
 *
 * @property string name
 */
class PaperType extends Model
{
    use SoftDeletes;

    public $table = 'paper_types';

    // protected $connection = 'mysql-post';
    protected $connection = 'mysql-shop';

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'level'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
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
