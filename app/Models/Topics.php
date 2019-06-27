<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Topics
 * @package App\Models
 * @version June 25, 2018, 10:16 am CST
 *
 * @property string name
 * @property integer paper_id
 * @property integer sort
 */
class Topics extends Model
{
    use SoftDeletes;

    public $table = 'topics';

    // protected $connection = 'mysql-post';
    protected $connection = 'mysql-shop';

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'paper_id',
        'sort'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'paper_id' => 'integer',
        'sort' => 'integer'
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
