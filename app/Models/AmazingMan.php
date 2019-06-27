<?php

namespace App\Models;

use Eloquent as Model;
// use Spatie\Permission\Traits\HasRoles;

/**
 * Class AmazingMan
 * @package App\Models
 * @version February 15, 2019, 6:05 pm CST
 *
 * @property string name
 * @property string email
 * @property string password
 * @property string image
 * @property string job
 * @property string des
 * @property integer fans
 * @property string contact
 */
class AmazingMan extends Model
{

    public $table = 'admins';
    protected $connection = 'mysql-shop';

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'image',
        'job',
        'des',
        'fans',
        'contact',
        'type',
        'weixin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'     => 'required',
        'email'    => 'required',
        'password' => 'required'
    ];

    
}
