<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tool
 * @package App\Models
 * @version March 30, 2018, 8:42 am CST
 *
 * @property string name
 * @property string image
 * @property string link
 */
class Tool extends Model
{
    use SoftDeletes;

    public $table = 'tools';
    
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'link',
        'mobile',
        'cat_id'
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
        'name' => 'required',
        'image' => 'required'
    ];

    public function cat()
    {
        return $this->belongsTo('App\Models\ToolCat','cat_id','id');
    }

    
}
