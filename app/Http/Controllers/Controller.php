<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
       /**
     * [默认直接通过数组的值 否则通过数组的键]
     * @param  [type] $input      [description]
     * @param  array  $attr       [description]
     * @param  string $valueOrKey [description]
     * @return [type]             [description]
     */
    public function varifyInputParamV2($input,$attr=[],$valueOrKey='value'){
        $status = false;
        #第一种带键值但值为空的情况
        foreach ($input as $key => $val) {
            if(array_key_exists($key,$input)){
                if(empty($input[$key]) && $input[$key]!=0){
                    $status = '请填完必填参数';
                }
            }
        }
        #第二种是针对提交的指定键值
        if(count($attr)){
            foreach ($attr as $key => $val) {
                if($valueOrKey == 'value'){
                    if(!array_key_exists($val,$input) || array_key_exists($val,$input) && empty($input[$val]) && $input[$val] != 0){
                        $status = '请填完必填参数';
                    }
                }
                else{
                     if(!array_key_exists($key,$input) || array_key_exists($key,$input) && empty($input[$key])){
                        $status = '请填完必填参数';
                    }
                }
            }
        }

        return $status;
    }

     public function modelRequiredParam($model,$return_array=false){
        $requireds = $model::$rules;
        $attr = [];
        foreach ($requireds as $key => $value) {
            array_push($attr,$key);
        }
        $attr = !$return_array ? implode(',',$attr) : $attr;
       return $attr;
    }
}
