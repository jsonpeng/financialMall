<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ComplaintLog
 * @package App\Models
 * @version March 8, 2019, 9:45 am CST
 *
 * @property string type
 * @property string content
 */
class ComplaintLog extends Model
{
    use SoftDeletes;

    public $table = 'complaint_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'content',
        'user_id',
        'commit',
        'image1',
        'image2',
        'image3'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    
}
