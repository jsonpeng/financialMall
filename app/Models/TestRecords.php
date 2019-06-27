<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TestRecords
 * @package App\Models
 * @version June 25, 2018, 10:44 am CST
 *
 * @property integer user_id
 * @property integer paper_id
 * @property integer paper_type_id
 * @property integer topic_num
 * @property integer is_pass
 * @property integer grade
 */
class TestRecords extends Model
{
    use SoftDeletes;

    public $table = 'test_records';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'paper_id',
        'paper_type_id',
        'topic_num',
        'is_pass',
        'grade'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'paper_id' => 'integer',
        'paper_type_id' => 'integer',
        'topic_num' => 'integer',
        'is_pass' => 'integer',
        'grade' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'topic_num' => 'required',
        'grade'  => 'required'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function paper(){
        return $this->belongsTo('App\Models\PaperList','paper_id','id');
    }

    public function papertype(){
        return $this->belongsTo('App\Models\PaperType','paper_type_id','id');
    }

    
}
