<?php

namespace App\Repositories;

use App\Models\PaperList;
use InfyOm\Generator\Common\BaseRepository;
use Cache;

/**
 * Class PaperListRepository
 * @package App\Repositories
 * @version June 25, 2018, 9:57 am CST
 *
 * @method PaperList findWithoutFail($id, $columns = ['*'])
 * @method PaperList find($id, $columns = ['*'])
 * @method PaperList first($columns = ['*'])
*/
class PaperListRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'level',
        'pass_grade',
        'paper_type_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PaperList::class;
    }

    public function allTypeList($paper_type_id){
      return Cache::remember('zcjy_all_type_list_'.$paper_type_id,10,function() use ($paper_type_id){

            $list = PaperList::where('id','>',0);

            if(is_numeric($paper_type_id) && !empty($paper_type_id))
            {
                $list = $list->where('paper_type_id',$paper_type_id);
            }

            $list = $list->orderBy('created_at','desc')->get();
            #加上时间下的题目数量
            foreach ($list as $key => $val) {
                $val['topic_num'] =  app('commonRepo')->topicsRepo()->paperTopicsCount($val->id);
            }
            return $list;

        });

    }

}
