<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Setting
 * @package App\Models
 * @version October 8, 2017, 3:49 pm CST
 *
 * @property longtext intro
 * @property sring name
 */
class SysSetting extends Model
{
    use SoftDeletes;

    public $table = 'sys_settings';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'intro',
        'name',
        'scale',
        'law',
        'scale_level2',
        'share_content',
        'daili',
        'shoufei_xinyongka',
        'shoufei_jieqian',
        'post_per_page',
        'sms_id',
        'sms_key',
        'sms_sign',
        'sms_template',
        'min_cash',
        'max_cash_withdraw',
        'logo',
        'apk_link',
        'ios_link',
        'law_sale',
        'chat_link',
        'intro_text',
        'intro_voice',
        'base_share_img',
        'share_intro',
        'earn_intro',
        'tishi'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    
}
