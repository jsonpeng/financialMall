<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HkjCat
 * @package App\Models
 * @version December 13, 2017, 3:40 pm CST
 *
 * @property string name
 * @property string image
 * @property integer sort
 * @property integer shoufei
 */
class HkjCat extends Model
{
    use SoftDeletes;

    public $table = 'hkj_cats';
    
    // protected $connection = 'mysql-post';

    protected $dates = ['deleted_at'];
    protected $connection = 'mysql-shop';

    public $fillable = [
        'name',
        'image',
        'sort',
        'shoufei'
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
        'shoufei' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        // 'image' => 'required'
    ];

    //分类下的文章
    public function posts(){
        return $this->hasMany('App\Models\Hkj');
    }
}
