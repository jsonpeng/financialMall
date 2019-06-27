<?php

namespace App\Repositories;

use App\Models\TestRecords;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TestRecordsRepository
 * @package App\Repositories
 * @version June 25, 2018, 10:44 am CST
 *
 * @method TestRecords findWithoutFail($id, $columns = ['*'])
 * @method TestRecords find($id, $columns = ['*'])
 * @method TestRecords first($columns = ['*'])
*/
class TestRecordsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'paper_id',
        'paper_type_id',
        'topic_num',
        'is_pass',
        'grade'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TestRecords::class;
    }

    public function paperTypeRecords($paper_type_id=null,$user_id,$skip=0,$take=12){
        return empty($paper_type_id) ? TestRecords::where('user_id',$user_id)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get() : TestRecords::where('paper_type_id',$paper_type_id)->where('user_id',$user_id)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
    }
}
