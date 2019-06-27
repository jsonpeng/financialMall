<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductLevelPrice
 * @package App\Models
 * @version February 11, 2019, 11:44 am CST
 *
 * @property integer product_id
 * @property string type
 * @property integer level_id
 */
class ProductLevelPrice extends Model
{
    use SoftDeletes;

    public $table = 'product_level_prices';
    
    protected $dates = ['deleted_at'];

    protected $connection = 'mysql-shop';

    public $fillable = [
        'product_id',
        'type',
        'price',
        'level_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_id' => 'integer',
        'type' => 'string',
        'level_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function level()
    {
        return $this->belongsTo('App\Models\UserLevel','level_id','id');
    }

    
}
