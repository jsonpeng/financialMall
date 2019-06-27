<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @version November 14, 2017, 3:05 pm CST
 *
 * @property string name
 * @property integer sort
 */
class PostCategory extends Model
{
    use SoftDeletes;

    public $table = 'post_categories';
    

    protected $dates = ['deleted_at'];

    //protected $connection = 'mysql-post';
    protected $connection = 'mysql-shop';

    public $fillable = [
        'name',
        'sort',
        'image',
        'shoufei'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'sort' => 'integer',
        'image' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

     //分类下的文章
    public function posts(){
        return $this->hasMany('App\Models\Post', 'category_id', 'id');
    }

    public function getPayAttribute()
    {
        if ($this->shoufei) {
            return '是';
        } else {
            return '否';
        }
        
    }
}
