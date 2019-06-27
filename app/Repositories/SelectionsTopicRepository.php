<?php

namespace App\Repositories;

use App\Models\SelectionsTopic;
use InfyOm\Generator\Common\BaseRepository;
use Cache;

/**
 * Class SelectionsTopicRepository
 * @package App\Repositories
 * @version June 25, 2018, 10:32 am CST
 *
 * @method SelectionsTopic findWithoutFail($id, $columns = ['*'])
 * @method SelectionsTopic find($id, $columns = ['*'])
 * @method SelectionsTopic first($columns = ['*'])
*/
class SelectionsTopicRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'content',
        'topic_id',
        'is_result'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SelectionsTopic::class;
    }

    /**
     * [对应试题的选项]
     * @param  [type]  $topic_id [description]
     * @param  integer $result   [description]
     * @return [type]            [description]
     */
    public function topicSelects($topic_id,$result=0)
    {
        return Cache::remember('topics_selects_'.$topic_id.$result,10,function() use($topic_id,$result){
            $topics = SelectionsTopic::where('topic_id',$topic_id)->orderBy('created_at','asc');
            if($result){
                $topics = $topics->where('is_result',1);
            }
            $topics = $topics->get();
            return $topics;
        });

    }


}
