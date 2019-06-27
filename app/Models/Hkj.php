<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Hkj
 * @package App\Models
 * @version November 14, 2017, 3:17 pm CST
 *
 * @property string name
 * @property longtext intro
 * @property string image
 */
class Hkj extends Model
{
    use SoftDeletes;

    public $table = 'hkjs';
    
    // protected $connection = 'mysql-post';
    protected $connection = 'mysql-shop';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'intro',
        'image',
        'view',
        'hot',
        'free_info',
        'free',
        'level',
        'level_name',
        'hkj_cat_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'intro' => 'required'
    ];

    //黑科技所属的分类
    public function cat(){
        return $this->belongsTo('App\Models\HkjCat', 'hkj_cat_id');
    }

    public function getTimeAgoAttribute($value)
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getIsHotAttribute()
    {
        return $this->hot ? '是' : '否';
    }

    public function getDesAttribute(){
        global $Briefing_Length; 
        mb_regex_encoding("UTF-8");     
        $Foremost = mb_substr($this->intro, 0, 50); 
        $re = "<(\/?) 
    (P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|TABLE|TR|TD|TH|INPUT|SELECT|TEXTAREA|OBJECT|A|UL|OL|LI| 
    BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|SPAN)[^>]*(>?)"; 
        $Single = "/BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|BR/i";     

        $Stack = array(); $posStack = array(); 

        mb_ereg_search_init($Foremost, $re, 'i'); 

        while($pos = mb_ereg_search_pos()){ 
            $match = mb_ereg_search_getregs(); 

            if($match[1]==""){ 
                $Elem = $match[2]; 
                if(mb_eregi($Single, $Elem) && $match[3] !=""){ 
                    continue; 
                } 
                array_push($Stack, mb_strtoupper($Elem)); 
                array_push($posStack, $pos[0]);             
            }else{ 
                $StackTop = $Stack[count($Stack)-1]; 
                $End = mb_strtoupper($match[2]); 
                if(strcasecmp($StackTop,$End)==0){ 
                    array_pop($Stack); 
                    array_pop($posStack); 
                    if($match[3] ==""){ 
                        $Foremost = $Foremost.">"; 
                    } 
                } 
            } 
        } 

        $cutpos = array_shift($posStack) - 1;     
        $Foremost =  mb_substr($Foremost,0,$cutpos,"UTF-8"); 
        $Foremost .= '...';
        return strip_tags($Foremost); 

    }
}
