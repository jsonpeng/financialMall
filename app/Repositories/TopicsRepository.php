<?php

namespace App\Repositories;

use App\Models\Topics;
use InfyOm\Generator\Common\BaseRepository;
use Cache;

/**
 * Class TopicsRepository
 * @package App\Repositories
 * @version June 25, 2018, 10:16 am CST
 *
 * @method Topics findWithoutFail($id, $columns = ['*'])
 * @method Topics find($id, $columns = ['*'])
 * @method Topics first($columns = ['*'])
*/
class TopicsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'paper_id',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Topics::class;
    }

    /**
     * [获取试卷下的题目的最后创建的第一个或者列表]
     * @param  [type]  $paper_id [description]
     * @param  boolean $first    [description]
     * @param  integer $skip     [description]
     * @param  integer $take     [description]
     * @return [type]            [description]
     */
    public function paperTopicsFirstOrAll($paper_id,$skip=0,$take=0)
    {
        return Cache::remember('zcjy_paper_lists_'.$paper_id.'_'.$skip.$take,10,function() use($paper_id,$skip,$take){

            $topics = Topics::where('paper_id',$paper_id);
       
            $topics = $topics->orderBy('sort','asc');

            if($skip)
            {
                $topics = $topics->skip($skip);
            }

            if($take)
            {
               $topics = $topics->take($take)->get();
            }
            else{
                $topics = $topics->get();
            }

            #给题目挂上选项和答案
            foreach ($topics as $key => $val) 
            {
              $val['selections'] = app('commonRepo')->selectionsTopicRepo()->topicSelects($val->id);
            }
            
            return $topics;

        });
             
    }


    public function paperTopicsCount($paper_id)
    {
         return Cache::remember('zcjy_paper_all_count_num'.$paper_id.'_',10,function() use($paper_id){
            return Topics::where('paper_id',$paper_id)->count();
         });
    }

}
