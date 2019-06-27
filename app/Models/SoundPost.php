<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SoundPost
 * @package App\Models
 * @version February 15, 2019, 1:42 pm CST
 *
 * @property string name
 * @property string intro
 * @property string image
 * @property integer view
 * @property integer level
 * @property string level_name
 * @property string free_info
 */
class SoundPost extends Model
{
    use SoftDeletes;

    public $table = 'sound_posts';
    

    protected $dates = ['deleted_at'];
    protected $connection = 'mysql-shop';

    public $fillable = [
        'name',
        'intro',
        'image',
        'view',
        'level',
        'level_name',
        'free_info',
        'cat_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'intro' => 'string',
        'image' => 'string',
        'view' => 'integer',
        'level' => 'integer',
        'level_name' => 'string',
        'free_info' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'intro' => 'required'
    ];

    public function kechengs(){
        return $this->belongsToMany('App\Models\MiddleLevelInfo','level_sounds','sound_post_id','level_info_id');
    }

    public function cat()
    {
        return $this->belongsTo('App\Models\SoundPostCat','cat_id','id');
    }
    
}
