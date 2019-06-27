<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SubmitForm
 * @package App\Models
 * @version June 8, 2018, 10:25 am CST
 *
 * @property string user_name
 * @property string mobile
 * @property string province
 * @property string city
 * @property string district
 * @property string message
 * @property string extro
 */
class SubmitForm extends Model
{
    use SoftDeletes;

    public $table = 'submit_forms';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_name',
        'mobile',
        'province',
        'city',
        'district',
        'message',
        'extro',
        'type',
        'xueli',
        'zhimafen',
        'email',
        'email_pass',
        'qq',
        'idcard',
        'marrage',
        'bank_count',
        'bank_name',
        'money_flow',
        'credit_card',
        'edu_used',
        'edu_all',
        'credit_card_extra',

        'house_money',
        'house_time',
        'house_bank',

        'car_money',
        'car_time',
        'car_bank',

        'address',
        'houce_owner',

        'company',
        'company_tel',
        'company_address',
        'zhiwei',
        'bumen',
        'gongling',
        'salary',
        'salary_way',

        'loan1_name',
        'loan1_money',
        'loan1_compay',

        'loan2_name',
        'loan2_money',
        'loan2_compay',

        'loan3_name',
        'loan3_money',
        'loan3_compay',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_name' => 'string',
        'mobile' => 'string',
        'province' => 'string',
        'city' => 'string',
        'district' => 'string',
        'message' => 'string',
        'extro' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mobile' => 'required',
        'type' => 'required'
    ];

    
}
