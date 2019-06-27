<?php

namespace App\Repositories;

use App\Models\ComplaintLog;
use InfyOm\Generator\Common\BaseRepository;
use Cache;
use App\Models\CheatWay;
use Log;
/**
 * Class ComplaintLogRepository
 * @package App\Repositories
 * @version March 8, 2019, 9:45 am CST
 *
 * @method ComplaintLog findWithoutFail($id, $columns = ['*'])
 * @method ComplaintLog find($id, $columns = ['*'])
 * @method ComplaintLog first($columns = ['*'])
*/
class ComplaintLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ComplaintLog::class;
    }

    /**
     * 获取所有的反馈类型
     * @return [type] [description]
     */
    public function allCheatWays()
    {
        return Cache::remember('get_all_cheat_ways',5,function(){
            return CheatWay::all();
        });

    }

    /**
     * 提交反馈意见
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function saveLog($input,$user)
    {
        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'type,content');

        #如果出现问题
        if($validator) 
        {
            return zcjy_callback_data($validator,1);
        }

        $input['user_id'] = $user->id;

        $image_arr = [];

        if(isset($input['image']))
        {
             $image_arr = explode(',',$input['image']);

             if(count($image_arr))
             {
                $i = 0;
                foreach ($image_arr as $key => $image) 
                {
                    $i++;
                    if($i<=3){
                        $input['image'.$i] = $image;
                    }
                }
             }
        }

        Log::info($input);

        #保存记录
        ComplaintLog::create($input);

        return zcjy_callback_data('保存成功');
    }
}
