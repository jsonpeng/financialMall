<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\CashWithdraw;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $dates = ['member_end_time'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'header',
        'nickname',
        'sex',
        'province',
        'city',
        'country',
        'share_image',
        'openid',
        'level',
        'status',
        'parent_id',
        'money_all',
        'member',
        'member_buy_time',
        'member_end_time',
        'scale',
        'scale_level2',
        'money',
        'mobile',
        'money',
        'money_all',
        'level_name',
        'level_id',
        'member_buy_money',
        'share_code',
        'leader1',
        'leader2',
        'leader3',
        'level1',
        'level2',
        'level3',
        'intitor',
        'mem_level',
        'can_share',
        'level_money_11',
        'level_money_12',
        'level_money_21',
        'level_money_22',
        'level_money_31',
        'level_money_32',
        'alipay_account',
        'safe_code',
        'credits',
        'hongbao'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = [
        'name'          => 'required',
        'password'      => 'required',
        'mobile'        => 'required',
        'mobile_enter'  => 'required'
    ];


    //商品收藏
    public function collections(){
        return $this->belongsToMany('App\Models\Product', 'product_user', 'user_id', 'product_id');
    }

    //用户等级
    public function level(){
        return $this->belongsTo('App\Models\UserLevel', 'level_id', 'id');
    }

    //直接获取会员等级
    public function getUserLevelAttribute()
    {
        return $this->level()->first();
    }

    //用户地址
    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'id');
    }

    //用户的优惠券
    public function coupons()
    {
        return $this->hasMany('App\Models\CouponUser');
    }

    //用户的积分记录
    public function creditLogs()
    {
        return $this->hasMany('App\Models\CreditLog');
    }

    //会员订单
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
    *银行卡
    */
    public function bankcards(){
        return $this->hasMany('App\Models\BankCard');
    }

    public function tixian(){
        return $this->hasMany('App\Models\MoneyRecord');
    }

    public function getIsMemberAttribute(){
        if ($this->member) {
            return '是';
        } else {
            return '否';
        }
        
    }

    public function getMemberInfoAttribute(){
        if ($this->member) {
            return 'VIP会员';
        } else {
            return '非VIP会员';
        }
        
    }

    public function getMoenyPenddingAttribute(){
        return round(CashWithdraw::where('user_id', $this->id)->where('status', '待审核')->sum('count'), 2);
    }

    public function getMoenyDoneAttribute(){
        return round(CashWithdraw::where('user_id', $this->id)->where('status', '审核通过')->sum('count'), 2);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
