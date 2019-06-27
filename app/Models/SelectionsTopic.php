<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SelectionsTopic
 * @package App\Models
 * @version June 25, 2018, 10:32 am CST
 *
 * @property string type
 * @property string content
 * @property integer topic_id
 */
class SelectionsTopic extends Model
{
    use SoftDeletes;

    public $table = 'selections_topics';

    protected $connection = 'mysql-post';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'content',
        'topic_id',
        'is_result'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'content' => 'string',
        'topic_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
