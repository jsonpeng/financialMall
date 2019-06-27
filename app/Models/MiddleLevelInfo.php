<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MiddleLevelInfo
 * @package App\Models
 * @version June 11, 2018, 11:09 am CST
 *
 * @property string title
 * @property string des
 * @property string type
 * @property string link
 * @property longtext intro
 */
class MiddleLevelInfo extends Model
{
    use SoftDeletes;

    public $table = 'middle_level_infos';

    // protected $connection = 'mysql-post';
    protected $connection = 'mysql-shop';

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'des',
        'type',
        'link',
        'intro',
        'image',
        'view',
        'level',
        'all_count_time',
        'jifen',
        'cat_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'des' => 'string',
        'type' => 'string',
        'link' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'image' => 'required',
        'title' => 'required',
        'des' => 'required',
        'level' => 'required',
        'link' => 'required'
    ];

    public function sounds(){
        return $this->belongsToMany('App\Models\SoundPost','level_sounds','level_info_id','sound_post_id');
    }

    public function soundPost(){
        return $this->belongsToMany('App\Models\SoundPost','level_sounds','level_info_id','sound_post_id');
    }

    public function cat()
    {
        return $this->belongsTo('App\Models\SoundPostCat','cat_id','id');
    }

    public function getCatNameAttribute()
    {
        $cat = $this->cat()->first();
        if(empty($cat))
        {
            return '无';
        }
        return $cat->name;
    }
    
}
