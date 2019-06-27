<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaperList
 * @package App\Models
 * @version June 25, 2018, 9:57 am CST
 *
 * @property string name
 * @property string level
 * @property integer pass_grade
 */
class PaperList extends Model
{
    use SoftDeletes;

    public $table = 'paper_lists';

    // protected $connection = 'mysql-post';
    
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'level',
        'pass_grade',
        'paper_type_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'level' => 'string',
        'pass_grade' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        // 'paper_type_id' => 'required',
        'level' => 'required',
        'pass_grade' => 'required'
    ];

    public function type(){
        return $this->belongsTo('App\Models\PaperType','paper_type_id','id');
    }

    
}
