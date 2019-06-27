<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlatForm
 * @package App\Models
 * @version December 13, 2017, 3:49 pm CST
 *
 * @property string name
 * @property string brief
 * @property string image
 * @property integer star
 * @property string remark
 * @property integer view
 * @property string jiehao
 * @property string tiaojian
 * @property string cailiao
 * @property string link
 * @property integer hot
 */
class PlatForm extends Model
{
    use SoftDeletes;

    public $table = 'plat_forms';

    protected $dates = ['deleted_at'];

    // protected $connection = 'mysql-xyk';
    protected $connection = 'mysql-shop';
    public $fillable = [
        'name',
        'brief',
        'image',
        'star',
        'remark',
        'view',
        'jiehao',
        'tiaojian',
        'cailiao',
        'link',
        'hot',
        'sort',
        'edu_min',
        'edu_max',
        'time',
        'time_min',
        'time_max',
        'rate',
        'fangkuan',
        'plat_form_cat_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'brief' => 'string',
        'image' => 'string',
        'star' => 'integer',
        'remark' => 'string',
        'view' => 'integer',
        'jiehao' => 'string',
        'tiaojian' => 'string',
        'cailiao' => 'string',
        'link' => 'string',
        'hot' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'image' => 'required',
        'link' => 'required'
    ];

    public function getIsHotAttribute()
    {
        return $this->hot ? '是' : '否';
    }

    public function cat(){
        return $this->belongsTo('App\Models\PlatFormCat', 'plat_form_cat_id');
    }
}
