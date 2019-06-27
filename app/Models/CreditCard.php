<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreditCard
 * @package App\Models
 * @version December 13, 2017, 3:58 pm CST
 *
 * @property string name
 * @property string brief
 * @property string image
 * @property integer view
 * @property string remark
 * @property string link
 * @property integer hot
 */
class CreditCard extends Model
{
    use SoftDeletes;

    public $table = 'credit_cards';
    
    // protected $connection = 'mysql-xyk';
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'brief',
        'image',
        'view',
        'remark',
        'link',
        'hot',
        'credit_card_bank_id',
        'credit_card_theme_id',
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
        'view' => 'integer',
        'remark' => 'string',
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

    public function bank(){
        return $this->belongsTo('App\Models\CreditCardBank', 'credit_card_bank_id');
    }

    public function theme(){
        return $this->belongsTo('App\Models\CreditCardTheme', 'credit_card_theme_id');
    }
}
